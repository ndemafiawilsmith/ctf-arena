<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <title>CTF Arena</title> -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


    
    <title>CTF Arena - Nigeria's Premier Capture The Flag Cybersecurity Platform | Compete & Win</title>
    <meta name="title" content="CTF Arena - Nigeria's Premier Capture The Flag Cybersecurity Platform | Compete & Win">
    <meta name="description" content="Join Africa's leading CTF (Capture The Flag) platform. Compete in elite cybersecurity challenges, hack real vulnerabilities, win cash prizes, and level up your hacking skills. Powered by TryHackMe.">
    <meta name="keywords" content="CTF, Capture The Flag, cybersecurity, hacking competition, Nigeria CTF, Africa CTF, ethical hacking, penetration testing, security challenges, TryHackMe Nigeria, African hackers, cybersecurity Nigeria, Lagos CTF, infosec Africa, bug bounty Nigeria, white hat hacking, cyber competition Africa, Nigerian hackers, security training Nigeria, CTF competition, jeopardy CTF, attack defense CTF, cybersecurity events Nigeria, hacking challenges Africa">
    <meta name="author" content="CTF Arena">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="googlebot" content="index, follow">
    <link rel="canonical" href="https://ctf.cyberwilsmith.com.ng">

    
    <meta name="geo.region" content="NG">
    <meta name="geo.placename" content="Nigeria">
    <meta name="geo.position" content="9.0820;8.6753">
    <meta name="ICBM" content="9.0820, 8.6753">
    <meta name="language" content="English">
    <meta name="coverage" content="Africa">
    <meta name="distribution" content="global">
    <meta name="target" content="Nigeria, Africa, Ghana, Kenya, South Africa, Egypt">

    
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://ctf.cyberwilsmith.com.ng">
    <meta property="og:title" content="CTF Arena - Nigeria's Premier Capture The Flag Platform">
    <meta property="og:description" content="Compete in elite cybersecurity challenges. Hack real vulnerabilities, win cash prizes, and become Africa's top hacker. Join 10,000+ hackers today!">
    <meta property="og:image" content="https://ctf.cyberwilsmith.com.ng/images/og-image.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="CTF Arena - Capture The Flag Cybersecurity Platform">
    <meta property="og:site_name" content="CTF Arena">
    <meta property="og:locale" content="en_NG">
    <meta property="og:locale:alternate" content="en_US">
    <meta property="og:locale:alternate" content="en_GB">

    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://ctf.cyberwilsmith.com.ng">
    <meta name="twitter:title" content="CTF Arena - Nigeria's Premier Capture The Flag Platform">
    <meta name="twitter:description" content="Compete in elite cybersecurity challenges. Hack real vulnerabilities, win cash prizes. Join Africa's top hackers!">
    <meta name="twitter:image" content="https://ctf.cyberwilsmith.com.ng/images/og-image.png">
    <meta name="twitter:creator" content="@ctfarena">
    <meta name="twitter:site" content="@ctfarena">

    
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">

    
    <meta name="theme-color" content="#0d0015">
    <meta name="msapplication-TileColor" content="#0d0015">



</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-[#0d0015]">
        <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <main>
            <?php echo e($slot); ?>

        </main>
    </div>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('auth-modal');

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1257449174-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>

</html><?php /**PATH D:\security-monetize-challenge\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>