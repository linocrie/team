<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(GalleryImages::class);
    }

    public function scopeFilterByRelation($query)
    {
        switch (request()->filter) {
            case "all":
                return $query;
            case "moreImages":
                return $query->has('images','>','2');
            default:
                $date = Carbon::today()->subDays(7);
                return $query->where('created_at','>=',$date);
        }
    }
    public function scopeSearchName($query)
    {
        if (request()->search === '') {
            return $query;
        }
        return $query->where('title', 'LIKE' ,"%". request()->search . "%");
    }
}
