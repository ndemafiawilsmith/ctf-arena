import { serve } from "https://deno.land/std@0.224.0/http/server.ts";
import { createClient } from "https://esm.sh/@supabase/supabase-js@2";

function randomCode(len = 12) {
  const chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789"; // avoid confusing chars
  let out = "";
  crypto.getRandomValues(new Uint8Array(len)).forEach((b) => out += chars[b % chars.length]);
  return out;
}

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

    const admin = createClient(supabaseUrl, serviceRoleKey);

    // Verify admin
    const { data: profile } = await admin.from("profiles").select("is_admin").eq("id", authData.user.id).single();
    if (!profile?.is_admin) return new Response(JSON.stringify({ success: false, message: "Admin only" }), { status: 403 });

    const { event_id, count } = await req.json();
    const qty = Math.min(Math.max(parseInt(count ?? 0), 1), 500);

    // Ensure event exists + paid
    const { data: event } = await admin.from("ctf_events").select("id,is_paid").eq("id", event_id).single();
    if (!event?.id) return new Response(JSON.stringify({ success: false, message: "Event not found" }), { status: 404 });

    const codes: string[] = [];
    const rows: any[] = [];

    for (let i = 0; i < qty; i++) {
      const code = `CTF-${randomCode(10)}`;
      codes.push(code);
      rows.push({ event_id, code });
    }

    const { error } = await admin.from("access_codes").insert(rows);
    if (error) return new Response(JSON.stringify({ success: false, message: error.message }), { status: 500 });

    return new Response(JSON.stringify({ success: true, message: "Codes generated", codes }), { status: 200 });
  } catch (e) {
    return new Response(JSON.stringify({ success: false, message: e?.message || "Unknown error" }), { status: 500 });
  }
});
