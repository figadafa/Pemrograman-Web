<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'title', 'category', 'creator', 'year', 'studio', 'country', 'genre', 'total_volumes', 'duration_minutes', 'total_chapters'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'media_user')->withTimestamps();
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query, $keyword) {
            $query->where('title', 'like', "%{$keyword}%");
        });
    }
}
