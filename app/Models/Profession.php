<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profession extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_profession');
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_profession');
    }

    public function scopeFilterByRelation($query)
    {
        switch (request()->filter) {
            case "all":
                return $query;
            case "withUsers":
                return $query->whereHas('users');
            case "withPosts":
                return $query->whereHas('posts');
            case "moreFiveUsers":
                return $query->has('users', '>', '5');
            default:
                return $query->has('posts', '>', '5');
        }
    }

    public function scopeSearchName($query)
    {

        if (request()->search === '') {
            return $query;
        }

        return $query->where('name', 'LIKE' ,"%". request()->search . "%");
    }
}
