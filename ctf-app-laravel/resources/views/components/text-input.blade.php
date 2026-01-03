@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#00ff41]/20 bg-[#0d0015] text-white focus:border-[#00ff41] focus:ring-[#00ff41] rounded-md shadow-sm font-mono']) }}>