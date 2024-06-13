<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Traits\Filterable;

class Movie extends Model
{
    use HasFactory;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'directors',
        'writers',
        'actors',
        'name',
        'duration',
        'image',
        'released',
        'rating',
        'description',
        'imdb',
        'trailer'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [

        ];
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'movie_category');
    }

    public function reactions(): BelongsToMany
    {
        return $this->belongsToMany(Reaction::class, 'movie_reaction');
    }

    public function showings(): HasMany
    {
        return  $this->hasMany(Showing::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_movie');
    }

}
