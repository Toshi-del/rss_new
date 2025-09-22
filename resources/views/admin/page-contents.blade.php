@extends('layouts.admin')

@section('title', 'Page Content Management')
@section('page-title', 'Page Content Management')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="content-card rounded-2xl p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Content Management System</h2>
                <p class="text-gray-600">Manage content for login, about, location, and services pages</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <form method="POST" action="{{ route('admin.page-contents.initialize-defaults') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-sync-alt mr-2"></i>Initialize Defaults
                    </button>
                </form>
                <a href="{{ route('admin.page-contents.create', ['page' => $selectedPage]) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-center">
                    <i class="fas fa-plus mr-2"></i>Add Content
                </a>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <strong>Please fix the following errors:</strong>
            </div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Pages Overview Cards -->
    @if($pagesSummary->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($pagesSummary as $summary)
        <div class="content-card rounded-2xl p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fas fa-{{ $summary->page_name === 'login' ? 'sign-in-alt' : ($summary->page_name === 'about' ? 'info-circle' : ($summary->page_name === 'location' ? 'map-marker-alt' : 'cogs')) }} text-xl"></i>
                </div>
                <span class="text-2xl font-bold text-gray-900">{{ $summary->content_count }}</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-1 capitalize">{{ $summary->page_name }} Page</h3>
            <p class="text-sm text-gray-600 mb-3">{{ $summary->content_count }} content sections</p>
            <p class="text-xs text-gray-500">Last updated: {{ \Carbon\Carbon::parse($summary->last_updated)->format('M j, Y') }}</p>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Page Selection and Content Management -->
    <div class="content-card rounded-2xl p-6">
        <!-- Page Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                @foreach($pages as $page)
                <a href="{{ route('admin.page-contents.index', ['page' => $page]) }}" 
                   class="py-2 px-1 border-b-2 font-medium text-sm transition-colors {{ $selectedPage === $page ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-{{ $page === 'login' ? 'sign-in-alt' : ($page === 'about' ? 'info-circle' : ($page === 'location' ? 'map-marker-alt' : 'cogs')) }} mr-2"></i>
                    {{ ucfirst($page) }} Page
                </a>
                @endforeach
            </nav>
        </div>

        <!-- Content Form -->
        @if($contents->count() > 0)
        <form method="POST" action="{{ route('admin.page-contents.bulk-update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="page_name" value="{{ $selectedPage }}">
            
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ ucfirst($selectedPage) }} Page Content</h3>
                <div class="flex gap-3">
                    @if($selectedPage === 'services')
                        <button type="button" onclick="openAddServiceModal()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Add Service Card
                        </button>
                    @endif
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                </div>
            </div>

            <div class="space-y-6">
                @foreach($contents as $content)
                <div class="border border-gray-200 rounded-lg p-6 hover:border-gray-300 transition-colors">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">{{ $content->display_name }}</h4>
                            @if($content->description)
                                <p class="text-sm text-gray-600 mt-1">{{ $content->description }}</p>
                            @endif
                            <div class="flex items-center space-x-4 mt-2">
                                <span class="text-xs text-gray-500">Key: {{ $content->section_key }}</span>
                                <span class="text-xs text-gray-500">Type: {{ ucfirst($content->content_type) }}</span>
                                <span class="text-xs text-gray-500">Order: {{ $content->sort_order }}</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="contents[{{ $content->id }}][is_active]" 
                                       value="1"
                                       {{ $content->is_active ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Active</span>
                            </label>
                            <a href="{{ route('admin.page-contents.edit', $content) }}" 
                               class="text-blue-600 hover:text-blue-800 transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" 
                                    class="text-red-600 hover:text-red-800 transition-colors" 
                                    onclick="deleteContent({{ $content->id }}, '{{ addslashes($content->display_name) }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @if($content->content_type === 'textarea')
                            <textarea name="contents[{{ $content->id }}][content_value]" 
                                      rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                                      placeholder="Enter content...">{{ $content->content_value }}</textarea>
                        @elseif($content->content_type === 'text')
                            <input type="text" 
                                   name="contents[{{ $content->id }}][content_value]" 
                                   value="{{ $content->content_value }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter content...">
                        @elseif($content->content_type === 'url')
                            <input type="url" 
                                   name="contents[{{ $content->id }}][content_value]" 
                                   value="{{ $content->content_value }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter URL...">
                        @elseif($content->content_type === 'image')
                            <div class="space-y-2">
                                <input type="text" 
                                       name="contents[{{ $content->id }}][content_value]" 
                                       value="{{ $content->content_value }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Enter image path or URL...">
                                @if($content->content_value)
                                    <div class="mt-2">
                                        <img src="{{ $content->content_value }}" 
                                             alt="Preview" 
                                             class="max-w-xs max-h-32 object-cover rounded-lg border border-gray-200"
                                             onerror="this.style.display='none'">
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>Save All Changes
                </button>
            </div>
        </form>
        @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                <i class="fas fa-file-alt text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Content Found</h3>
            <p class="text-gray-600 mb-6">No content sections found for the {{ $selectedPage }} page.</p>
            <div class="space-x-3">
                <a href="{{ route('admin.page-contents.create', ['page' => $selectedPage]) }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Add Content
                </a>
                <form method="POST" action="{{ route('admin.page-contents.initialize-defaults') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-sync-alt mr-2"></i>Initialize Defaults
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
        
        // Initial resize
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    });
    
    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });
    
    // Delete content function
    window.deleteContent = function(contentId, contentName) {
        if (confirm(`Are you sure you want to delete "${contentName}"? This action cannot be undone.`)) {
            const form = document.getElementById('delete-form-' + contentId);
            if (form) {
                form.submit();
            }
        }
    };
    
    // Add service modal functions
    window.openAddServiceModal = function() {
        document.getElementById('addServiceModal').classList.remove('hidden');
    };
    
    window.closeAddServiceModal = function() {
        document.getElementById('addServiceModal').classList.add('hidden');
    };
    
    // Get next service number
    window.getNextServiceNumber = function() {
        const serviceInputs = document.querySelectorAll('input[name*="service_"][name*="_title"]');
        let maxNumber = 0;
        serviceInputs.forEach(input => {
            const match = input.name.match(/service_(\d+)_title/);
            if (match) {
                maxNumber = Math.max(maxNumber, parseInt(match[1]));
            }
        });
        return maxNumber + 1;
    };
    
    // Set next service number on modal open
    document.addEventListener('click', function(e) {
        if (e.target.matches('[onclick="openAddServiceModal()"]')) {
            document.getElementById('service_number').value = getNextServiceNumber();
        }
    });
});
</script>
@endpush

<!-- Add Service Modal -->
<div id="addServiceModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Add New Service Card</h3>
                <button onclick="closeAddServiceModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.page-contents.add-service-card') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="service_number" class="block text-sm font-medium text-gray-700 mb-1">Service Number</label>
                        <input type="number" id="service_number" name="service_number" min="1" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">FontAwesome Icon Class</label>
                        <input type="text" id="icon" name="icon" placeholder="fa-medical-kit" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">e.g., fa-pills, fa-heart, fa-x-ray</p>
                    </div>
                    
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Service Title</label>
                        <input type="text" id="title" name="title" placeholder="Service Name" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Service Description</label>
                        <textarea id="description" name="description" rows="3" placeholder="Describe the service..." required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"></textarea>
                    </div>
                </div>
                
                <div class="flex items-center justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeAddServiceModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Service
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hidden delete forms for each content item -->
@if($contents->count() > 0)
    @foreach($contents as $content)
        <form id="delete-form-{{ $content->id }}" method="POST" action="{{ route('admin.page-contents.destroy', $content) }}" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endif

@endsection
