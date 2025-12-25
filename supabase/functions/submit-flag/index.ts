// supabase/functions/submit-flag/index.ts
import { serve } from "https://deno.land/std@0.224.0/http/server.ts";
import { createClient } from "https://esm.sh/@supabase/supabase-js@2";

function sha256Hex(input: string): Promise<string> {
  const data = new TextEncoder().encode(input.trim());
  return crypto.subtle.digest("SHA-256", data).then((buf) => {
    const bytes = new Uint8Array(buf);
    return Array.from(bytes).map((b) => b.toString(16).padStart(2, "0")).join("");
  });
}

serve(async (req) => {
  try {
    const supabaseUrl = Deno.env.get("SUPABASE_URL")!;
    const anonKey = Deno.env.get("SUPABASE_ANON_KEY")!;
    const serviceRoleKey = Deno.env.get("SUPABASE_SERVICE_ROLE_KEY")!;

    // Client bound to the caller (to read auth user)
    const userClient = createClient(supabaseUrl, anonKey, {
      global: { headers: { Authorization: req.headers.get("Authorization") || "" } },
    });

    const { data: authData, error: authErr } = await userClient.auth.getUser();
    if (authErr || !authData?.user) {
      return new Response(JSON.stringify({ success: false, message: "Not authenticated" }), { status: 401 });
    }

    const { challenge_id, flag_guess } = await req.json();
    if (!challenge_id || !flag_guess) {
      return new Response(JSON.stringify({ success: false, message: "Missing challenge_id or flag_guess" }), { status: 400 });
    }

    // Service role client to bypass RLS for secure checks + insert solve
    const admin = createClient(supabaseUrl, serviceRoleKey);

    // Load challenge
    const { data: challenge, error: chErr } = await admin
      .from("challenges")
      .select("id,event_id,points,flag_hash,is_active")
      .eq("id", challenge_id)
      .single();

    if (chErr || !challenge || !challenge.is_active) {
      return new Response(JSON.stringify({ success: false, message: "Challenge not found" }), { status: 404 });
    }

    // Check if already solved
    const { data: existing } = await admin
      .from("solves")
      .select("id")
      .eq("user_id", authData.user.id)
      .eq("challenge_id", challenge.id)
      .maybeSingle();

    if (existing) {
      return new Response(JSON.stringify({ success: false, message: "Already solved" }), { status: 200 });
    }

    // Verify flag
    const guessHash = await sha256Hex(flag_guess);
    if (guessHash !== challenge.flag_hash) {
      return new Response(JSON.stringify({ success: false, message: "Incorrect flag" }), { status: 200 });
    }

    // Insert solve (trigger will update profiles.total_score)
    const { error: insErr } = await admin.from("solves").insert({
      user_id: authData.user.id,
      event_id: challenge.event_id,
      challenge_id: challenge.id,
      points_earned: challenge.points,
    });

    if (insErr) {
      return new Response(JSON.stringify({ success: false, message: insErr.message }), { status: 500 });
    }

    return new Response(JSON.stringify({ success: true, message: "Flag accepted. Points awarded!" }), { status: 200 });
  } catch (e) {
    return new Response(JSON.stringify({ success: false, message: e?.message || "Unknown error" }), { status: 500 });
  }
});
