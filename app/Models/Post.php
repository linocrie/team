<?php

namespace App\Models;

//use App\Scopes\PostScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

//    public function scopeAuthorize($query)
//    {
//        return $query->where('user_id', auth()->user()->id);
//    }

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
}
