@props(['title', 'value', 'icon', 'color' => 'blue', 'trend' => null, 'trendDirection' => 'up'])

@php
$iconColors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'yellow' => 'bg-yellow-500',
    'red' => 'bg-red-500',
    'purple' => 'bg-purple-500',
    'indigo' => 'bg-indigo-500',
];

$trendColors = [
    'up' => 'text-green-600 bg-green-50',
    'down' => 'text-red-600 bg-red-50',
    'neutral' => 'text-gray-600 bg-gray-50',
];
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600 mb-1">{{ $title }}</p>
            <div class="flex items-center space-x-2">
                <p class="text-2xl font-bold text-gray-900">{{ $value }}</p>
                @if($trend)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $trendColors[$trendDirection] }}">
                    @if($trendDirection === 'up')
                        <i class="bi bi-arrow-up text-xs mr-1"></i>
                    @elseif($trendDirection === 'down')
                        <i class="bi bi-arrow-down text-xs mr-1"></i>
                    @endif
                    {{ $trend }}
                </span>
                @endif
            </div>
        </div>
        <div class="w-12 h-12 {{ $iconColors[$color] ?? $iconColors['blue'] }} rounded-lg flex items-center justify-center">
            <i class="{{ $icon }} text-white text-xl"></i>
        </div>
    </div>
</div>
