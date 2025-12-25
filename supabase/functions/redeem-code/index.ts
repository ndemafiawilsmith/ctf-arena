import { serve } from "https://deno.land/std@0.224.0/http/server.ts";
import { createClient } from "https://esm.sh/@supabase/supabase-js@2";

serve(async (req) => {
  try {
    const supabaseUrl = Deno.env.get("SUPABASE_URL")!;
    const anonKey = Deno.env.get("SUPABASE_ANON_KEY")!;
    const serviceRoleKey = Deno.env.get("SUPABASE_SERVICE_ROLE_KEY")!;

    const userClient = createClient(supabaseUrl, anonKey, {
      global: { headers: { Authorization: req.headers.get("Authorization") || "" } },
    });

    const { data: authData } = await userClient.auth.getUser();
    if (!authData?.user) return new Response(JSON.stringify({ success: false, message: "Not authenticated" }), { status: 401 });

    const { event_id, code } = await req.json();
    if (!event_id || !code) return new Response(JSON.stringify({ success: false, message: "Missing event_id or code" }), { status: 400 });

    const admin = createClient(supabaseUrl, serviceRoleKey);

    // Load code row
    const { data: codeRow, error: codeErr } = await admin
      .from("access_codes")
      .select("id,event_id,is_used")
      .eq("code", String(code).trim())
      .single();

    if (codeErr || !codeRow) return new Response(JSON.stringify({ success: false, message: "Invalid code" }), { status: 200 });
    if (codeRow.event_id !== event_id) return new Response(JSON.stringify({ success: false, message: "Code not for this event" }), { status: 200 });
    if (codeRow.is_used) return new Response(JSON.stringify({ success: false, message: "Code already used" }), { status: 200 });

    // Atomic-ish: mark used, then grant access (unique constraint prevents duplicates)
    const { error: markErr } = await admin
      .from("access_codes")
      .update({ is_used: true, used_by: authData.user.id, used_at: new Date().toISOString() })
      .eq("id", codeRow.id)
      .eq("is_used", false);

    if (markErr) return new Response(JSON.stringify({ success: false, message: markErr.message }), { status: 500 });

    const { error: accessErr } = await admin
      .from("event_access")
      .insert({ user_id: authData.user.id, event_id, granted_via: "code" });

    if (accessErr) {
      return new Response(JSON.stringify({ success: false, message: accessErr.message }), { status: 500 });
    }

    return new Response(JSON.stringify({ success: true, message: "Access granted" }), { status: 200 });
  } catch (e) {
    return new Response(JSON.stringify({ success: false, message: e?.message || "Unknown error" }), { status: 500 });
  }
});
