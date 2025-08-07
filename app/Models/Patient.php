<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'age',
        'sex',
        'email',
        'phone',
        'appointment_id',
    ];

    public function appointment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function getFullNameAttribute(): string
    {
        $name = $this->first_name . ' ' . $this->last_name;
        if ($this->middle_name) {
            $name = $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
        }
        return $name;
    }

    public function getAgeSexAttribute(): string
    {
        return $this->age . ' / ' . $this->sex;
    }
}
