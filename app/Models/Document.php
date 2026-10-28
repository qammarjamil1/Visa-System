<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'user_id',
        'visa_application_id',
        'name',
        'type',
        'path',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function visaApplication()
    {
        return $this->belongsTo(VisaApplication::class);
    }
}