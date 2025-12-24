import React, { useState, useEffect } from 'react';
import { supabase } from '@/lib/supabase';
import { AuthProvider, useAuth } from '@/contexts/AuthContext';
import { CTFEvent, EventAccess } from '@/types/ctf';
import AuthModal from '@/components/ui/AuthModal';
import RedeemCodeModal from '@/components/ui/RedeemCodeModal';
import EventCard from '@/components/events/EventCard';
import ChallengeBoard from '@/components/challenges/ChallengeBoard';
import Leaderboard from '@/components/scoreboard/Leaderboard';
import AdminDashboard from '@/components/admin/AdminDashboard';
import UserProfile from '@/components/profile/UserProfile';
import { 
  Terminal, Shield, Trophy, Users, Zap, Target, 
  LogOut, User, ChevronRight, Github, Twitter, 
  Flag, Code, Lock, Unlock, Menu, X
} from 'lucide-react';
import { toast } from 'sonner';

const HERO_IMAGE = 'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615307390_81db8ad7.jpg';

const EVENT_IMAGES = [
  'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615325814_941623af.jpg',
  'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615328442_4077514e.jpg',
  'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615329816_87fb351b.jpg',
  'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615337046_9651aad7.png',
  'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615329958_27223867.jpg',
  'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615338388_262a270b.png',
];



// Demo events for display
const DEMO_EVENTS: CTFEvent[] = [
  {
    id: 'demo-1',
    name: 'CyberStrike 2025',
    description: 'The ultimate web exploitation challenge. Test your skills against real-world vulnerabilities.',
    start_time: new Date(Date.now() + 86400000).toISOString(),
    end_time: new Date(Date.now() + 86400000 * 3).toISOString(),
    is_paid: true,
    price: 49.99,
    cover_image_url: EVENT_IMAGES[0],
    is_active: true,
    created_at: new Date().toISOString()
  },
  {
    id: 'demo-2',
    name: 'Binary Blitz',
    description: 'Reverse engineering and binary exploitation. Crack the code, own the system.',
    start_time: new Date().toISOString(),
    end_time: new Date(Date.now() + 86400000 * 7).toISOString(),
    is_paid: false,
    price: 0,
    cover_image_url: EVENT_IMAGES[1],
    is_active: true,
    created_at: new Date().toISOString()
  },
  {
    id: 'demo-3',
    name: 'Crypto Chaos',
    description: 'Cryptographic challenges from basic ciphers to advanced cryptanalysis.',
    start_time: new Date().toISOString(),
    end_time: new Date(Date.now() + 86400000 * 5).toISOString(),
    is_paid: true,
    price: 29.99,
    cover_image_url: EVENT_IMAGES[2],
    is_active: true,
    created_at: new Date().toISOString()
  },
  {
    id: 'demo-4',
    name: 'Forensics Frontier',
    description: 'Digital forensics investigation. Analyze evidence, uncover the truth.',
    start_time: new Date(Date.now() - 86400000).toISOString(),
    end_time: new Date(Date.now() + 86400000 * 2).toISOString(),
    is_paid: false,
    price: 0,
    cover_image_url: EVENT_IMAGES[3],
    is_active: true,
    created_at: new Date().toISOString()
  },
  {
    id: 'demo-5',
    name: 'Network Nemesis',
    description: 'Network penetration testing challenges. Exploit, pivot, and escalate.',
    start_time: new Date(Date.now() + 86400000 * 10).toISOString(),
    end_time: new Date(Date.now() + 86400000 * 12).toISOString(),
    is_paid: true,
    price: 79.99,
    cover_image_url: EVENT_IMAGES[4],
    is_active: true,
    created_at: new Date().toISOString()
  },
  {
    id: 'demo-6',
    name: 'OSINT Olympics',
    description: 'Open source intelligence gathering. Find the hidden, expose the secrets.',
    start_time: new Date().toISOString(),
    end_time: new Date(Date.now() + 86400000 * 4).toISOString(),
    is_paid: false,
    price: 0,
    cover_image_url: EVENT_IMAGES[5],
    is_active: true,
    created_at: new Date().toISOString()
  },
];

