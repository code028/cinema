<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cinema extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'location',
    ];

    // public function showings(): BelongsToMany
    // {
    //     return $this->belongsToMany(Showing::class, 'airings')
    //                 ->using(Airing::class)
    //                 ->withPivot('startTime', 'endTime', 'day')
    //                 ->withTimestamps();
    // }

    public function showings(): BelongsToMany
    {
        return $this->belongsToMany(Showing::class, 'airings')
                    ->withPivot('room_id', 'startTime', 'endTime', 'day');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function airings(): HasMany
    {
        return $this->hasMany(Airing::class);
    }

}
