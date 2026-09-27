<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'institution',
        'degree',
        'field_of_study',
        'location',
        'description',
        'period',
        'sort_order',
    ];
}
