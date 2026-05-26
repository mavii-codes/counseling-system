@props(['size' => 'md'])

@php
    $box = match($size) {
        'sm' => 'h-9 w-9',
        'lg' => 'h-14 w-14',
        default => 'h-11 w-11',
    };
    $icon = match($size) {
        'sm' => 'h-5 w-5',
        'lg' => 'h-8 w-8',
        default => 'h-6 w-6',
    };
@endphp

<span {{ $attributes->merge(['class' => "flex {$box} items-center justify-center rounded-2xl shadow-[0_4px_14px_rgb(219_39_119/0.35)]"]) }} style="background: linear-gradient(135deg, #ec4899, #a855f7, #38bdf8);">
    <svg class="{{ $icon }} text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
</span>
