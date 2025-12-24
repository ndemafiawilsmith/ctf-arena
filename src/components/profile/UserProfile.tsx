import React, { useState, useEffect } from 'react';
import { supabase } from '@/lib/supabase';
import { useAuth } from '@/contexts/AuthContext';
import { Solve } from '@/types/ctf';
import { User, Trophy, Target, Calendar, Award, ArrowLeft, Shield } from 'lucide-react';

interface UserProfileProps {
  onBack: () => void;
}

const UserProfile: React.FC<UserProfileProps> = ({ onBack }) => {
  const { user, profile, refreshProfile } = useAuth();
  const [solves, setSolves] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);
  const [stats, setStats] = useState({
    totalSolves: 0,
    eventsParticipated: 0,
    rank: 0
  });

  useEffect(() => {
    if (user) {
      fetchUserData();
    }
  }, [user]);

  const fetchUserData = async () => {
    if (!user) return;

    // Fetch user's solves with challenge details
    const { data: solvesData } = await supabase
      .from('solves')
      .select(`
        *,
        challenges (title, category, points),
        ctf_events (name)
      `)
      .eq('user_id', user.id)
      .order('created_at', { ascending: false });

    if (solvesData) {
      setSolves(solvesData);
      
      // Calculate unique events
      const uniqueEvents = new Set(solvesData.map(s => s.event_id));
      
      setStats(prev => ({
        ...prev,
        totalSolves: solvesData.length,
        eventsParticipated: uniqueEvents.size
      }));
    }

    // Calculate rank
    const { data: profiles } = await supabase
      .from('profiles')
      .select('id, total_score')
      .order('total_score', { ascending: false });

    if (profiles) {
      const rank = profiles.findIndex(p => p.id === user.id) + 1;
      setStats(prev => ({ ...prev, rank }));
    }

    setLoading(false);
  };

  if (!user || !profile) {
    return (
      <div className="min-h-screen bg-[#0d0015] flex items-center justify-center">
        <p className="text-gray-400 font-mono">Please sign in to view your profile</p>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-[#0d0015]">
      {/* Header */}
      <div className="bg-gradient-to-r from-[#1a0b2e] to-[#0d0015] border-b border-[#00ff41]/20 p-6">
        <div className="max-w-4xl mx-auto">
          <button
            onClick={onBack}
            className="text-gray-400 hover:text-[#00ff41] font-mono text-sm mb-4 flex items-center gap-2"
          >
            <ArrowLeft size={16} />
            BACK_TO_HOME
          </button>
          
          <div className="flex items-center gap-6">
            <div className="w-24 h-24 rounded-full bg-[#00ff41]/20 flex items-center justify-center border-2 border-[#00ff41]/50">
              {profile.avatar_url ? (
                <img src={profile.avatar_url} alt="" className="w-full h-full rounded-full object-cover" />
              ) : (
                <User className="text-[#00ff41]" size={48} />
              )}
            </div>
            <div>
              <h1 className="text-3xl font-mono font-bold text-white flex items-center gap-3">
                {profile.username}
                {profile.is_admin && (
                  <Shield className="text-purple-400" size={24} title="Admin" />
                )}
              </h1>
              <p className="text-gray-400 font-mono text-sm mt-1">
                Member since {new Date(profile.created_at).toLocaleDateString()}
              </p>
            </div>
          </div>
        </div>
      </div>

      {/* Stats */}
      <div className="max-w-4xl mx-auto px-6 py-8">
        <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
          <div className="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg p-4 text-center">
            <Trophy className="text-yellow-400 mx-auto mb-2" size={24} />
            <div className="text-2xl font-mono font-bold text-[#00ff41]">{profile.total_score}</div>
            <div className="text-gray-500 font-mono text-xs">TOTAL_POINTS</div>
          </div>
          <div className="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg p-4 text-center">
            <Award className="text-purple-400 mx-auto mb-2" size={24} />
            <div className="text-2xl font-mono font-bold text-white">#{stats.rank || '-'}</div>
            <div className="text-gray-500 font-mono text-xs">GLOBAL_RANK</div>
          </div>
          <div className="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg p-4 text-center">
            <Target className="text-red-400 mx-auto mb-2" size={24} />
            <div className="text-2xl font-mono font-bold text-white">{stats.totalSolves}</div>
            <div className="text-gray-500 font-mono text-xs">CHALLENGES_SOLVED</div>
          </div>
          <div className="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg p-4 text-center">
            <Calendar className="text-blue-400 mx-auto mb-2" size={24} />
            <div className="text-2xl font-mono font-bold text-white">{stats.eventsParticipated}</div>
            <div className="text-gray-500 font-mono text-xs">EVENTS_JOINED</div>
          </div>
        </div>

        {/* Recent Solves */}
        <div className="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg overflow-hidden">
          <div className="p-4 border-b border-[#00ff41]/20">
            <h2 className="text-lg font-mono font-bold text-white">RECENT_SOLVES</h2>
          </div>
          
          {loading ? (
            <div className="p-8 text-center">
              <div className="animate-pulse text-gray-400 font-mono">Loading...</div>
            </div>
          ) : solves.length === 0 ? (
            <div className="p-8 text-center">
              <Target className="text-gray-600 mx-auto mb-4" size={48} />
              <p className="text-gray-400 font-mono">No challenges solved yet</p>
              <p className="text-gray-500 font-mono text-sm mt-2">Start hacking to see your progress here!</p>
            </div>
          ) : (
            <div className="divide-y divide-[#00ff41]/10">
              {solves.slice(0, 10).map((solve) => (
                <div key={solve.id} className="p-4 flex items-center justify-between hover:bg-[#00ff41]/5">
                  <div>
                    <h4 className="font-mono font-bold text-white">{solve.challenges?.title}</h4>
                    <p className="text-gray-500 font-mono text-xs">
                      {solve.ctf_events?.name} • {solve.challenges?.category}
                    </p>
                  </div>
                  <div className="text-right">
                    <div className="font-mono font-bold text-[#00ff41]">+{solve.points_earned} pts</div>
                    <div className="text-gray-500 font-mono text-xs">
                      {new Date(solve.created_at).toLocaleDateString()}
                    </div>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default UserProfile;
