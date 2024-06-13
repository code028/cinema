<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Showing extends Model
{
    use HasFactory;
    use Filterable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'movie_id',
        'name',
        'from_date',
        'to_date',
        'active'
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

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    // public function cinemas(): BelongsToMany
    // {
    //     return $this->belongsToMany(Cinema::class, 'airings')
    //                 ->using(Airing::class)
    //                 ->withPivot('startTime', 'endTime', 'day')
    //                 ->withTimestamps();
    // }

    public function cinemas(): BelongsToMany
    {
        return $this->belongsToMany(Cinema::class, 'airings')
                    ->withPivot('startTime', 'endTime', 'day');
    }

    public function airings(): HasMany
    {
        return $this->hasMany(Airing::class);
    }
}