const MainContent: React.FC = () => {
  const { user, profile, signOut, loading: authLoading } = useAuth();
  const [events, setEvents] = useState<CTFEvent[]>(DEMO_EVENTS);
  const [userAccess, setUserAccess] = useState<EventAccess[]>([]);
  const [showAuthModal, setShowAuthModal] = useState(false);
  const [showRedeemModal, setShowRedeemModal] = useState(false);
  const [selectedEvent, setSelectedEvent] = useState<CTFEvent | null>(null);
  const [currentView, setCurrentView] = useState<'home' | 'event' | 'admin'>('home');
  const [activeEventId, setActiveEventId] = useState<string>('');
  const [activeEventName, setActiveEventName] = useState<string>('');
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  useEffect(() => {
    fetchEvents();
    if (user) {
      fetchUserAccess();
    }
  }, [user]);

  const fetchEvents = async () => {
    const { data, error } = await supabase
      .from('ctf_events')
      .select('*')
      .eq('is_active', true)
      .order('start_time', { ascending: true });

    if (!error && data && data.length > 0) {
      setEvents(data);
    }
  };

  const fetchUserAccess = async () => {
    if (!user) return;
    
    const { data, error } = await supabase
      .from('event_access')
      .select('*')
      .eq('user_id', user.id);

    if (!error && data) {
      setUserAccess(data);
    }
  };

  const hasAccess = (eventId: string) => {
    return userAccess.some(a => a.event_id === eventId);
  };

  const handleEventClick = (event: CTFEvent) => {
    if (!user) {
      setShowAuthModal(true);
      toast.info('Please sign in to access events');
      return;
    }

    if (event.is_paid && !hasAccess(event.id)) {
      setSelectedEvent(event);
      setShowRedeemModal(true);
    } else {
      setActiveEventId(event.id);
      setActiveEventName(event.name);
      setCurrentView('event');
    }
  };

  const handleAccessGranted = () => {
    fetchUserAccess();
    if (selectedEvent) {
      setActiveEventId(selectedEvent.id);
      setActiveEventName(selectedEvent.name);
      setCurrentView('event');
    }
  };

  if (currentView === 'admin') {
    return <AdminDashboard onBack={() => setCurrentView('home')} />;
  }

  if (currentView === 'event') {
    return (
      <ChallengeBoard
        eventId={activeEventId}
        eventName={activeEventName}
        onBack={() => setCurrentView('home')}
      />
    );
  }

  return (
    <div className="min-h-screen bg-[#0d0015]">
      {/* Navigation */}
      <nav className="fixed top-0 left-0 right-0 z-40 bg-[#0d0015]/90 backdrop-blur-md border-b border-[#00ff41]/20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="flex items-center justify-between h-16">
            <div className="flex items-center gap-3">
              <Terminal className="text-[#00ff41]" size={28} />
              <span className="font-mono font-bold text-white text-xl hidden sm:block">CTF_ARENA</span>
            </div>

            {/* Desktop Navigation */}
            <div className="hidden md:flex items-center gap-6">
              <a href="#events" className="text-gray-400 hover:text-[#00ff41] font-mono text-sm transition-colors">
                EVENTS
              </a>
              <a href="#leaderboard" className="text-gray-400 hover:text-[#00ff41] font-mono text-sm transition-colors">
                LEADERBOARD
              </a>
              {profile?.is_admin && (
                <button
                  onClick={() => setCurrentView('admin')}
                  className="text-purple-400 hover:text-purple-300 font-mono text-sm transition-colors flex items-center gap-1"
                >
                  <Shield size={14} />
                  ADMIN
                </button>
              )}
            </div>

            <div className="flex items-center gap-4">
              {authLoading ? (
                <div className="w-8 h-8 rounded-full bg-[#00ff41]/20 animate-pulse" />
              ) : user ? (
                <div className="flex items-center gap-3">
                  <div className="hidden sm:block text-right">
                    <div className="text-white font-mono text-sm">{profile?.username}</div>
                    <div className="text-[#00ff41] font-mono text-xs">{profile?.total_score || 0} pts</div>
                  </div>
                  <div className="w-10 h-10 rounded-full bg-[#00ff41]/20 flex items-center justify-center">
                    <User className="text-[#00ff41]" size={20} />
                  </div>
                  <button
                    onClick={() => signOut()}
                    className="text-gray-400 hover:text-red-400 transition-colors"
                    title="Sign Out"
                  >
                    <LogOut size={20} />
                  </button>
                </div>
              ) : (
                <button
                  onClick={() => setShowAuthModal(true)}
                  className="px-4 py-2 bg-[#00ff41] text-black font-mono font-bold text-sm rounded hover:bg-[#00ff41]/80 transition-colors"
                >
                  LOGIN
                </button>
              )}

              {/* Mobile menu button */}
              <button
                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                className="md:hidden text-gray-400 hover:text-white"
              >
                {mobileMenuOpen ? <X size={24} /> : <Menu size={24} />}
              </button>
            </div>
          </div>

          {/* Mobile Navigation */}
          {mobileMenuOpen && (
            <div className="md:hidden py-4 border-t border-[#00ff41]/20">
              <div className="flex flex-col gap-4">
                <a href="#events" className="text-gray-400 hover:text-[#00ff41] font-mono text-sm">
                  EVENTS
                </a>
                <a href="#leaderboard" className="text-gray-400 hover:text-[#00ff41] font-mono text-sm">
                  LEADERBOARD
                </a>
                {profile?.is_admin && (
                  <button
                    onClick={() => {
                      setCurrentView('admin');
                      setMobileMenuOpen(false);
                    }}
                    className="text-purple-400 font-mono text-sm text-left flex items-center gap-1"
                  >
                    <Shield size={14} />
                    ADMIN
                  </button>
                )}
              </div>
            </div>
          )}
        </div>
      </nav>

      {/* Hero Section */}
      <section className="relative min-h-[90vh] flex items-center justify-center overflow-hidden pt-16">
        <div className="absolute inset-0">
          <img
            src={HERO_IMAGE}
            alt="CTF Arena"
            className="w-full h-full object-cover opacity-40"
          />
          <div className="absolute inset-0 bg-gradient-to-b from-[#0d0015]/50 via-[#0d0015]/80 to-[#0d0015]" />
        </div>

        {/* Animated grid background */}
        <div className="absolute inset-0 opacity-20">
          <div className="absolute inset-0" style={{
            backgroundImage: `linear-gradient(#00ff41 1px, transparent 1px), linear-gradient(90deg, #00ff41 1px, transparent 1px)`,
            backgroundSize: '50px 50px'
          }} />
        </div>

        <div className="relative z-10 max-w-5xl mx-auto px-6 text-center">
          <div className="inline-flex items-center gap-2 px-4 py-2 bg-[#00ff41]/10 border border-[#00ff41]/30 rounded-full mb-6">
            <span className="w-2 h-2 bg-[#00ff41] rounded-full animate-pulse" />
            <span className="text-[#00ff41] font-mono text-sm">LIVE_EVENTS_ACTIVE</span>
          </div>

          <h1 className="text-5xl md:text-7xl font-mono font-bold text-white mb-6 leading-tight">
            <span className="text-[#00ff41]">CAPTURE</span> THE FLAG
            <br />
            <span className="text-purple-400">ARENA</span>
          </h1>

          <p className="text-xl text-gray-400 mb-8 max-w-2xl mx-auto font-mono">
            Compete in elite cybersecurity challenges. Hack. Learn. Dominate.
            <br />
            <span className="text-[#00ff41]">Powered by TryHackMe</span>
          </p>

          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <a
              href="#events"
              className="px-8 py-4 bg-[#00ff41] text-black font-mono font-bold rounded-lg hover:bg-[#00ff41]/80 transition-all flex items-center justify-center gap-2 group"
            >
              <Flag size={20} />
              BROWSE_EVENTS
              <ChevronRight size={20} className="group-hover:translate-x-1 transition-transform" />
            </a>
            <button
              onClick={() => !user && setShowAuthModal(true)}
              className="px-8 py-4 bg-transparent border-2 border-[#00ff41] text-[#00ff41] font-mono font-bold rounded-lg hover:bg-[#00ff41]/10 transition-all flex items-center justify-center gap-2"
            >
              <User size={20} />
              {user ? 'VIEW_PROFILE' : 'JOIN_NOW'}
            </button>
          </div>

          {/* Stats */}
          <div className="grid grid-cols-3 gap-8 mt-16 max-w-2xl mx-auto">
            <div className="text-center">
              <div className="text-3xl md:text-4xl font-mono font-bold text-[#00ff41]">500+</div>
              <div className="text-gray-500 font-mono text-sm">CHALLENGES</div>
            </div>
            <div className="text-center">
              <div className="text-3xl md:text-4xl font-mono font-bold text-purple-400">10K+</div>
              <div className="text-gray-500 font-mono text-sm">HACKERS</div>
            </div>
            <div className="text-center">
              <div className="text-3xl md:text-4xl font-mono font-bold text-yellow-400">$50K</div>
              <div className="text-gray-500 font-mono text-sm">PRIZES</div>
            </div>
          </div>
        </div>

        {/* Scroll indicator */}
        <div className="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
          <div className="w-6 h-10 border-2 border-[#00ff41]/50 rounded-full flex items-start justify-center p-2">
            <div className="w-1 h-2 bg-[#00ff41] rounded-full animate-pulse" />
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-20 px-6">
        <div className="max-w-7xl mx-auto">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-mono font-bold text-white mb-4">
              WHY_<span className="text-[#00ff41]">CTF_ARENA</span>?
            </h2>
            <p className="text-gray-400 font-mono max-w-2xl mx-auto">
              The ultimate platform for cybersecurity competitions
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {[
              {
                icon: <Target className="text-[#00ff41]" size={32} />,
                title: 'REAL_CHALLENGES',
                description: 'Hands-on labs powered by TryHackMe. No simulations, real vulnerabilities.'
              },
              {
                icon: <Trophy className="text-yellow-400" size={32} />,
                title: 'COMPETE_&_WIN',
                description: 'Join paid events for cash prizes or free events to sharpen your skills.'
              },
              {
                icon: <Users className="text-purple-400" size={32} />,
                title: 'GLOBAL_COMMUNITY',
                description: 'Connect with hackers worldwide. Share knowledge, climb the ranks.'
              },
              {
                icon: <Zap className="text-orange-400" size={32} />,
                title: 'INSTANT_ACCESS',
                description: 'Redeem access codes or pay directly. Start hacking in seconds.'
              },
              {
                icon: <Code className="text-blue-400" size={32} />,
                title: 'ALL_CATEGORIES',
                description: 'Web, Pwn, Crypto, Forensics, Reverse Engineering, and more.'
              },
              {
                icon: <Shield className="text-red-400" size={32} />,
                title: 'SECURE_PLATFORM',
                description: 'Enterprise-grade security. Your flags, your glory.'
              }
            ].map((feature, i) => (
              <div
                key={i}
                className="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg p-6 hover:border-[#00ff41]/50 transition-all group"
              >
                <div className="w-14 h-14 rounded-lg bg-black/50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                  {feature.icon}
                </div>
                <h3 className="text-lg font-mono font-bold text-white mb-2">{feature.title}</h3>
                <p className="text-gray-400 text-sm">{feature.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Events Section */}
      <section id="events" className="py-20 px-6 bg-gradient-to-b from-transparent to-[#1a0b2e]/30">
        <div className="max-w-7xl mx-auto">
          <div className="flex flex-col md:flex-row md:items-center md:justify-between mb-12">
            <div>
              <h2 className="text-3xl md:text-4xl font-mono font-bold text-white mb-2">
                ACTIVE_<span className="text-[#00ff41]">EVENTS</span>
              </h2>
              <p className="text-gray-400 font-mono">
                Choose your battlefield. Prove your skills.
              </p>
            </div>
            <div className="flex gap-2 mt-4 md:mt-0">
              <button className="px-4 py-2 bg-[#00ff41] text-black font-mono text-sm rounded">ALL</button>
              <button className="px-4 py-2 bg-black/30 text-gray-400 font-mono text-sm rounded border border-[#00ff41]/20 hover:text-white">LIVE</button>
              <button className="px-4 py-2 bg-black/30 text-gray-400 font-mono text-sm rounded border border-[#00ff41]/20 hover:text-white">FREE</button>
              <button className="px-4 py-2 bg-black/30 text-gray-400 font-mono text-sm rounded border border-[#00ff41]/20 hover:text-white">PAID</button>
            </div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {events.map(event => (
              <EventCard
                key={event.id}
                event={event}
                hasAccess={hasAccess(event.id)}
                onJoin={() => handleEventClick(event)}
              />
            ))}
          </div>
        </div>
      </section>

      {/* Leaderboard Section */}
      <section id="leaderboard" className="py-20 px-6">
        <div className="max-w-7xl mx-auto">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div>
              <h2 className="text-3xl md:text-4xl font-mono font-bold text-white mb-2">
                GLOBAL_<span className="text-[#00ff41]">RANKINGS</span>
              </h2>
              <p className="text-gray-400 font-mono mb-8">
                Top hackers worldwide. Real-time updates.
              </p>
              <Leaderboard showGlobal={true} />
            </div>

            <div className="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg p-8">
              <h3 className="text-2xl font-mono font-bold text-white mb-6">
                HOW_TO_<span className="text-[#00ff41]">COMPETE</span>
              </h3>
              <div className="space-y-6">
                {[
                  { step: '01', title: 'CREATE_ACCOUNT', desc: 'Sign up with your email and choose a hacker name' },
                  { step: '02', title: 'JOIN_EVENT', desc: 'Browse events and unlock access with a code or payment' },
                  { step: '03', title: 'HACK_CHALLENGES', desc: 'Launch TryHackMe labs and find the flags' },
                  { step: '04', title: 'SUBMIT_FLAGS', desc: 'Enter flags to earn points and climb the leaderboard' }
                ].map((item, i) => (
                  <div key={i} className="flex gap-4">
                    <div className="w-12 h-12 rounded-lg bg-[#00ff41]/20 flex items-center justify-center font-mono font-bold text-[#00ff41] flex-shrink-0">
                      {item.step}
                    </div>
                    <div>
                      <h4 className="font-mono font-bold text-white">{item.title}</h4>
                      <p className="text-gray-400 text-sm">{item.desc}</p>
                    </div>
                  </div>
                ))}
              </div>

              <button
                onClick={() => !user && setShowAuthModal(true)}
                className="w-full mt-8 px-6 py-4 bg-[#00ff41] text-black font-mono font-bold rounded-lg hover:bg-[#00ff41]/80 transition-all flex items-center justify-center gap-2"
              >
                {user ? 'START_HACKING' : 'GET_STARTED'}
                <ChevronRight size={20} />
              </button>
            </div>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-[#0a0010] border-t border-[#00ff41]/20 py-16 px-6">
        <div className="max-w-7xl mx-auto">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div>
              <div className="flex items-center gap-3 mb-4">
                <Terminal className="text-[#00ff41]" size={28} />
                <span className="font-mono font-bold text-white text-xl">CTF_ARENA</span>
              </div>
              <p className="text-gray-400 text-sm mb-4">
                The premier platform for competitive cybersecurity challenges.
              </p>
              <div className="flex gap-4">
                <a href="#" className="text-gray-400 hover:text-[#00ff41] transition-colors">
                  <Github size={20} />
                </a>
                <a href="#" className="text-gray-400 hover:text-[#00ff41] transition-colors">
                  <Twitter size={20} />
                </a>
              </div>
            </div>

            <div>
              <h4 className="font-mono font-bold text-white mb-4">PLATFORM</h4>
              <ul className="space-y-2 text-sm">
                <li><a href="#events" className="text-gray-400 hover:text-[#00ff41]">Events</a></li>
                <li><a href="#leaderboard" className="text-gray-400 hover:text-[#00ff41]">Leaderboard</a></li>
                <li><a href="#" className="text-gray-400 hover:text-[#00ff41]">Challenges</a></li>
                <li><a href="#" className="text-gray-400 hover:text-[#00ff41]">Teams</a></li>
              </ul>
            </div>

            <div>
              <h4 className="font-mono font-bold text-white mb-4">RESOURCES</h4>
              <ul className="space-y-2 text-sm">
                <li><a href="#" className="text-gray-400 hover:text-[#00ff41]">Documentation</a></li>
                <li><a href="#" className="text-gray-400 hover:text-[#00ff41]">API</a></li>
                <li><a href="#" className="text-gray-400 hover:text-[#00ff41]">Blog</a></li>
                <li><a href="#" className="text-gray-400 hover:text-[#00ff41]">Support</a></li>
              </ul>
            </div>

            <div>
              <h4 className="font-mono font-bold text-white mb-4">LEGAL</h4>
              <ul className="space-y-2 text-sm">
                <li><a href="#" className="text-gray-400 hover:text-[#00ff41]">Terms of Service</a></li>
                <li><a href="#" className="text-gray-400 hover:text-[#00ff41]">Privacy Policy</a></li>
                <li><a href="#" className="text-gray-400 hover:text-[#00ff41]">Cookie Policy</a></li>
                <li><a href="#" className="text-gray-400 hover:text-[#00ff41]">Responsible Disclosure</a></li>
              </ul>
            </div>
          </div>

          <div className="border-t border-[#00ff41]/20 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p className="text-gray-500 font-mono text-sm">
              © 2025 CTF_ARENA. All rights reserved.
            </p>
            <p className="text-gray-500 font-mono text-sm">
              Built with <span className="text-[#00ff41]">{"<3"}</span> for hackers
            </p>
          </div>
        </div>
      </footer>

      {/* Modals */}
      <AuthModal isOpen={showAuthModal} onClose={() => setShowAuthModal(false)} />
      {selectedEvent && (
        <RedeemCodeModal
          isOpen={showRedeemModal}
          onClose={() => {
            setShowRedeemModal(false);
            setSelectedEvent(null);
          }}
          event={selectedEvent}
          onSuccess={handleAccessGranted}
        />
      )}
    </div>
  );
};

const AppLayout: React.FC = () => {
  return (
    <AuthProvider>
      <MainContent />
    </AuthProvider>
  );
};

export default AppLayout;
