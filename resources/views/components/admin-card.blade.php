@props(['title' => '', 'icon' => '', 'color' => 'blue'])

@php
$colorClasses = [
    'blue' => 'from-blue-500 to-blue-600',
    'green' => 'from-green-500 to-green-600',
    'yellow' => 'from-yellow-500 to-yellow-600',
    'red' => 'from-red-500 to-red-600',
    'purple' => 'from-purple-500 to-purple-600',
    'indigo' => 'from-indigo-500 to-indigo-600',
];
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 overflow-hidden">
    @if($title || $icon)
    <div class="px-6 py-4 bg-gradient-to-r {{ $colorClasses[$color] ?? $colorClasses['blue'] }} text-white">
        <div class="flex items-center space-x-3">
            @if($icon)
            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="{{ $icon }} text-lg"></i>
            </div>
            @endif
            @if($title)
            <h3 class="text-lg font-semibold">{{ $title }}</h3>
            @endif
        </div>
    </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>
</div>
