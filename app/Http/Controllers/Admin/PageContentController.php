<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageContentController extends Controller
{
    /**
     * Display a listing of page contents
     */
    public function index(Request $request)
    {
        $selectedPage = $request->get('page', 'login');
        
        // Get all available pages
        $pages = PageContent::distinct()->pluck('page_name')->toArray();
        if (empty($pages)) {
            $pages = ['login', 'about', 'location', 'services'];
        }
        
        // Get content for selected page
        $contents = PageContent::forPage($selectedPage)
                              ->orderBy('sort_order')
                              ->orderBy('section_key')
                              ->get();
        
        // Get pages summary for overview
        $pagesSummary = PageContent::getPagesSummary();
        
        return view('admin.page-contents', compact('contents', 'pages', 'selectedPage', 'pagesSummary'));
    }

    /**
     * Show the form for creating a new content section
     */
    public function create(Request $request)
    {
        $pageName = $request->get('page', 'login');
        $pages = ['login', 'about', 'location', 'services'];
        
        return view('admin.page-contents-create', compact('pageName', 'pages'));
    }

    /**
     * Store a newly created content section
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page_name' => 'required|string|in:login,about,location,services',
            'section_key' => 'required|string|max:255|unique:page_contents,section_key,NULL,id,page_name,' . $request->page_name,
            'content_type' => 'required|string|in:text,textarea,image,url',
            'content_value' => 'required|string',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        PageContent::create([
            'page_name' => $request->page_name,
            'section_key' => $request->section_key,
            'content_type' => $request->content_type,
            'content_value' => $request->content_value,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.page-contents.index', ['page' => $request->page_name])
                        ->with('success', 'Content section created successfully!');
    }

    /**
     * Show the form for editing the specified content
     */
    public function edit(PageContent $pageContent)
    {
        $pages = ['login', 'about', 'location', 'services'];
        
        return view('admin.page-contents-edit', compact('pageContent', 'pages'));
    }

    /**
     * Update the specified content
     */
    public function update(Request $request, PageContent $pageContent)
    {
        $validator = Validator::make($request->all(), [
            'page_name' => 'required|string|in:login,about,location,services',
            'section_key' => 'required|string|max:255|unique:page_contents,section_key,' . $pageContent->id . ',id,page_name,' . $request->page_name,
            'content_type' => 'required|string|in:text,textarea,image,url',
            'content_value' => 'required|string',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $pageContent->update([
            'page_name' => $request->page_name,
            'section_key' => $request->section_key,
            'content_type' => $request->content_type,
            'content_value' => $request->content_value,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.page-contents.index', ['page' => $request->page_name])
                        ->with('success', 'Content updated successfully!');
    }

    /**
     * Remove the specified content
     */
    public function destroy(PageContent $pageContent)
    {
        $pageName = $pageContent->page_name;
        $pageContent->delete();

        return redirect()->route('admin.page-contents.index', ['page' => $pageName])
                        ->with('success', 'Content section deleted successfully!');
    }

    /**
     * Bulk update content for a page
     */
    public function bulkUpdate(Request $request)
    {
        $pageName = $request->get('page_name');
        $contents = $request->get('contents', []);

        foreach ($contents as $id => $data) {
            $pageContent = PageContent::find($id);
            if ($pageContent && $pageContent->page_name === $pageName) {
                $pageContent->update([
                    'content_value' => $data['content_value'] ?? $pageContent->content_value,
                    'is_active' => isset($data['is_active'])
                ]);
            }
        }

        return redirect()->route('admin.page-contents.index', ['page' => $pageName])
                        ->with('success', 'Content updated successfully!');
    }

    /**
     * Initialize default content for pages
     */
    public function initializeDefaults()
    {
        $defaultContents = [
            // Login page content
            [
                'page_name' => 'login',
                'section_key' => 'hero_title',
                'content_type' => 'text',
                'content_value' => 'Faith is being sure of what we hope for, and certain of what we do not see.',
                'display_name' => 'Hero Title',
                'description' => 'Main title displayed on the login page hero section',
                'sort_order' => 1
            ],
            [
                'page_name' => 'login',
                'section_key' => 'hero_subtitle',
                'content_type' => 'textarea',
                'content_value' => 'Welcome to RSS Citi Health Services, where compassionate care meets modern medicine. Your health and wellness are our top priorities.',
                'display_name' => 'Hero Subtitle',
                'description' => 'Subtitle text below the main hero title',
                'sort_order' => 2
            ],
            [
                'page_name' => 'login',
                'section_key' => 'services_title',
                'content_type' => 'text',
                'content_value' => 'Our Services',
                'display_name' => 'Services Section Title',
                'description' => 'Title for the services section',
                'sort_order' => 3
            ],
            [
                'page_name' => 'login',
                'section_key' => 'services_subtitle',
                'content_type' => 'textarea',
                'content_value' => 'Discover our comprehensive healthcare services designed to meet your needs',
                'display_name' => 'Services Section Subtitle',
                'description' => 'Subtitle for the services section',
                'sort_order' => 4
            ],
            
            // About page content
            [
                'page_name' => 'about',
                'section_key' => 'hero_title',
                'content_type' => 'text',
                'content_value' => 'About RSS Citi Health Services',
                'display_name' => 'Hero Title',
                'description' => 'Main title for the about page',
                'sort_order' => 1
            ],
            [
                'page_name' => 'about',
                'section_key' => 'hero_description',
                'content_type' => 'textarea',
                'content_value' => 'Dedicated to providing exceptional, compassionate healthcare services since 2005. We combine modern diagnostics with personalized care to improve community wellness.',
                'display_name' => 'Hero Description',
                'description' => 'Description text in the hero section',
                'sort_order' => 2
            ],
            [
                'page_name' => 'about',
                'section_key' => 'story_title',
                'content_type' => 'text',
                'content_value' => 'Our Story',
                'display_name' => 'Story Section Title',
                'description' => 'Title for the company story section',
                'sort_order' => 3
            ],
            [
                'page_name' => 'about',
                'section_key' => 'mission_text',
                'content_type' => 'textarea',
                'content_value' => 'To provide accessible, high-quality healthcare services that promote wellness and improve the quality of life for our patients. We deliver compassionate care addressing physical, emotional, and spiritual needs.',
                'display_name' => 'Mission Statement',
                'description' => 'Company mission statement text',
                'sort_order' => 4
            ],
            [
                'page_name' => 'about',
                'section_key' => 'vision_text',
                'content_type' => 'textarea',
                'content_value' => 'To be the leading healthcare provider in our region, recognized for excellence in diagnostics, preventive care, and patient satisfaction, continuously innovating to deliver the highest standards.',
                'display_name' => 'Vision Statement',
                'description' => 'Company vision statement text',
                'sort_order' => 5
            ],
            
            // Location page content
            [
                'page_name' => 'location',
                'section_key' => 'hero_title',
                'content_type' => 'text',
                'content_value' => 'Find Our Location',
                'display_name' => 'Hero Title',
                'description' => 'Main title for the location page',
                'sort_order' => 1
            ],
            [
                'page_name' => 'location',
                'section_key' => 'hero_description',
                'content_type' => 'textarea',
                'content_value' => 'Visit our state-of-the-art medical facility, conveniently located in Pasig City. We\'re easily accessible and ready to serve you with the best healthcare services.',
                'display_name' => 'Hero Description',
                'description' => 'Description in the hero section',
                'sort_order' => 2
            ],
            [
                'page_name' => 'location',
                'section_key' => 'address',
                'content_type' => 'text',
                'content_value' => '123 Health Avenue, Pasig City, Metro Manila',
                'display_name' => 'Clinic Address',
                'description' => 'Physical address of the clinic',
                'sort_order' => 3
            ],
            [
                'page_name' => 'location',
                'section_key' => 'phone',
                'content_type' => 'text',
                'content_value' => '(02) 8123-4567 / 0917-123-4567',
                'display_name' => 'Phone Numbers',
                'description' => 'Contact phone numbers',
                'sort_order' => 4
            ],
            [
                'page_name' => 'location',
                'section_key' => 'email',
                'content_type' => 'text',
                'content_value' => 'rsscitihealthservices@gmail.com',
                'display_name' => 'Email Address',
                'description' => 'Contact email address',
                'sort_order' => 5
            ],
            
            // Services page content
            [
                'page_name' => 'services',
                'section_key' => 'hero_title',
                'content_type' => 'text',
                'content_value' => 'Our Medical Services',
                'display_name' => 'Hero Title',
                'description' => 'Main title for the services page',
                'sort_order' => 1
            ],
            [
                'page_name' => 'services',
                'section_key' => 'hero_description',
                'content_type' => 'textarea',
                'content_value' => 'We provide a comprehensive range of diagnostic and preventive healthcare services to ensure your well-being. From routine check-ups to specialized testing, our state-of-the-art facility delivers accurate results with compassionate care.',
                'display_name' => 'Hero Description',
                'description' => 'Description in the hero section',
                'sort_order' => 2
            ],
            [
                'page_name' => 'services',
                'section_key' => 'services_title',
                'content_type' => 'text',
                'content_value' => 'Our Medical Services',
                'display_name' => 'Services Section Title',
                'description' => 'Title for the services listing section',
                'sort_order' => 3
            ],
            [
                'page_name' => 'services',
                'section_key' => 'services_subtitle',
                'content_type' => 'textarea',
                'content_value' => 'Comprehensive diagnostic and preventive healthcare services delivered with precision and care',
                'display_name' => 'Services Section Subtitle',
                'description' => 'Subtitle for the services listing section',
                'sort_order' => 4
            ]
        ];

        foreach ($defaultContents as $content) {
            PageContent::updateOrCreate(
                ['page_name' => $content['page_name'], 'section_key' => $content['section_key']],
                $content
            );
        }

        return redirect()->route('admin.page-contents.index')
                        ->with('success', 'Default content initialized successfully!');
    }

    /**
     * Add a new service card
     */
    public function addServiceCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_number' => 'required|integer|min:1',
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $serviceNumber = $request->service_number;

        // Create the three content entries for this service
        PageContent::updateOrCreate(
            ['page_name' => 'services', 'section_key' => "service_{$serviceNumber}_icon"],
            [
                'content_type' => 'text',
                'content_value' => $request->icon,
                'display_name' => "Service {$serviceNumber} Icon",
                'description' => "FontAwesome icon class for service {$serviceNumber}",
                'sort_order' => ($serviceNumber * 3) + 7,
                'is_active' => true
            ]
        );

        PageContent::updateOrCreate(
            ['page_name' => 'services', 'section_key' => "service_{$serviceNumber}_title"],
            [
                'content_type' => 'text',
                'content_value' => $request->title,
                'display_name' => "Service {$serviceNumber} Title",
                'description' => "Title for service {$serviceNumber}",
                'sort_order' => ($serviceNumber * 3) + 8,
                'is_active' => true
            ]
        );

        PageContent::updateOrCreate(
            ['page_name' => 'services', 'section_key' => "service_{$serviceNumber}_description"],
            [
                'content_type' => 'textarea',
                'content_value' => $request->description,
                'display_name' => "Service {$serviceNumber} Description",
                'description' => "Description for service {$serviceNumber}",
                'sort_order' => ($serviceNumber * 3) + 9,
                'is_active' => true
            ]
        );

        return redirect()->route('admin.page-contents.index', ['page' => 'services'])
                        ->with('success', "Service {$serviceNumber} added successfully!");
    }

    /**
     * Get next available service number
     */
    public function getNextServiceNumber()
    {
        $maxService = PageContent::where('page_name', 'services')
                                ->where('section_key', 'like', 'service_%_title')
                                ->get()
                                ->map(function($item) {
                                    preg_match('/service_(\d+)_title/', $item->section_key, $matches);
                                    return isset($matches[1]) ? (int)$matches[1] : 0;
                                })
                                ->max();

        return ($maxService ?? 0) + 1;
    }
}
