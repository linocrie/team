<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function detail(): HasOne
    {
        return $this->hasOne(Detail::class);
    }

    public function professions(): BelongsToMany
    {
        return $this->belongsToMany(Profession::class, 'user_profession');
    }

    public function avatar(): HasOne
    {
        return $this->hasOne(Avatar::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function scopeFilterUsers($query)
    {
        switch (request()->filter) {
            case 'all':
                return $query;
            case '1':
                return $query->has('posts');
            case '2':
                return $query->doesntHave('posts');
            case '3':
                return $query->has('galleries');
            case '4':
                return $query->doesntHave('galleries');
            case '5':
                return $query->has('professions');
            case '6':
                return $query->doesntHave('professions');
            case '7':
                return $query->has('avatar');
            default:
                return $query->doesntHave('avatar');

        }
    }

    public function scopeSearchUsers($query)
    {
        if (request()->search === '') {
            return $query;
        }
        return $query
            ->where(function($query) {
                $query->where('name', 'LIKE', '%' . request()->search . '%');
                $query->orWhere('email', 'LIKE', '%' . request()->search . '%');
            });
    }
}
