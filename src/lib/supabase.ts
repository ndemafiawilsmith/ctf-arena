import { createClient } from '@supabase/supabase-js';


// Initialize database client
const supabaseUrl = 'https://eykuqjstzpdxbplqhsfy.supabase.co';
const supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImV5a3VxanN0enBkeGJwbHFoc2Z5Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjY2MDM0MjcsImV4cCI6MjA4MjE3OTQyN30.Z4kRCRs1orQsWXh8yU5SMR-DkBpdBGTW0Ig7cgvyPKI';
const supabase = createClient(supabaseUrl, supabaseKey);


export { supabase };