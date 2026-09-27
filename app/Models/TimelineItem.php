<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimelineItem extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'period',
        'sort_order',
    ];
}
