<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicalTestCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function medicalTests(): HasMany
    {
        return $this->hasMany(MedicalTest::class)->orderBy('sort_order');
    }

    public function activeMedicalTests(): HasMany
    {
        return $this->hasMany(MedicalTest::class)->where('is_active', true)->orderBy('sort_order');
    }
}
