<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    /**
     * Categories supported by the skills section, in display order.
     *
     * @var list<string>
     */
    public const CATEGORIES = ['frontend', 'backend', 'database', 'tools'];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'category',
        'description',
        'icon',
        'proficiency',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'proficiency' => 'integer',
        ];
    }
}
