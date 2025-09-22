@extends('layouts.admin')

@section('title', 'Edit Page Content')
@section('page-title', 'Edit Page Content')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="content-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Edit Content Section</h2>
                <p class="text-gray-600">Editing: {{ $pageContent->display_name }} ({{ ucfirst($pageContent->page_name) }} page)</p>
            </div>
            <a href="{{ route('admin.page-contents.index', ['page' => $pageContent->page_name]) }}" 
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Content
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <div class="content-card rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.page-contents.update', $pageContent) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Page Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="page_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Page <span class="text-red-500">*</span>
                    </label>
                    <select name="page_name" id="page_name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('page_name') border-red-500 @enderror">
                        @foreach($pages as $page)
                            <option value="{{ $page }}" {{ $page === old('page_name', $pageContent->page_name) ? 'selected' : '' }}>
                                {{ ucfirst($page) }} Page
                            </option>
                        @endforeach
                    </select>
                    @error('page_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Content Type <span class="text-red-500">*</span>
                    </label>
                    <select name="content_type" id="content_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content_type') border-red-500 @enderror">
                        <option value="text" {{ old('content_type', $pageContent->content_type) === 'text' ? 'selected' : '' }}>Text (Single Line)</option>
                        <option value="textarea" {{ old('content_type', $pageContent->content_type) === 'textarea' ? 'selected' : '' }}>Textarea (Multi-line)</option>
                        <option value="url" {{ old('content_type', $pageContent->content_type) === 'url' ? 'selected' : '' }}>URL</option>
                        <option value="image" {{ old('content_type', $pageContent->content_type) === 'image' ? 'selected' : '' }}>Image Path</option>
                    </select>
                    @error('content_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section Key and Display Name -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="section_key" class="block text-sm font-medium text-gray-700 mb-2">
                        Section Key <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="section_key" id="section_key" value="{{ old('section_key', $pageContent->section_key) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('section_key') border-red-500 @enderror"
                           placeholder="e.g., hero_title, about_description">
                    <p class="mt-1 text-xs text-gray-500">Unique identifier for this content section (use underscores, no spaces)</p>
                    @error('section_key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="display_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Display Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="display_name" id="display_name" value="{{ old('display_name', $pageContent->display_name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('display_name') border-red-500 @enderror"
                           placeholder="e.g., Hero Title, About Description">
                    <p class="mt-1 text-xs text-gray-500">Human-readable name shown in the admin panel</p>
                    @error('display_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Content Value -->
            <div>
                <label for="content_value" class="block text-sm font-medium text-gray-700 mb-2">
                    Content Value <span class="text-red-500">*</span>
                </label>
                <div id="content-input-container">
                    <!-- Dynamic input will be inserted here -->
                </div>
                @error('content_value')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description (Optional)
                </label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                          placeholder="Help text or description for this content section">{{ old('description', $pageContent->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sort Order and Active Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                        Sort Order
                    </label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $pageContent->sort_order) }}" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sort_order') border-red-500 @enderror"
                           placeholder="0">
                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center pt-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $pageContent->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Active (visible on website)</span>
                    </label>
                </div>
            </div>

            <!-- Content Preview (for image type) -->
            @if($pageContent->content_type === 'image' && $pageContent->content_value)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Image Preview</label>
                <div class="border border-gray-200 rounded-lg p-4">
                    <img src="{{ $pageContent->content_value }}" 
                         alt="Current image" 
                         class="max-w-xs max-h-48 object-cover rounded-lg"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div style="display: none;" class="text-gray-500 text-sm">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Image not found or invalid path
                    </div>
                </div>
            </div>
            @endif

            <!-- Metadata -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Metadata</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Created:</span> {{ $pageContent->created_at->format('M j, Y g:i A') }}
                    </div>
                    <div>
                        <span class="font-medium">Last Updated:</span> {{ $pageContent->updated_at->format('M j, Y g:i A') }}
                    </div>
                    <div>
                        <span class="font-medium">ID:</span> {{ $pageContent->id }}
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <form method="POST" action="{{ route('admin.page-contents.destroy', $pageContent) }}" 
                      class="inline" 
                      onsubmit="return confirm('Are you sure you want to delete this content section? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-2"></i>Delete Section
                    </button>
                </form>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.page-contents.index', ['page' => $pageContent->page_name]) }}" 
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Content Section
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentTypeSelect = document.getElementById('content_type');
    const contentInputContainer = document.getElementById('content-input-container');
    
    function updateContentInput() {
        const contentType = contentTypeSelect.value;
        const oldValue = `{{ old('content_value', $pageContent->content_value) }}`.replace(/`/g, '\\`').replace(/\$/g, '\\$');
        
        let inputHtml = '';
        
        switch(contentType) {
            case 'textarea':
                inputHtml = `
                    <textarea name="content_value" id="content_value" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                              placeholder="Enter content...">${oldValue}</textarea>
                `;
                break;
            case 'url':
                inputHtml = `
                    <input type="url" name="content_value" id="content_value" value="${oldValue}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="https://example.com">
                `;
                break;
            case 'image':
                inputHtml = `
                    <input type="text" name="content_value" id="content_value" value="${oldValue}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="images/example.jpg or https://example.com/image.jpg">
                    <p class="mt-1 text-xs text-gray-500">Enter image path relative to public folder or full URL</p>
                `;
                break;
            default: // text
                inputHtml = `
                    <input type="text" name="content_value" id="content_value" value="${oldValue}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
});
</script>
@endpush
@endsection
