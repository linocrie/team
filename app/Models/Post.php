<?php

namespace App\Models;

use App\Scopes\PostUser;
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
}
