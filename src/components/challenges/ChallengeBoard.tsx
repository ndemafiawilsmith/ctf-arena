import React, { useState, useEffect } from 'react';
import { supabase } from '@/lib/supabase';
import { useAuth } from '@/contexts/AuthContext';
import { Challenge, Solve, ChallengeCategory } from '@/types/ctf';
import { ExternalLink, Flag, Loader2, CheckCircle, Trophy, Target, Shield, Search, Code, FileQuestion } from 'lucide-react';
import { toast } from 'sonner';

interface ChallengeBoardProps {
  eventId: string;
  eventName: string;
  onBack: () => void;
}

const categoryIcons: Record<string, React.ReactNode> = {
  'Web': <Code size={16} />,
  'Pwn': <Target size={16} />,
  'Forensics': <Search size={16} />,
  'Crypto': <Shield size={16} />,
  'Reverse': <Code size={16} />,
  'Misc': <FileQuestion size={16} />,
};

const difficultyColors: Record<string, string> = {
  'easy': 'text-green-400 border-green-400/30',
  'medium': 'text-yellow-400 border-yellow-400/30',
  'hard': 'text-orange-400 border-orange-400/30',
  'insane': 'text-red-400 border-red-400/30',
};

const ChallengeBoard: React.FC<ChallengeBoardProps> = ({ eventId, eventName, onBack }) => {
  const { user } = useAuth();
  const [challenges, setChallenges] = useState<Challenge[]>([]);
  const [solves, setSolves] = useState<Solve[]>([]);
  const [loading, setLoading] = useState(true);
  const [selectedCategory, setSelectedCategory] = useState<string>('All');
  const [flagInputs, setFlagInputs] = useState<Record<string, string>>({});
  const [submitting, setSubmitting] = useState<string | null>(null);

  useEffect(() => {
    fetchChallenges();
    fetchUserSolves();
  }, [eventId]);

  const fetchChallenges = async () => {
    const { data, error } = await supabase
      .from('challenges')
      .select('*')
      .eq('event_id', eventId)
      .eq('is_active', true)
      .order('points', { ascending: true });

    if (!error && data) {
      setChallenges(data);
    }
    setLoading(false);
  };

  const fetchUserSolves = async () => {
    if (!user) return;
    
    const { data, error } = await supabase
      .from('solves')
      .select('*')
      .eq('user_id', user.id)
      .eq('event_id', eventId);

    if (!error && data) {
      setSolves(data);
    }
  };

  const handleSubmitFlag = async (challengeId: string) => {
    const flag = flagInputs[challengeId];
    if (!flag?.trim()) {
      toast.error('Please enter a flag');
      return;
    }

    setSubmitting(challengeId);

    try {
      const { data, error } = await supabase.functions.invoke('submit-flag', {
        body: { challenge_id: challengeId, flag_guess: flag.trim() }
      });

      if (error) throw error;

      if (data.success) {
        toast.success(data.message);
        setSolves([...solves, { challenge_id: challengeId } as Solve]);
        setFlagInputs({ ...flagInputs, [challengeId]: '' });
        fetchUserSolves();
      } else {
        toast.error(data.message);
      }
    } catch (err: any) {
      toast.error(err.message || 'Failed to submit flag');
    } finally {
      setSubmitting(null);
    }
  };

  const categories = ['All', ...Array.from(new Set(challenges.map(c => c.category)))];
  const filteredChallenges = selectedCategory === 'All' 
    ? challenges 
    : challenges.filter(c => c.category === selectedCategory);

  const isSolved = (challengeId: string) => solves.some(s => s.challenge_id === challengeId);
  const totalPoints = solves.reduce((acc, s) => {
    const challenge = challenges.find(c => c.id === s.challenge_id);
    return acc + (challenge?.points || 0);
  }, 0);

  if (loading) {
    return (
      <div className="flex items-center justify-center h-64">
        <Loader2 className="animate-spin text-[#00ff41]" size={48} />
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-[#0d0015]">
      {/* Header */}
      <div className="bg-gradient-to-r from-[#1a0b2e] to-[#0d0015] border-b border-[#00ff41]/20 p-6">
        <div className="max-w-7xl mx-auto">
          <button
            onClick={onBack}
            className="text-gray-400 hover:text-[#00ff41] font-mono text-sm mb-4 flex items-center gap-2"
          >
            ← BACK_TO_EVENTS
          </button>
          <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
              <h1 className="text-3xl font-mono font-bold text-white">{eventName}</h1>
              <p className="text-gray-400 font-mono text-sm mt-1">
                {challenges.length} challenges • {solves.length} solved
              </p>
            </div>
            <div className="flex items-center gap-4">
              <div className="bg-black/30 border border-[#00ff41]/30 rounded-lg px-6 py-3">
                <div className="text-gray-400 font-mono text-xs">YOUR_SCORE</div>
                <div className="text-[#00ff41] font-mono text-2xl font-bold flex items-center gap-2">
                  <Trophy size={20} />
                  {totalPoints}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Category Filter */}
      <div className="max-w-7xl mx-auto px-6 py-4">
        <div className="flex flex-wrap gap-2">
          {categories.map(cat => (
            <button
              key={cat}
              onClick={() => setSelectedCategory(cat)}
              className={`px-4 py-2 rounded font-mono text-sm transition-all flex items-center gap-2 ${
                selectedCategory === cat
                  ? 'bg-[#00ff41] text-black'
                  : 'bg-black/30 text-gray-400 hover:text-white border border-[#00ff41]/20 hover:border-[#00ff41]/50'
              }`}
            >
              {cat !== 'All' && categoryIcons[cat]}
              {cat}
            </button>
          ))}
        </div>
      </div>

      {/* Challenge Grid */}
      <div className="max-w-7xl mx-auto px-6 pb-12">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredChallenges.map(challenge => {
            const solved = isSolved(challenge.id);
            
            return (
              <div
                key={challenge.id}
                className={`relative bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border rounded-lg overflow-hidden transition-all ${
                  solved 
                    ? 'border-[#00ff41]/50 shadow-lg shadow-[#00ff41]/10' 
                    : 'border-[#00ff41]/20 hover:border-[#00ff41]/40'
                }`}
              >
                {solved && (
                  <div className="absolute top-3 right-3 text-[#00ff41]">
                    <CheckCircle size={24} />
                  </div>
                )}

                <div className="p-5">
                  <div className="flex items-center gap-2 mb-3">
                    <span className="text-[#00ff41]">{categoryIcons[challenge.category]}</span>
                    <span className="text-gray-400 font-mono text-xs">{challenge.category}</span>
                    <span className={`ml-auto px-2 py-0.5 rounded border font-mono text-xs ${difficultyColors[challenge.difficulty]}`}>
                      {challenge.difficulty.toUpperCase()}
                    </span>
                  </div>

                  <h3 className={`text-lg font-mono font-bold mb-2 ${solved ? 'text-[#00ff41]' : 'text-white'}`}>
                    {challenge.title}
                  </h3>

                  <p className="text-gray-400 text-sm mb-4 line-clamp-2">
                    {challenge.description}
                  </p>

                  <div className="flex items-center justify-between mb-4">
                    <div className="text-[#00ff41] font-mono font-bold text-xl">
                      {challenge.points} pts
                    </div>
                    <a
                      href={challenge.external_link}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="flex items-center gap-2 px-3 py-1.5 bg-purple-600/20 text-purple-400 rounded font-mono text-xs hover:bg-purple-600/30 transition-colors"
                    >
                      <ExternalLink size={14} />
                      START_HACKING
                    </a>
                  </div>

                  {!solved && (
                    <div className="flex gap-2">
                      <input
                        type="text"
                        value={flagInputs[challenge.id] || ''}
                        onChange={(e) => setFlagInputs({ ...flagInputs, [challenge.id]: e.target.value })}
                        placeholder="flag{...}"
                        className="flex-1 bg-black/50 border border-[#00ff41]/30 rounded px-3 py-2 text-white font-mono text-sm focus:border-[#00ff41] focus:outline-none"
                        onKeyDown={(e) => e.key === 'Enter' && handleSubmitFlag(challenge.id)}
                      />
                      <button
                        onClick={() => handleSubmitFlag(challenge.id)}
                        disabled={submitting === challenge.id}
                        className="px-4 py-2 bg-[#00ff41] text-black rounded font-mono text-sm font-bold hover:bg-[#00ff41]/80 transition-colors disabled:opacity-50 flex items-center gap-1"
                      >
                        {submitting === challenge.id ? (
                          <Loader2 className="animate-spin" size={16} />
                        ) : (
                          <Flag size={16} />
                        )}
                      </button>
                    </div>
                  )}

                  {solved && (
                    <div className="bg-[#00ff41]/10 border border-[#00ff41]/30 rounded px-3 py-2 text-[#00ff41] font-mono text-sm text-center">
                      SOLVED
                    </div>
                  )}
                </div>
              </div>
            );
          })}
        </div>

        {filteredChallenges.length === 0 && (
          <div className="text-center py-12">
            <p className="text-gray-400 font-mono">No challenges found in this category</p>
          </div>
        )}
      </div>
    </div>
  );
};

export default ChallengeBoard;
