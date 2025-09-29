@extends('layouts.radiologist')

@section('title', 'Radiologist Dashboard')
@section('page-title', 'Radiologist Dashboard')
@section('page-description', 'Radiologic Technologist Portal')

@section('content')
<div class="space-y-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Recent X-Ray Images</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($checklists as $c)
                <div class="border rounded p-3">
                    <div class="text-sm font-medium mb-2">{{ $c->name ?? 'Unnamed' }} ({{ $c->date?->format('Y-m-d') }})</div>
                    @if($c->xray_image_path)
                        <img src="{{ asset('storage/' . $c->xray_image_path) }}" alt="X-Ray" class="w-full h-40 object-contain bg-gray-50 border rounded">
                    @else
                        <div class="text-gray-500">No image</div>
                    @endif
                </div>
            @empty
                <div class="text-gray-500">No X-ray images found.</div>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Pre-Employment Chest X-Ray</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-600">
                    <th class="py-2">Name</th>
                    <th class="py-2">Company</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($preEmployments as $row)
                    <tr class="border-t">
                        <td class="py-2">{{ $row['name'] }}</td>
                        <td class="py-2">{{ $row['company'] ?? '—' }}</td>
                        <td class="py-2 space-x-2">
                            <a href="{{ route('radiologist.pre-employment.show', $row['id']) }}" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-4 text-gray-500">No records</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Annual Physical Chest X-Ray</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-600">
                    <th class="py-2">Name</th>
                    <th class="py-2">Company</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($annuals as $row)
                    <tr class="border-t">
                        <td class="py-2">{{ $row['name'] }}</td>
                        <td class="py-2">{{ $row['company'] ?? '—' }}</td>
                        <td class="py-2 space-x-2">
                            <a href="{{ route('radiologist.annual-physical.show', $row['id']) }}" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-4 text-gray-500">No records</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection


