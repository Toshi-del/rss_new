@extends('layouts.admin')

@section('title', 'Add Page Content - RSS Citi Health Services')
@section('page-title', 'Add Page Content')

@section('content')
<div class="space-y-8">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-green-600"></i>
            </div>
            <div>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-plus text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Add New Content Section</h3>
                        <p class="text-blue-100 text-sm">Create a new content section for the {{ ucfirst($pageName) }} page</p>
                    </div>
                </div>
                <a href="{{ route('admin.page-contents.index', ['page' => $pageName]) }}" 
                   class="px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors backdrop-blur-sm border border-white/20">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Content
                </a>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">
        <div class="mb-6">
            <h4 class="text-lg font-bold text-gray-900 mb-2">Content Details</h4>
            <p class="text-gray-600 text-sm">Configure the new content section properties and values</p>
        </div>

        <form method="POST" action="{{ route('admin.page-contents.store') }}" class="space-y-8">
            @csrf
            
            <!-- Page Selection -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="page_name" class="block text-sm font-semibold text-gray-700">
                        Page <span class="text-red-500">*</span>
                    </label>
                    <select name="page_name" id="page_name" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('page_name') border-red-500 @enderror">
                        @foreach($pages as $page)
                            <option value="{{ $page }}" {{ $page === $pageName ? 'selected' : '' }}>
                                {{ ucfirst($page) }} Page
                            </option>
                        @endforeach
                    </select>
                    @error('page_name')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="content_type" class="block text-sm font-semibold text-gray-700">
                        Content Type <span class="text-red-500">*</span>
                    </label>
                    <select name="content_type" id="content_type" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('content_type') border-red-500 @enderror">
                        <option value="text" {{ old('content_type') === 'text' ? 'selected' : '' }}>Text (Single Line)</option>
                        <option value="textarea" {{ old('content_type') === 'textarea' ? 'selected' : '' }}>Textarea (Multi-line)</option>
                        <option value="url" {{ old('content_type') === 'url' ? 'selected' : '' }}>URL</option>
                        <option value="image" {{ old('content_type') === 'image' ? 'selected' : '' }}>Image Path</option>
                    </select>
                    @error('content_type')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Section Key and Display Name -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="section_key" class="block text-sm font-semibold text-gray-700">
                        Section Key <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="section_key" id="section_key" value="{{ old('section_key') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('section_key') border-red-500 @enderror"
                           placeholder="e.g., hero_title, about_description">
                    <p class="mt-1 text-xs text-gray-500">Unique identifier for this content section (use underscores, no spaces)</p>
                    @error('section_key')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="display_name" class="block text-sm font-semibold text-gray-700">
                        Display Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="display_name" id="display_name" value="{{ old('display_name') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('display_name') border-red-500 @enderror"
                           placeholder="e.g., Hero Title, About Description">
                    <p class="mt-1 text-xs text-gray-500">Human-readable name shown in the admin panel</p>
                    @error('display_name')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Content Value -->
            <div class="space-y-2">
                <label for="content_value" class="block text-sm font-semibold text-gray-700">
                    Content Value <span class="text-red-500">*</span>
                </label>
                <div id="content-input-container" class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <!-- Dynamic input will be inserted here -->
                </div>
                @error('content_value')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="block text-sm font-semibold text-gray-700">
                    Description (Optional)
                </label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                          placeholder="Help text or description for this content section">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Sort Order and Active Status -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="sort_order" class="block text-sm font-semibold text-gray-700">
                        Sort Order
                    </label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('sort_order') border-red-500 @enderror"
                           placeholder="0">
                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Status
                    </label>
                    <div class="flex items-center pt-1">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">Active (visible on website)</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-end pt-8 border-t border-gray-200 space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('admin.page-contents.index', ['page' => $pageName]) }}" 
                   class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <i class="fas fa-save mr-2"></i>Create Content Section
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentTypeSelect = document.getElementById('content_type');
    const contentInputContainer = document.getElementById('content-input-container');
    const activeToggle = document.getElementById('active-toggle');
    
    function updateContentInput() {
        const contentType = contentTypeSelect.value;
        const oldValue = '{{ old('content_value') }}';
        
        let inputHtml = '';
        
        switch(contentType) {
            case 'textarea':
                inputHtml = `
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                    <textarea name="content_value" id="content_value" rows="4" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-vertical"
                              placeholder="Enter content...">${oldValue}</textarea>
                `;
                break;
            case 'url':
                inputHtml = `
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL</label>
                    <input type="url" name="content_value" id="content_value" value="${oldValue}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="https://example.com">
                `;
                break;
            case 'image':
                inputHtml = `
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image Path/URL</label>
                    <input type="text" name="content_value" id="content_value" value="${oldValue}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="images/example.jpg or https://example.com/image.jpg">
                    <p class="mt-2 text-xs text-gray-500">Enter image path relative to public folder or full URL</p>
                `;
                break;
            default: // text
                inputHtml = `
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                    <input type="text" name="content_value" id="content_value" value="${oldValue}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Enter content...">
                `;
                break;
        }
        
        contentInputContainer.innerHTML = inputHtml;
    }
    
    // Initialize on page load
    updateContentInput();
    
    // Update when content type changes
    contentTypeSelect.addEventListener('change', updateContentInput);
    
    
    // Auto-generate section key from display name
    const displayNameInput = document.getElementById('display_name');
    const sectionKeyInput = document.getElementById('section_key');
    
    displayNameInput.addEventListener('input', function() {
        if (!sectionKeyInput.value || sectionKeyInput.dataset.autoGenerated !== 'false') {
            const key = this.value.toLowerCase()
                                  .replace(/[^a-z0-9\s]/g, '')
                                  .replace(/\s+/g, '_')
                                  .replace(/^_+|_+$/g, '');
            sectionKeyInput.value = key;
            sectionKeyInput.dataset.autoGenerated = 'true';
        }
    });
    
    sectionKeyInput.addEventListener('input', function() {
        this.dataset.autoGenerated = 'false';
    });
});
</script>
@endpush
@endsection
