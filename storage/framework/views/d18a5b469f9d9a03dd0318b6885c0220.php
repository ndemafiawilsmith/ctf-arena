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
                    <li><a href="<?php echo e(route('ctf-events')); ?>#events" class="text-gray-400 hover:text-[#00ff41]">Events</a></li>
                    <li><a href="<?php echo e(route('ctf-events')); ?>#leaderboard" class="text-gray-400 hover:text-[#00ff41]">Leaderboard</a></li>
                    <li><a href="<?php echo e(route('ctf-events')); ?>#events" class="text-gray-400 hover:text-[#00ff41]">Challenges</a></li>
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
                © <?php echo e(date('Y')); ?> CTF_ARENA. All rights reserved.
            </p>
            <p class="text-gray-500 font-mono text-sm">
                Built with <span class="text-[#00ff41]">&lt;3</span> for hackers
            </p>
        </div>
    </div>
</footer>
<?php /**PATH D:\security-monetize-challenge\resources\views/components/footer.blade.php ENDPATH**/ ?>