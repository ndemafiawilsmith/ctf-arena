export interface Profile {
  id: string;
  username: string;
  total_score: number;
  is_admin: boolean;
  avatar_url?: string;
  created_at: string;
}

export interface CTFEvent {
  id: string;
  name: string;
  description: string;
  start_time: string;
  end_time: string;
  is_paid: boolean;
  price: number;
  cover_image_url: string;
  max_participants?: number;
  is_active: boolean;
  created_at: string;
}

export interface EventAccess {
  id: string;
  user_id: string;
  event_id: string;
  purchased_at: string;
  payment_method: string;
}

export interface AccessCode {
  id: string;
  code: string;
  event_id: string;
  is_used: boolean;
  used_by?: string;
  used_at?: string;
  generated_by: string;
  created_at: string;
}

export interface Challenge {
  id: string;
  event_id: string;
  title: string;
  description: string;
  category: string;
  points: number;
  difficulty: 'easy' | 'medium' | 'hard' | 'insane';
  external_link: string;
  flag_hash: string;
  hints?: string[];
  is_active: boolean;
  created_at: string;
}

export interface Solve {
  id: string;
  user_id: string;
  challenge_id: string;
  event_id: string;
  points_earned: number;
  created_at: string;
  profiles?: Profile;
}

export type ChallengeCategory = 'Web' | 'Pwn' | 'Forensics' | 'Crypto' | 'Reverse' | 'Misc';
