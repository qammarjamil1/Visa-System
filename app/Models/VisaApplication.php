<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaApplication extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'passport_number',
        'nationality',
        'country_to_visit',
        'country',
        'travel_date',
        'visa_type',
        'document',
        'status',
        'notes',
        'admin_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}