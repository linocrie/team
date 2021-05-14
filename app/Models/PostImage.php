<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PostImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'original_name',
        'path',
        'processed'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

}
