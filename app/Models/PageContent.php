<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'section_key',
        'content_type',
        'content_value',
        'display_name',
        'description',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get content by page name
     */
    public static function getPageContent($pageName)
    {
        return self::where('page_name', $pageName)
                   ->where('is_active', true)
                   ->orderBy('sort_order')
                   ->get()
                   ->keyBy('section_key');
    }

    /**
     * Get specific content value
     */
    public static function getContent($pageName, $sectionKey, $default = '')
    {
        $content = self::where('page_name', $pageName)
                      ->where('section_key', $sectionKey)
                      ->where('is_active', true)
                      ->first();
        
        return $content ? $content->content_value : $default;
    }

    /**
     * Update or create content
     */
    public static function updateContent($pageName, $sectionKey, $value, $attributes = [])
    {
        return self::updateOrCreate(
            ['page_name' => $pageName, 'section_key' => $sectionKey],
            array_merge(['content_value' => $value], $attributes)
        );
    }

    /**
     * Get all pages with their content counts
     */
    public static function getPagesSummary()
    {
        return self::selectRaw('page_name, COUNT(*) as content_count, MAX(updated_at) as last_updated')
                   ->where('is_active', true)
                   ->groupBy('page_name')
                   ->orderBy('page_name')
                   ->get();
    }

    /**
     * Scope for active content
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for specific page
     */
    public function scopeForPage($query, $pageName)
    {
        return $query->where('page_name', $pageName);
    }
}
