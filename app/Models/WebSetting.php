<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_us_text',
        'vision',
        'mission',
        'about_image',
        'contact_email',
        'contact_phone',
        'address',
        'social_media',
    ];

    protected $casts = [
        'mission' => 'array',
        'social_media' => 'array',
    ];
}
