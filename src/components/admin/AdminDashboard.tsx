import React, { useState, useEffect } from 'react';
import { supabase } from '@/lib/supabase';
import { useAuth } from '@/contexts/AuthContext';
import { CTFEvent, Challenge, AccessCode } from '@/types/ctf';
import { 
  Plus, Trash2, Edit, Key, Loader2, Copy, CheckCircle, 
  Calendar, DollarSign, Users, Target, Shield, ArrowLeft,
  Download, RefreshCw
} from 'lucide-react';
import { toast } from 'sonner';

interface AdminDashboardProps {
  onBack: () => void;
}

const AdminDashboard: React.FC<AdminDashboardProps> = ({ onBack }) => {
  const { profile } = useAuth();
  const [activeTab, setActiveTab] = useState<'events' | 'challenges' | 'codes'>('events');
  const [events, setEvents] = useState<CTFEvent[]>([]);
  const [challenges, setChallenges] = useState<Challenge[]>([]);
  const [codes, setCodes] = useState<AccessCode[]>([]);
  const [loading, setLoading] = useState(true);
  const [selectedEvent, setSelectedEvent] = useState<string>('');

  // Form states
  const [showEventForm, setShowEventForm] = useState(false);
  const [showChallengeForm, setShowChallengeForm] = useState(false);
  const [generatingCodes, setGeneratingCodes] = useState(false);
  const [codeCount, setCodeCount] = useState(50);
  const [generatedCodes, setGeneratedCodes] = useState<string[]>([]);

  const [eventForm, setEventForm] = useState({
    name: '',
    description: '',
    start_time: '',
    end_time: '',
    is_paid: false,
    price: 0,
    cover_image_url: ''
  });

  const [challengeForm, setChallengeForm] = useState({
    event_id: '',
    title: '',
    description: '',
    category: 'Web',
    points: 100,
    difficulty: 'medium',
    external_link: '',
    flag: ''
  });

  useEffect(() => {
    fetchData();
  }, []);

  const fetchData = async () => {
    setLoading(true);
    
    const [eventsRes, challengesRes, codesRes] = await Promise.all([
      supabase.from('ctf_events').select('*').order('created_at', { ascending: false }),
      supabase.from('challenges').select('*').order('created_at', { ascending: false }),
      supabase.from('access_codes').select('*').order('created_at', { ascending: false })
    ]);

    if (eventsRes.data) setEvents(eventsRes.data);
    if (challengesRes.data) setChallenges(challengesRes.data);
    if (codesRes.data) setCodes(codesRes.data);
    
    setLoading(false);
  };

  const hashFlag = async (flag: string): Promise<string> => {
    const encoder = new TextEncoder();
    const data = encoder.encode(flag.trim());
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
  };

  const handleCreateEvent = async (e: React.FormEvent) => {
    e.preventDefault();
    
    const { error } = await supabase.from('ctf_events').insert({
      ...eventForm,
      price: eventForm.is_paid ? eventForm.price : 0
    });

    if (error) {
      toast.error('Failed to create event');
    } else {
      toast.success('Event created successfully');
      setShowEventForm(false);
      setEventForm({
        name: '',
        description: '',
        start_time: '',
        end_time: '',
        is_paid: false,
        price: 0,
        cover_image_url: ''
      });
      fetchData();
    }
  };

  const handleCreateChallenge = async (e: React.FormEvent) => {
    e.preventDefault();
    
    const flagHash = await hashFlag(challengeForm.flag);
    
    const { error } = await supabase.from('challenges').insert({
      event_id: challengeForm.event_id,
      title: challengeForm.title,
      description: challengeForm.description,
      category: challengeForm.category,
      points: challengeForm.points,
      difficulty: challengeForm.difficulty,
      external_link: challengeForm.external_link,
      flag_hash: flagHash
    });

    if (error) {
      toast.error('Failed to create challenge');
    } else {
      toast.success('Challenge created successfully');
      setShowChallengeForm(false);
      setChallengeForm({
        event_id: '',
        title: '',
        description: '',
        category: 'Web',
        points: 100,
        difficulty: 'medium',
        external_link: '',
        flag: ''
      });
      fetchData();
    }
  };

  const handleGenerateCodes = async () => {
    if (!selectedEvent) {
      toast.error('Please select an event');
      return;
    }

    setGeneratingCodes(true);
    setGeneratedCodes([]);

    try {
      const { data, error } = await supabase.functions.invoke('generate-codes', {
        body: { event_id: selectedEvent, count: codeCount }
      });

      if (error) throw error;

      if (data.success) {
        setGeneratedCodes(data.codes);
        toast.success(data.message);
        fetchData();
      } else {
        toast.error(data.message || 'Failed to generate codes');
      }
    } catch (err: any) {
      toast.error(err.message || 'Failed to generate codes');
    } finally {
      setGeneratingCodes(false);
    }
  };

  const copyAllCodes = () => {
    navigator.clipboard.writeText(generatedCodes.join('\n'));
    toast.success('Codes copied to clipboard');
  };

  const downloadCodes = () => {
    const eventName = events.find(e => e.id === selectedEvent)?.name || 'event';
    const blob = new Blob([generatedCodes.join('\n')], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${eventName.replace(/\s+/g, '_')}_codes.txt`;
    a.click();
    URL.revokeObjectURL(url);
  };

  if (!profile?.is_admin) {
    return (
      <div className="min-h-screen bg-[#0d0015] flex items-center justify-center">
        <div className="text-center">
          <Shield className="text-red-500 mx-auto mb-4" size={64} />
          <h2 className="text-2xl font-mono font-bold text-white mb-2">ACCESS_DENIED</h2>
          <p className="text-gray-400 font-mono">Admin privileges required</p>
        </div>
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
            <ArrowLeft size={16} />
            BACK_TO_HOME
          </button>
          <h1 className="text-3xl font-mono font-bold text-white flex items-center gap-3">
            <Shield className="text-[#00ff41]" />
            ADMIN_CONTROL_PANEL
          </h1>
        </div>
      </div>

      {/* Tabs */}
      <div className="max-w-7xl mx-auto px-6 py-4">
        <div className="flex gap-2 border-b border-[#00ff41]/20 pb-4">
          {(['events', 'challenges', 'codes'] as const).map(tab => (
            <button
              key={tab}
              onClick={() => setActiveTab(tab)}
              className={`px-6 py-2 rounded font-mono text-sm transition-all ${
                activeTab === tab
                  ? 'bg-[#00ff41] text-black'
                  : 'bg-black/30 text-gray-400 hover:text-white border border-[#00ff41]/20'
              }`}
            >
              {tab.toUpperCase()}
            </button>
          ))}
        </div>
      </div>

      {/* Content */}
      <div className="max-w-7xl mx-auto px-6 pb-12">
        {loading ? (
          <div className="flex justify-center py-12">
            <Loader2 className="animate-spin text-[#00ff41]" size={48} />
          </div>
        ) : (
          <>
            {/* Events Tab */}
            {activeTab === 'events' && (
              <div>
                <div className="flex justify-between items-center mb-6">
                  <h2 className="text-xl font-mono font-bold text-white">CTF_EVENTS</h2>
                  <button
                    onClick={() => setShowEventForm(true)}
                    className="flex items-center gap-2 px-4 py-2 bg-[#00ff41] text-black rounded font-mono text-sm font-bold hover:bg-[#00ff41]/80"
                  >
                    <Plus size={16} />
                    NEW_EVENT
                  </button>
                </div>

                {showEventForm && (
                  <form onSubmit={handleCreateEvent} className="bg-[#1a0b2e] border border-[#00ff41]/30 rounded-lg p-6 mb-6">
                    <h3 className="text-lg font-mono font-bold text-white mb-4">CREATE_EVENT</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <input
                        type="text"
                        placeholder="Event Name"
                        value={eventForm.name}
                        onChange={(e) => setEventForm({ ...eventForm, name: e.target.value })}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono"
                        required
                      />
                      <input
                        type="text"
                        placeholder="Cover Image URL"
                        value={eventForm.cover_image_url}
                        onChange={(e) => setEventForm({ ...eventForm, cover_image_url: e.target.value })}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono"
                      />
                      <input
                        type="datetime-local"
                        value={eventForm.start_time}
                        onChange={(e) => setEventForm({ ...eventForm, start_time: e.target.value })}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono"
                        required
                      />
                      <input
                        type="datetime-local"
                        value={eventForm.end_time}
                        onChange={(e) => setEventForm({ ...eventForm, end_time: e.target.value })}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono"
                        required
                      />
                      <textarea
                        placeholder="Description"
                        value={eventForm.description}
                        onChange={(e) => setEventForm({ ...eventForm, description: e.target.value })}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono md:col-span-2"
                        rows={3}
                      />
                      <div className="flex items-center gap-4">
                        <label className="flex items-center gap-2 text-white font-mono">
                          <input
                            type="checkbox"
                            checked={eventForm.is_paid}
                            onChange={(e) => setEventForm({ ...eventForm, is_paid: e.target.checked })}
                            className="w-4 h-4"
                          />
                          PAID_EVENT
                        </label>
                        {eventForm.is_paid && (
                          <input
                            type="number"
                            placeholder="Price"
                            value={eventForm.price}
                            onChange={(e) => setEventForm({ ...eventForm, price: parseFloat(e.target.value) })}
                            className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono w-32"
                            min="0"
                            step="0.01"
                          />
                        )}
                      </div>
                    </div>
                    <div className="flex gap-2 mt-4">
                      <button type="submit" className="px-4 py-2 bg-[#00ff41] text-black rounded font-mono font-bold">
                        CREATE
                      </button>
                      <button
                        type="button"
                        onClick={() => setShowEventForm(false)}
                        className="px-4 py-2 bg-gray-700 text-white rounded font-mono"
                      >
                        CANCEL
                      </button>
                    </div>
                  </form>
                )}

                <div className="grid gap-4">
                  {events.map(event => (
                    <div key={event.id} className="bg-[#1a0b2e] border border-[#00ff41]/20 rounded-lg p-4 flex items-center gap-4">
                      <img src={event.cover_image_url} alt="" className="w-16 h-16 rounded object-cover" />
                      <div className="flex-1">
                        <h4 className="font-mono font-bold text-white">{event.name}</h4>
                        <p className="text-gray-400 text-sm">{event.description?.slice(0, 100)}...</p>
                      </div>
                      <div className="text-right">
                        <div className={`font-mono text-sm ${event.is_paid ? 'text-purple-400' : 'text-[#00ff41]'}`}>
                          {event.is_paid ? `$${event.price}` : 'FREE'}
                        </div>
                        <div className="text-gray-500 text-xs font-mono">
                          {new Date(event.start_time).toLocaleDateString()}
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            )}

            {/* Challenges Tab */}
            {activeTab === 'challenges' && (
              <div>
                <div className="flex justify-between items-center mb-6">
                  <h2 className="text-xl font-mono font-bold text-white">CHALLENGES</h2>
                  <button
                    onClick={() => setShowChallengeForm(true)}
                    className="flex items-center gap-2 px-4 py-2 bg-[#00ff41] text-black rounded font-mono text-sm font-bold hover:bg-[#00ff41]/80"
                  >
                    <Plus size={16} />
                    NEW_CHALLENGE
                  </button>
                </div>

                {showChallengeForm && (
                  <form onSubmit={handleCreateChallenge} className="bg-[#1a0b2e] border border-[#00ff41]/30 rounded-lg p-6 mb-6">
                    <h3 className="text-lg font-mono font-bold text-white mb-4">CREATE_CHALLENGE</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <select
                        value={challengeForm.event_id}
                        onChange={(e) => setChallengeForm({ ...challengeForm, event_id: e.target.value })}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono"
                        required
                      >
                        <option value="">Select Event</option>
                        {events.map(e => (
                          <option key={e.id} value={e.id}>{e.name}</option>
                        ))}
                      </select>
                      <input
                        type="text"
                        placeholder="Challenge Title"
                        value={challengeForm.title}
                        onChange={(e) => setChallengeForm({ ...challengeForm, title: e.target.value })}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono"
                        required
                      />
                      <select
                        value={challengeForm.category}
                        onChange={(e) => setChallengeForm({ ...challengeForm, category: e.target.value })}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono"
                      >
                        <option value="Web">Web</option>
                        <option value="Pwn">Pwn</option>
                        <option value="Forensics">Forensics</option>
                        <option value="Crypto">Crypto</option>
                        <option value="Reverse">Reverse</option>
                        <option value="Misc">Misc</option>
                      </select>
                      <select
                        value={challengeForm.difficulty}
                        onChange={(e) => setChallengeForm({ ...challengeForm, difficulty: e.target.value })}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono"
                      >
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                        <option value="insane">Insane</option>
                      </select>
                      <input
                        type="number"
                        placeholder="Points"
                        value={challengeForm.points}
                        onChange={(e) => setChallengeForm({ ...challengeForm, points: parseInt(e.target.value) })}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono"
                        required
                      />
                      <input
                        type="url"
                        placeholder="TryHackMe URL"
                        value={challengeForm.external_link}
                        onChange={(e) => setChallengeForm({ ...challengeForm, external_link: e.target.value })}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono"
                        required
                      />
                      <textarea
                        placeholder="Description"
                        value={challengeForm.description}
                        onChange={(e) => setChallengeForm({ ...challengeForm, description: e.target.value })}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono md:col-span-2"
                        rows={2}
                      />
                      <input
                        type="text"
                        placeholder="Flag (e.g., flag{example})"
                        value={challengeForm.flag}
                        onChange={(e) => setChallengeForm({ ...challengeForm, flag: e.target.value })}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono md:col-span-2"
                        required
                      />
                    </div>
                    <div className="flex gap-2 mt-4">
                      <button type="submit" className="px-4 py-2 bg-[#00ff41] text-black rounded font-mono font-bold">
                        CREATE
                      </button>
                      <button
                        type="button"
                        onClick={() => setShowChallengeForm(false)}
                        className="px-4 py-2 bg-gray-700 text-white rounded font-mono"
                      >
                        CANCEL
                      </button>
                    </div>
                  </form>
                )}

                <div className="grid gap-4">
                  {challenges.map(challenge => (
                    <div key={challenge.id} className="bg-[#1a0b2e] border border-[#00ff41]/20 rounded-lg p-4 flex items-center gap-4">
                      <div className="w-12 h-12 rounded bg-[#00ff41]/20 flex items-center justify-center">
                        <Target className="text-[#00ff41]" size={24} />
                      </div>
                      <div className="flex-1">
                        <h4 className="font-mono font-bold text-white">{challenge.title}</h4>
                        <p className="text-gray-400 text-sm">{challenge.category} • {challenge.difficulty}</p>
                      </div>
                      <div className="text-right">
                        <div className="font-mono text-[#00ff41] font-bold">{challenge.points} pts</div>
                        <div className="text-gray-500 text-xs font-mono">
                          {events.find(e => e.id === challenge.event_id)?.name}
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            )}

            {/* Codes Tab */}
            {activeTab === 'codes' && (
              <div>
                <h2 className="text-xl font-mono font-bold text-white mb-6">STOCK_GENERATOR</h2>

                <div className="bg-[#1a0b2e] border border-[#00ff41]/30 rounded-lg p-6 mb-6">
                  <h3 className="text-lg font-mono font-bold text-white mb-4">GENERATE_ACCESS_CODES</h3>
                  <div className="flex flex-wrap gap-4 items-end">
                    <div>
                      <label className="block text-[#00ff41] font-mono text-sm mb-2">SELECT_EVENT</label>
                      <select
                        value={selectedEvent}
                        onChange={(e) => setSelectedEvent(e.target.value)}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono min-w-[200px]"
                      >
                        <option value="">Choose event...</option>
                        {events.filter(e => e.is_paid).map(e => (
                          <option key={e.id} value={e.id}>{e.name}</option>
                        ))}
                      </select>
                    </div>
                    <div>
                      <label className="block text-[#00ff41] font-mono text-sm mb-2">QUANTITY</label>
                      <input
                        type="number"
                        value={codeCount}
                        onChange={(e) => setCodeCount(parseInt(e.target.value))}
                        className="bg-black/50 border border-[#00ff41]/30 rounded px-4 py-2 text-white font-mono w-24"
                        min="1"
                        max="500"
                      />
                    </div>
                    <button
                      onClick={handleGenerateCodes}
                      disabled={generatingCodes || !selectedEvent}
                      className="flex items-center gap-2 px-6 py-2 bg-[#00ff41] text-black rounded font-mono font-bold hover:bg-[#00ff41]/80 disabled:opacity-50"
                    >
                      {generatingCodes ? (
                        <Loader2 className="animate-spin" size={16} />
                      ) : (
                        <Key size={16} />
                      )}
                      GENERATE
                    </button>
                  </div>

                  {generatedCodes.length > 0 && (
                    <div className="mt-6">
                      <div className="flex items-center justify-between mb-3">
                        <span className="text-[#00ff41] font-mono text-sm">
                          {generatedCodes.length} CODES_GENERATED
                        </span>
                        <div className="flex gap-2">
                          <button
                            onClick={copyAllCodes}
                            className="flex items-center gap-1 px-3 py-1 bg-black/50 text-gray-400 rounded font-mono text-sm hover:text-white"
                          >
                            <Copy size={14} />
                            COPY_ALL
                          </button>
                          <button
                            onClick={downloadCodes}
                            className="flex items-center gap-1 px-3 py-1 bg-black/50 text-gray-400 rounded font-mono text-sm hover:text-white"
                          >
                            <Download size={14} />
                            DOWNLOAD
                          </button>
                        </div>
                      </div>
                      <div className="bg-black/50 border border-[#00ff41]/20 rounded p-4 max-h-64 overflow-y-auto font-mono text-sm">
                        {generatedCodes.map((code, i) => (
                          <div key={i} className="text-[#00ff41] py-1">{code}</div>
                        ))}
                      </div>
                    </div>
                  )}
                </div>

                <h3 className="text-lg font-mono font-bold text-white mb-4">ALL_CODES</h3>
                <div className="bg-[#1a0b2e] border border-[#00ff41]/20 rounded-lg overflow-hidden">
                  <table className="w-full">
                    <thead className="bg-black/30">
                      <tr className="text-left font-mono text-sm text-gray-400">
                        <th className="px-4 py-3">CODE</th>
                        <th className="px-4 py-3">EVENT</th>
                        <th className="px-4 py-3">STATUS</th>
                        <th className="px-4 py-3">CREATED</th>
                      </tr>
                    </thead>
                    <tbody className="divide-y divide-[#00ff41]/10">
                      {codes.slice(0, 50).map(code => (
                        <tr key={code.id} className="text-sm">
                          <td className="px-4 py-3 font-mono text-white">{code.code}</td>
                          <td className="px-4 py-3 text-gray-400">
                            {events.find(e => e.id === code.event_id)?.name}
                          </td>
                          <td className="px-4 py-3">
                            {code.is_used ? (
                              <span className="text-red-400 font-mono text-xs">USED</span>
                            ) : (
                              <span className="text-[#00ff41] font-mono text-xs">AVAILABLE</span>
                            )}
                          </td>
                          <td className="px-4 py-3 text-gray-500 font-mono text-xs">
                            {new Date(code.created_at).toLocaleDateString()}
                          </td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              </div>
            )}
          </>
        )}
      </div>
    </div>
  );
};

export default AdminDashboard;
