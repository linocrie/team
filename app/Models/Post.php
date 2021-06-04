<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'original_name',
        'path'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function image(): HasOne
    {
        return $this->hasOne(PostImage::class);
    }

    public function professions(): BelongsToMany
    {
        return $this->belongsToMany(Profession::class, 'post_profession');
    }

    public function scopeAuthorize($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopeFilterPosts($query)
    {
        switch (request()->filter) {
            case 'haveProfessions':
                return $query->whereHas('professions');
            case 'haveNotProfessions':
                return $query->whereDoesntHave('professions');
            default:
                return $query;
        }
    }

    public function scopeSearchPosts($query)
    {
        if (request()->search === '') {
            return $query;
        }
        return $query
            ->where(function($query) {
                $query->where('title', 'LIKE', '%' . request()->search . '%');
                $query->orWhere('description', 'LIKE', '%' . request()->search . '%');
            });
    }
}
