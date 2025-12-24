import { createClient } from '@supabase/supabase-js';


// Initialize database client
const supabaseUrl = 'https://sfmwcfoztoetelymcnyo.databasepad.com';
const supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6IjJlMTI1ZTJmLTk3OGYtNGM0ZC1iZDgxLTYwZWNlOTE1YmJjZCJ9.eyJwcm9qZWN0SWQiOiJzZm13Y2ZvenRvZXRlbHltY255byIsInJvbGUiOiJhbm9uIiwiaWF0IjoxNzY2NjE1MTI4LCJleHAiOjIwODE5NzUxMjgsImlzcyI6ImZhbW91cy5kYXRhYmFzZXBhZCIsImF1ZCI6ImZhbW91cy5jbGllbnRzIn0.EF7A88oGWUIVRN_v-taUU_E8fQTROz6IpDuI-NQGCx4';
const supabase = createClient(supabaseUrl, supabaseKey);


export { supabase };