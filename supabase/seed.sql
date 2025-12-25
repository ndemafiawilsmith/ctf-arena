-- =========================
-- SEED EVENTS (UUID SAFE)
-- =========================

insert into public.ctf_events (
  name,
  description,
  start_time,
  end_time,
  is_paid,
  price,
  cover_image_url,
  is_active
) values
(
  'CyberStrike 2025',
  'The ultimate web exploitation challenge. Test your skills against real-world vulnerabilities.',
  now() + interval '1 day',
  now() + interval '3 days',
  true,
  49.99,
  'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615325814_941623af.jpg',
  true
),
(
  'Binary Blitz',
  'Reverse engineering and binary exploitation. Crack the code, own the system.',
  now(),
  now() + interval '7 days',
  false,
  0,
  'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615328442_4077514e.jpg',
  true
),
(
  'Crypto Chaos',
  'Cryptographic challenges from basic ciphers to advanced cryptanalysis.',
  now(),
  now() + interval '5 days',
  true,
  29.99,
  'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615329816_87fb351b.jpg',
  true
);



-- =========================
-- SEED CHALLENGES (UUID SAFE)
-- =========================

insert into public.challenges (
  event_id,
  title,
  description,
  category,
  difficulty,
  points,
  external_link,
  flag_hash,
  is_active
)
select
  e.id,
  'SQLi Warmup',
  'Exploit a classic SQL injection to retrieve the admin flag.',
  'Web',
  'easy',
  100,
  'https://tryhackme.com/room/sqlinjection',
  encode(digest('CTF{sql_injection_master}', 'sha256'), 'hex'),
  true
from public.ctf_events e
where e.name = 'CyberStrike 2025';

insert into public.challenges (
  event_id,
  title,
  description,
  category,
  difficulty,
  points,
  external_link,
  flag_hash,
  is_active
)
select
  e.id,
  'Auth Bypass',
  'Find a logic flaw and bypass authentication.',
  'Web',
  'medium',
  200,
  'https://tryhackme.com/room/authentication',
  encode(digest('CTF{auth_bypass}', 'sha256'), 'hex'),
  true
from public.ctf_events e
where e.name = 'CyberStrike 2025';

insert into public.challenges (
  event_id,
  title,
  description,
  category,
  difficulty,
  points,
  external_link,
  flag_hash,
  is_active
)
select
  e.id,
  'Crack the Binary',
  'Reverse engineer the binary and extract the hidden flag.',
  'Reverse',
  'medium',
  250,
  'https://tryhackme.com/room/reversing',
  encode(digest('CTF{binary_owned}', 'sha256'), 'hex'),
  true
from public.ctf_events e
where e.name = 'Binary Blitz';
