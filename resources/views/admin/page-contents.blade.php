@extends('layouts.admin')

@section('title', 'Page Content Management - RSS Citi Health Services')
@section('page-title', 'Page Content Management')

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

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center space-x-3">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-circle text-red-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-red-800 font-medium mb-2">Please fix the following errors:</p>
                <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Stats Overview Cards -->
    @if($pagesSummary->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @foreach($pagesSummary as $summary)
        <div class="content-card rounded-xl p-6 border-l-4 border-{{ $summary->page_name === 'login' ? 'blue' : ($summary->page_name === 'about' ? 'emerald' : ($summary->page_name === 'location' ? 'amber' : 'purple')) }}-500 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1 capitalize">{{ $summary->page_name }} Page</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $summary->content_count }}</p>
                    <p class="text-xs text-gray-500 mt-1">Last updated: {{ \Carbon\Carbon::parse($summary->last_updated)->format('M j, Y') }}</p>
                </div>
                <div class="w-12 h-12 bg-{{ $summary->page_name === 'login' ? 'blue' : ($summary->page_name === 'about' ? 'emerald' : ($summary->page_name === 'location' ? 'amber' : 'purple')) }}-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-{{ $summary->page_name === 'login' ? 'sign-in-alt' : ($summary->page_name === 'about' ? 'info-circle' : ($summary->page_name === 'location' ? 'map-marker-alt' : 'cogs')) }} text-{{ $summary->page_name === 'login' ? 'blue' : ($summary->page_name === 'about' ? 'emerald' : ($summary->page_name === 'location' ? 'amber' : 'purple')) }}-600 text-lg"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Header Section -->
    <div class="content-card rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-file-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Page Content Management</h3>
                        <p class="text-blue-100 text-sm">Manage content for login, about, location, and services pages</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <form method="POST" action="{{ route('admin.page-contents.initialize-defaults') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors backdrop-blur-sm border border-white/20">
                            <i class="fas fa-sync-alt mr-2"></i>Initialize Defaults
                        </button>
                    </form>
                    <a href="{{ route('admin.page-contents.create', ['page' => $selectedPage]) }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Content
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Page Tabs -->
        <div class="bg-white px-8 py-4 border-b border-gray-200">
            <nav class="flex space-x-8">
                @foreach($pages as $page)
                <a href="{{ route('admin.page-contents.index', ['page' => $page]) }}" 
                   class="py-2 px-4 rounded-lg font-medium text-sm transition-colors {{ $selectedPage === $page ? 'bg-blue-100 text-blue-600' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-{{ $page === 'login' ? 'sign-in-alt' : ($page === 'about' ? 'info-circle' : ($page === 'location' ? 'map-marker-alt' : 'cogs')) }} mr-2"></i>
                    {{ ucfirst($page) }} Page
                </a>
                @endforeach
            </nav>
        </div>
    </div>

    <!-- Content Management Section -->
    <div class="content-card rounded-xl p-8 shadow-lg border border-gray-200">

        <!-- Content Form -->
        @if($contents->count() > 0)
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ ucfirst($selectedPage) }} Page Content</h3>
                <p class="text-gray-600 text-sm mt-1">Manage and edit content sections for the {{ $selectedPage }} page</p>
            </div>
            <div class="flex items-center space-x-3">
                @if($selectedPage === 'services')
                    <button type="button" onclick="openAddServiceModal()" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Service Card
                    </button>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('admin.page-contents.bulk-update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="page_name" value="{{ $selectedPage }}">

            <div class="space-y-4">
                @foreach($contents as $content)
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 hover:shadow-md transition-all duration-200">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $content->display_name }}</h4>
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                    {{ ucfirst($content->content_type) }}
                                </span>
                                <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                    Order: {{ $content->sort_order }}
                                </span>
                            </div>
                            @if($content->description)
                                <p class="text-sm text-gray-600 mb-2">{{ $content->description }}</p>
                            @endif
                            <p class="text-xs text-gray-500">Section Key: <code class="bg-gray-200 px-1 rounded">{{ $content->section_key }}</code></p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="contents[{{ $content->id }}][is_active]" 
                                       value="1"
                                       {{ $content->is_active ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">Active</span>
                            </label>
                            <a href="{{ route('admin.page-contents.edit', $content) }}" 
                               class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" 
                                    class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors" 
                                    onclick="deleteContent({{ $content->id }}, '{{ addslashes($content->display_name) }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        @if($content->content_type === 'textarea')
                            <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                            <textarea name="contents[{{ $content->id }}][content_value]" 
                                      rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-vertical"
                                      placeholder="Enter content...">{{ $content->content_value }}</textarea>
                        @elseif($content->content_type === 'text')
                            <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                            <input type="text" 
                                   name="contents[{{ $content->id }}][content_value]" 
                                   value="{{ $content->content_value }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter content...">
                        @elseif($content->content_type === 'url')
                            <label class="block text-sm font-medium text-gray-700 mb-2">URL</label>
                            <input type="url" 
                                   name="contents[{{ $content->id }}][content_value]" 
                                   value="{{ $content->content_value }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter URL...">
                        @elseif($content->content_type === 'image')
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image Path/URL</label>
                            <div class="space-y-3">
                                <input type="text" 
                                       name="contents[{{ $content->id }}][content_value]" 
                                       value="{{ $content->content_value }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter image path or URL...">
                                @if($content->content_value)
                                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                        <img src="{{ $content->content_value }}" 
                                             alt="Preview" 
                                             class="w-16 h-16 object-cover rounded-lg border border-gray-200"
                                             onerror="this.style.display='none'">
                                        <div class="text-sm text-gray-600">
                                            <p class="font-medium">Image Preview</p>
                                            <p class="text-xs">{{ basename($content->content_value) }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-200">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <i class="fas fa-save mr-2"></i>Save All Changes
                </button>
            </div>
        </form>
        @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                <i class="fas fa-file-alt text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Content Found</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">No content sections found for the {{ $selectedPage }} page. Get started by adding content or initializing default sections.</p>
            <div class="flex items-center justify-center space-x-4">
                <a href="{{ route('admin.page-contents.create', ['page' => $selectedPage]) }}" 
                   class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <i class="fas fa-plus mr-2"></i>Add Content
                </a>
                <form method="POST" action="{{ route('admin.page-contents.initialize-defaults') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
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
<div id="addServiceModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
    <div class="relative mx-auto p-0 border-0 w-full max-w-md shadow-2xl rounded-xl bg-white">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-plus text-white"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Add New Service Card</h3>
                </div>
                <button onclick="closeAddServiceModal()" class="text-white/70 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6">
            <form method="POST" action="{{ route('admin.page-contents.add-service-card') }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="service_number" class="block text-sm font-semibold text-gray-700 mb-2">Service Number</label>
                        <input type="number" id="service_number" name="service_number" min="1" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    </div>
                    
                    <div>
                        <label for="icon" class="block text-sm font-semibold text-gray-700 mb-2">FontAwesome Icon Class</label>
                        <input type="text" id="icon" name="icon" placeholder="fa-medical-kit" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                        <p class="text-xs text-gray-500 mt-1">e.g., fa-pills, fa-heart, fa-x-ray</p>
                    </div>
                    
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Service Title</label>
                        <input type="text" id="title" name="title" placeholder="Service Name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Service Description</label>
                        <textarea id="description" name="description" rows="3" placeholder="Describe the service..." required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 resize-vertical transition-colors"></textarea>
                    </div>
                </div>
                
                <div class="flex items-center justify-end space-x-3 mt-8 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeAddServiceModal()" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-medium">
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
