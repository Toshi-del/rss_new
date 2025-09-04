@extends('layouts.radtech')

@section('title', 'Annual Physical Examination')
@section('page-title', 'Annual Physical Examination')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 text-center font-semibold">
        {{ session('success') }}
    </div>
@endif
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    @if(isset($checklist) && $checklist && $checklist->xray_image_path)
        <div class="mb-4">
            <div class="text-xs font-semibold uppercase text-gray-600 mb-2">X-Ray Image</div>
            <div class="border rounded p-3">
                <img src="{{ asset('storage/' . $checklist->xray_image_path) }}" alt="X-Ray Image" class="w-full h-40 object-contain bg-gray-50 border rounded cursor-zoom-in" id="xray-thumb" />
                <div class="text-xs text-gray-500 mt-2">Click image to open fullscreen and zoom</div>
            </div>
        </div>

        <div id="image-viewer-overlay" class="fixed inset-0 bg-black bg-opacity-95 hidden z-50">
            <div class="absolute top-3 right-3 flex items-center space-x-2">
                <button type="button" id="zoom-out" class="px-3 py-2 bg-gray-800 text-white rounded shadow">-</button>
                <button type="button" id="zoom-reset" class="px-3 py-2 bg-gray-800 text-white rounded shadow">Reset</button>
                <button type="button" id="zoom-in" class="px-3 py-2 bg-gray-800 text-white rounded shadow">+</button>
                <button type="button" id="close-viewer" class="px-3 py-2 bg-red-600 text-white rounded shadow">Close</button>
            </div>
            <div id="viewer-canvas" class="w-full h-full flex items-center justify-center overflow-hidden cursor-grab">
                <img id="viewer-image" src="{{ asset('storage/' . $checklist->xray_image_path) }}" alt="X-Ray Full" class="select-none" draggable="false" />
            </div>
        </div>

        <script>
        (function(){
            var thumb = document.getElementById('xray-thumb');
            if(!thumb) return;
            var overlay = document.getElementById('image-viewer-overlay');
            var img = document.getElementById('viewer-image');
            var canvas = document.getElementById('viewer-canvas');
            var btnIn = document.getElementById('zoom-in');
            var btnOut = document.getElementById('zoom-out');
            var btnReset = document.getElementById('zoom-reset');
            var btnClose = document.getElementById('close-viewer');

            var scale = 1;
            var minScale = 0.25;
            var maxScale = 6;
            var translateX = 0, translateY = 0;
            var isPanning = false; var startX = 0; var startY = 0;

            function applyTransform(){
                img.style.transform = 'translate(' + translateX + 'px,' + translateY + 'px) scale(' + scale + ')';
                img.style.transformOrigin = 'center center';
                img.style.maxWidth = 'none';
                img.style.maxHeight = 'none';
            }

            function enterFullscreen(el){
                if(el.requestFullscreen){ el.requestFullscreen(); }
                else if(el.webkitRequestFullscreen){ el.webkitRequestFullscreen(); }
                else if(el.msRequestFullscreen){ el.msRequestFullscreen(); }
            }

            function exitFullscreen(){
                if(document.exitFullscreen){ document.exitFullscreen(); }
                else if(document.webkitExitFullscreen){ document.webkitExitFullscreen(); }
                else if(document.msExitFullscreen){ document.msExitFullscreen(); }
            }

            function openViewer(){
                overlay.classList.remove('hidden');
                scale = 1; translateX = 0; translateY = 0; applyTransform();
                setTimeout(function(){ enterFullscreen(overlay); }, 0);
            }

            function closeViewer(){
                overlay.classList.add('hidden');
                exitFullscreen();
            }

            function zoom(delta, centerX, centerY){
                var oldScale = scale;
                scale = Math.min(maxScale, Math.max(minScale, scale * delta));
                var rect = img.getBoundingClientRect();
                var cx = centerX - rect.left; var cy = centerY - rect.top;
                var factor = scale / oldScale;
                translateX = (translateX - cx) * factor + cx;
                translateY = (translateY - cy) * factor + cy;
                applyTransform();
            }

            thumb.addEventListener('click', openViewer);
            btnClose.addEventListener('click', closeViewer);
            btnIn.addEventListener('click', function(){ zoom(1.2, window.innerWidth/2, window.innerHeight/2); });
            btnOut.addEventListener('click', function(){ zoom(1/1.2, window.innerWidth/2, window.innerHeight/2); });
            btnReset.addEventListener('click', function(){ scale = 1; translateX = 0; translateY = 0; applyTransform(); });

            canvas.addEventListener('wheel', function(e){
                e.preventDefault();
                var delta = e.deltaY < 0 ? 1.1 : 1/1.1;
                zoom(delta, e.clientX, e.clientY);
            }, { passive: false });

            canvas.addEventListener('mousedown', function(e){
                isPanning = true; startX = e.clientX - translateX; startY = e.clientY - translateY; canvas.classList.remove('cursor-grab'); canvas.classList.add('cursor-grabbing');
            });
            window.addEventListener('mouseup', function(){
                isPanning = false; canvas.classList.remove('cursor-grabbing'); canvas.classList.add('cursor-grab');
            });
            window.addEventListener('mousemove', function(e){
                if(!isPanning) return; translateX = e.clientX - startX; translateY = e.clientY - startY; applyTransform();
            });

            document.addEventListener('keydown', function(e){
                if(overlay.classList.contains('hidden')) return;
                if(e.key === 'Escape') closeViewer();
                if(e.key === '+') btnIn.click();
                if(e.key === '-') btnOut.click();
                if(e.key === '0') btnReset.click();
            });
        })();
        </script>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <div class="text-xs font-semibold uppercase text-gray-600">Full Name</div>
            <div class="text-sm">{{ $full_name }}</div>
        </div>
        <div>
            <div class="text-xs font-semibold uppercase text-gray-600">Sex</div>
            <div class="text-sm">{{ $sex ?? '—' }}</div>
        </div>
        <div>
            <div class="text-xs font-semibold uppercase text-gray-600">Age</div>
            <div class="text-sm">{{ $age ?? '—' }}</div>
        </div>
        <div>
            <div class="text-xs font-semibold uppercase text-gray-600">Company</div>
            <div class="text-sm">{{ $company ?? '—' }}</div>
        </div>
    </div>

    <form action="{{ route('radiologist.annual-physical.update', request()->route('id')) }}" method="POST" class="space-y-3">
        @csrf
        @method('PATCH')
        <div class="overflow-hidden rounded border">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="p-2">Test</th>
                        <th class="p-2">Result</th>
                        <th class="p-2">Findings</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-2">Chest X-Ray</td>
                        <td class="p-2"><input type="text" name="cxr_result" value="{{ old('cxr_result', $cxr_result) }}" class="w-full border rounded p-2" /></td>
                        <td class="p-2"><input type="text" name="cxr_finding" value="{{ old('cxr_finding', $cxr_finding) }}" class="w-full border rounded p-2" /></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-between">
            <a href="{{ route('radiologist.dashboard') }}" class="px-4 py-2 rounded border text-gray-700">Back</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </div>
    </form>
</div>

@endsection


