<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['event']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['event']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div
    class="group relative bg-gradient-to-br from-[#1a0b2e] to-[#0d0015] border border-[#00ff41]/20 rounded-lg overflow-hidden hover:border-[#00ff41]/50 transition-all duration-300 hover:shadow-lg hover:shadow-[#00ff41]/10">
    <div class="relative h-48 overflow-hidden">
        <img src="<?php echo e(\Illuminate\Support\Str::startsWith($event['cover_image_url'] ?? '', ['http://', 'https://']) ? ($event['cover_image_url'] ?? '') : \Illuminate\Support\Facades\Storage::url($event['cover_image_url'] ?? '')); ?>" alt="<?php echo e($event['name'] ?? ''); ?>"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
        <div class="absolute inset-0 bg-gradient-to-t from-[#0d0015] via-transparent to-transparent"></div>

        <?php
        $now = now();
        $startTime = \Carbon\Carbon::parse($event['start_time'] ?? null);
        $endTime = \Carbon\Carbon::parse($event['end_time'] ?? null);
        $isLive = $now->between($startTime, $endTime);
        $isUpcoming = $now->lt($startTime);
        $isEnded = $now->gt($endTime);

        $status = '';
        $statusColor = '';
        $statusTextColor = '';

        if ($isLive) {
        $status = 'LIVE';
        $statusColor = 'bg-[#00ff41]';
        $statusTextColor = 'text-black';
        } elseif ($isUpcoming) {
        $status = 'UPCOMING';
        $statusColor = 'bg-yellow-500';
        $statusTextColor = 'text-black';
        } else {
        $status = 'ENDED';
        $statusColor = 'bg-gray-600';
        $statusTextColor = 'text-white';
        }
        ?>

        <!-- Status Badge -->
        <div
            class="absolute top-3 left-3 px-3 py-1 rounded <?php echo e($statusColor); ?> <?php echo e($statusTextColor); ?> font-mono text-xs font-bold flex items-center gap-1">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isLive): ?>
            <span class="w-2 h-2 bg-black rounded-full animate-pulse"></span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php echo e($status); ?>

        </div>

        <!-- Price Badge -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($event['is_paid']) && $event['is_paid']): ?>
        <div
            class="absolute top-3 right-3 px-3 py-1 rounded bg-purple-600 text-white font-mono text-xs font-bold flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
            <?php echo e($event['price'] ?? ''); ?>

        </div>
        <?php else: ?>
        <div
            class="absolute top-3 right-3 px-3 py-1 rounded bg-[#00ff41]/20 text-[#00ff41] font-mono text-xs font-bold">
            FREE
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>

    <div class="p-5">
        <h3 class="text-xl font-mono font-bold text-white mb-2 group-hover:text-[#00ff41] transition-colors">
            <?php echo e($event['name'] ?? ''); ?>

        </h3>
        <div class="text-gray-400 text-sm mb-4 line-clamp-2 prose prose-invert prose-sm">
            <?php echo \Illuminate\Support\Str::markdown($event['description'] ?? ''); ?>

        </div>

        <div class="flex flex-wrap gap-3 mb-4 text-xs font-mono text-gray-500">
            <div class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <?php echo e($startTime->toFormattedDateString()); ?>

            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isUpcoming): ?>
            <div class="flex items-center gap-1 text-yellow-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                Starts in <?php echo e($startTime->diffForHumans(null, true)); ?>

            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($event['max_participants']) && $event['max_participants']): ?>
            <div class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <?php echo e($event['max_participants']); ?> spots
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event['is_rewarded']): ?>
            <div class="flex items-center gap-1 text-[#00ff41] border border-[#00ff41]/30 bg-[#00ff41]/10 px-2 py-0.5 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="7"></circle>
                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                </svg>
                <span>REWARDS</span>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


        </div>

        <?php
        $hasAccess = (isset($event['is_paid']) && !$event['is_paid']) || (auth()->check() && $event->accesses->isNotEmpty());
        $checkoutUrl = route('event.checkout', $event['id']);
        $boardUrl = route('challenge-board', $event['id']);
        ?>

        <button <?php if($isEnded): ?> disabled <?php endif; ?>
            <?php if(!$isEnded): ?>
            <?php if($hasAccess): ?>
            onclick="window.location.href = '<?php echo e($boardUrl); ?>'"
            <?php else: ?>
            onclick="window.location.href = '<?php echo e($checkoutUrl); ?>'"
            <?php endif; ?>
            <?php endif; ?>
            class="w-full py-3 rounded font-mono font-bold text-sm transition-all flex items-center justify-center gap-2
            <?php echo e($isEnded
                ? 'bg-gray-700 text-gray-400 cursor-not-allowed'
                : ($hasAccess
                    ? 'bg-[#00ff41] text-black hover:bg-[#00ff41]/80'
                    : 'bg-yellow-500 text-black hover:bg-yellow-400')); ?>">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isEnded): ?>
            EVENT_ENDED
            <?php elseif($hasAccess): ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 9.9-1"></path>
            </svg>
            ENTER_EVENT
            <?php else: ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            UNLOCK_ACCESS <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event['price'] > 0): ?> - $<?php echo e(number_format($event['price'])); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </button>
    </div>
</div><?php /**PATH D:\security-monetize-challenge\resources\views/components/event-card.blade.php ENDPATH**/ ?>