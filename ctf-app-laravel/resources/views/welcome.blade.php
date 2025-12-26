
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CTF Arena</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-[#0d0015]">
      <!-- Navigation -->
      <nav class="fixed top-0 left-0 right-0 z-40 bg-[#0d0015]/90 backdrop-blur-md border-b border-[#00ff41]/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
          <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-3">
              <svg class="text-[#00ff41]" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>
              <span class="font-mono font-bold text-white text-xl hidden sm:block">CTF_ARENA</span>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-6">
              <a href="#events" class="text-gray-400 hover:text-[#00ff41] font-mono text-sm transition-colors">
                EVENTS
              </a>
              <a href="#leaderboard" class="text-gray-400 hover:text-[#00ff41] font-mono text-sm transition-colors">
                LEADERBOARD
              </a>
            </div>

            <div class="flex items-center gap-4">
                <a href="/login" class="px-4 py-2 bg-[#00ff41] text-black font-mono font-bold text-sm rounded hover:bg-[#00ff41]/80 transition-colors">
                  LOGIN
                </a>
            </div>
          </div>
        </div>
      </nav>

      <!-- Hero Section -->
      <section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden pt-16">
        <div class="absolute inset-0">
          <img
            src="https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615307390_81db8ad7.jpg"
            alt="CTF Arena"
            class="w-full h-full object-cover opacity-40"
          />
          <div class="absolute inset-0 bg-gradient-to-b from-[#0d0015]/50 via-[#0d0015]/80 to-[#0d0015]"></div>
        </div>

        <!-- Animated grid background -->
        <div class="absolute inset-0 opacity-20">
          <div class="absolute inset-0" style="
            background-image: linear-gradient(#00ff41 1px, transparent 1px), linear-gradient(90deg, #00ff41 1px, transparent 1px);
            background-size: 50px 50px;
          "></div>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center">
          <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00ff41]/10 border border-[#00ff41]/30 rounded-full mb-6">
            <span class="w-2 h-2 bg-[#00ff41] rounded-full animate-pulse"></span>
            <span class="text-[#00ff41] font-mono text-sm">LIVE_EVENTS_ACTIVE</span>
          </div>

          <h1 class="text-5xl md:text-7xl font-mono font-bold text-white mb-6 leading-tight">
            <span class="text-[#00ff41]">CAPTURE</span> THE FLAG
            <br />
            <span class="text-purple-400">ARENA</span>
          </h1>

          <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto font-mono">
            Compete in elite cybersecurity challenges. Hack. Learn. Dominate.
            <br />
            <span class="text-[#00ff41]">Powered by TryHackMe</span>
          </p>

          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a
              href="#events"
              class="px-8 py-4 bg-[#00ff41] text-black font-mono font-bold rounded-lg hover:bg-[#00ff41]/80 transition-all flex items-center justify-center gap-2 group"
            >
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
              BROWSE_EVENTS
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
            <a
              href="/register"
              class="px-8 py-4 bg-transparent border-2 border-[#00ff41] text-[#00ff41] font-mono font-bold rounded-lg hover:bg-[#00ff41]/10 transition-all flex items-center justify-center gap-2"
            >
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
              JOIN_NOW
            </a>
          </div>

          <!-- Stats -->
          <div class="grid grid-cols-3 gap-8 mt-16 max-w-2xl mx-auto">
            <div class="text-center">
              <div class="text-3xl md:text-4xl font-mono font-bold text-[#00ff41]">500+</div>
              <div class="text-gray-500 font-mono text-sm">CHALLENGES</div>
            </div>
            <div class="text-center">
              <div class="text-3xl md:text-4xl font-mono font-bold text-purple-400">10K+</div>
              <div class="text-gray-500 font-mono text-sm">HACKERS</div>
            </div>
            <div class="text-center">
              <div class="text-3xl md:text-4xl font-mono font-bold text-yellow-400">$50K</div>
              <div class="text-gray-500 font-mono text-sm">PRIZES</div>
            </div>
          </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
          <div class="w-6 h-10 border-2 border-[#00ff41]/50 rounded-full flex items-start justify-center p-2">
            <div class="w-1 h-2 bg-[#00ff41] rounded-full animate-pulse"></div>
          </div>
        </div>
      </section>

      <!-- Features Section -->
      <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
          <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-mono font-bold text-white mb-4">
              WHY_<span class="text-[#00ff41]">CTF_ARENA</span>?
            </h2>
            <p class="text-gray-400 font-mono max-w-2xl mx-auto">
              The ultimate platform for cybersecurity competitions
            </p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg p-6 hover:border-[#00ff41]/50 transition-all group">
                <div class="w-14 h-14 rounded-lg bg-black/50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#00ff41]"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                </div>
                <h3 class="text-lg font-mono font-bold text-white mb-2">REAL_CHALLENGES</h3>
                <p class="text-gray-400 text-sm">Hands-on labs powered by TryHackMe. No simulations, real vulnerabilities.</p>
            </div>
            <div class="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg p-6 hover:border-[#00ff41]/50 transition-all group">
                <div class="w-14 h-14 rounded-lg bg-black/50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-400"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H5c-.55 0-1-.45-1-1v-2.34"></path><path d="M14 14.66V17c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-2.34"></path><path d="M18 9a4 4 0 0 0-4-4h-4a4 4 0 0 0-4 4"></path><path d="M12 14.66L12 9"></path></svg>
                </div>
                <h3 class="text-lg font-mono font-bold text-white mb-2">COMPETE_&_WIN</h3>
                <p class="text-gray-400 text-sm">Join paid events for cash prizes or free events to sharpen your skills.</p>
            </div>
            <div class="bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg p-6 hover:border-[#00ff41]/50 transition-all group">
                <div class="w-14 h-14 rounded-lg bg-black/50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-400"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <h3 class="text-lg font-mono font-bold text-white mb-2">GLOBAL_COMMUNITY</h3>
                <p class="text-gray-400 text-sm">Connect with hackers worldwide. Share knowledge, climb the ranks.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Events Section -->
      <section id="events" class="py-20 px-6 bg-gradient-to-b from-transparent to-[#1a0b2e]/30">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-12">
                <div>
                  <h2 class="text-3xl md:text-4xl font-mono font-bold text-white mb-2">
                    ACTIVE_<span class="text-[#00ff41]">EVENTS</span>
                  </h2>
                  <p class="text-gray-400 font-mono">
                    Choose your battlefield. Prove your skills.
                  </p>
                </div>
            </div>
            <div class="col-span-full text-center text-gray-400 font-mono">
                LOADING_EVENTS...
            </div>
        </div>
      </section>

      <!-- Footer -->
      <footer class="bg-[#0a0010] border-t border-[#00ff41]/20 py-16 px-6">
        <div class="max-w-7xl mx-auto">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div>
              <div class="flex items-center gap-3 mb-4">
                <svg class="text-[#00ff41]" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>
                <span class="font-mono font-bold text-white text-xl">CTF_ARENA</span>
              </div>
              <p class="text-gray-400 text-sm mb-4">
                The premier platform for competitive cybersecurity challenges.
              </p>
            </div>

            <div>
              <h4 class="font-mono font-bold text-white mb-4">PLATFORM</h4>
              <ul class="space-y-2 text-sm">
                <li><a href="#events" class="text-gray-400 hover:text-[#00ff41]">Events</a></li>
                <li><a href="#leaderboard" class="text-gray-400 hover:text-[#00ff41]">Leaderboard</a></li>
                <li><a href="#" class="text-gray-400 hover:text-[#00ff41]">Challenges</a></li>
                <li><a href="#" class="text-gray-400 hover:text-[#00ff41]">Teams</a></li>
              </ul>
            </div>

            <div>
              <h4 class="font-mono font-bold text-white mb-4">RESOURCES</h4>
              <ul class="space-y-2 text-sm">
                <li><a href="#" class="text-gray-400 hover:text-[#00ff41]">Documentation</a></li>
                <li><a href="#" class="text-gray-400 hover:text-[#00ff41]">API</a></li>
                <li><a href="#" class="text-gray-400 hover:text-[#00ff41]">Blog</a></li>
                <li><a href="#" class="text-gray-400 hover:text-[#00ff41]">Support</a></li>
              </ul>
            </div>

            <div>
              <h4 class="font-mono font-bold text-white mb-4">LEGAL</h4>
              <ul class="space-y-2 text-sm">
                <li><a href="#" class="text-gray-400 hover:text-[#00ff41]">Terms of Service</a></li>
                <li><a href="#" class="text-gray-400 hover:text-[#00ff41]">Privacy Policy</a></li>
                <li><a href="#" class="text-gray-400 hover:text-[#00ff41]">Cookie Policy</a></li>
                <li><a href="#" class="text-gray-400 hover:text-[#00ff41]">Responsible Disclosure</a></li>
              </ul>
            </div>
          </div>

          <div class="border-t border-[#00ff41]/20 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 font-mono text-sm">
              © 2025 CTF_ARENA. All rights reserved.
            </p>
            <p class="text-gray-500 font-mono text-sm">
              Built with <span class="text-[#00ff41]">&lt;3</span> for hackers
            </p>
          </div>
        </div>
      </footer>
    </div>
</body>
</html>
