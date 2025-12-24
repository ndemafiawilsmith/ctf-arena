import React, { useState, useEffect } from 'react';
import { supabase } from '@/lib/supabase';
import { Profile } from '@/types/ctf';
import { Trophy, Medal, Award, User, TrendingUp } from 'lucide-react';

interface LeaderboardProps {
  eventId?: string;
  showGlobal?: boolean;
}

interface LeaderboardEntry extends Profile {
  event_score?: number;
  rank?: number;
}

const Leaderboard: React.FC<LeaderboardProps> = ({ eventId, showGlobal = false }) => {
  const [entries, setEntries] = useState<LeaderboardEntry[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchLeaderboard();
    
    // Set up realtime subscription
    const channel = supabase
      .channel('leaderboard-changes')
      .on(
        'postgres_changes',
        { event: '*', schema: 'public', table: 'solves' },
        () => {
          fetchLeaderboard();
        }
      )
      .on(
        'postgres_changes',
        { event: '*', schema: 'public', table: 'profiles' },
        () => {
          fetchLeaderboard();
        }
      )
      .subscribe();

    return () => {
      supabase.removeChannel(channel);
    };
  }, [eventId]);

  const fetchLeaderboard = async () => {
    if (showGlobal || !eventId) {
      // Global leaderboard
      const { data, error } = await supabase
        .from('profiles')
        .select('*')
        .order('total_score', { ascending: false })
        .limit(50);

      if (!error && data) {
        setEntries(data.map((p, i) => ({ ...p, rank: i + 1 })));
      }
    } else {
      // Event-specific leaderboard
      const { data, error } = await supabase
        .from('solves')
        .select(`
          user_id,
          points_earned,
          profiles!inner(id, username, avatar_url)
        `)
        .eq('event_id', eventId);

      if (!error && data) {
        // Aggregate scores by user
        const scoreMap = new Map<string, { profile: any; score: number }>();
        
        data.forEach((solve: any) => {
          const userId = solve.user_id;
          const existing = scoreMap.get(userId);
          if (existing) {
            existing.score += solve.points_earned;
          } else {
            scoreMap.set(userId, {
              profile: solve.profiles,
              score: solve.points_earned
            });
          }
        });

        const sorted = Array.from(scoreMap.entries())
          .map(([_, value]) => ({
            ...value.profile,
            event_score: value.score
          }))
          .sort((a, b) => b.event_score - a.event_score)
          .map((entry, i) => ({ ...entry, rank: i + 1 }));

        setEntries(sorted);
      }
    }
    setLoading(false);
  };

  const getRankIcon = (rank: number) => {
    switch (rank) {
      case 1:
        return <Trophy className="text-yellow-400" size={24} />;
      case 2:
        return <Medal className="text-gray-300" size={24} />;
      case 3:
        return <Award className="text-amber-600" size={24} />;
      default:
        return <span className="text-gray-500 font-mono text-lg w-6 text-center">{rank}</span>;
    }
  };

  const getRankBg = (rank: number) => {
    switch (rank) {
      case 1:
        return 'bg-gradient-to-r from-yellow-500/20 to-transparent border-yellow-500/30';
      case 2:
        return 'bg-gradient-to-r from-gray-400/20 to-transparent border-gray-400/30';
      case 3:
        return 'bg-gradient-to-r from-amber-600/20 to-transparent border-amber-600/30';
      default:
        return 'bg-black/30 border-[#00ff41]/10';
    }
  };

  if (loading) {
    return (
      <div className="animate-pulse space-y-3">
        {[...Array(10)].map((_, i) => (
          <div key={i} className="h-14 bg-[#1a0b2e]/50 rounded-lg" />
        ))}
      </div>
    );
  }

  return (
    <div className="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg overflow-hidden">
      <div className="p-4 border-b border-[#00ff41]/20 flex items-center gap-3">
        <TrendingUp className="text-[#00ff41]" size={20} />
        <h3 className="font-mono font-bold text-white">
          {showGlobal || !eventId ? 'GLOBAL_RANKINGS' : 'EVENT_LEADERBOARD'}
        </h3>
        <span className="ml-auto text-gray-400 font-mono text-xs">
          {entries.length} players
        </span>
      </div>

      <div className="max-h-[500px] overflow-y-auto">
        {entries.length === 0 ? (
          <div className="p-8 text-center text-gray-400 font-mono">
            No scores yet. Be the first!
          </div>
        ) : (
          <div className="divide-y divide-[#00ff41]/10">
            {entries.map((entry) => (
              <div
                key={entry.id}
                className={`flex items-center gap-4 p-4 transition-colors hover:bg-[#00ff41]/5 ${getRankBg(entry.rank || 0)}`}
              >
                <div className="w-8 flex justify-center">
                  {getRankIcon(entry.rank || 0)}
                </div>

                <div className="w-10 h-10 rounded-full bg-[#00ff41]/20 flex items-center justify-center overflow-hidden">
                  {entry.avatar_url ? (
                    <img src={entry.avatar_url} alt="" className="w-full h-full object-cover" />
                  ) : (
                    <User className="text-[#00ff41]" size={20} />
                  )}
                </div>

                <div className="flex-1 min-w-0">
                  <div className="font-mono font-bold text-white truncate">
                    {entry.username}
                  </div>
                </div>

                <div className="text-right">
                  <div className="font-mono font-bold text-[#00ff41] text-lg">
                    {entry.event_score ?? entry.total_score}
                  </div>
                  <div className="font-mono text-xs text-gray-500">points</div>
                </div>
              </div>
            ))}
          </div>
        )}
      </div>
    </div>
  );
};

export default Leaderboard;
