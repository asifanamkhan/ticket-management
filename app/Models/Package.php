<?php

namespace App\Models;

use App\Models\Activity;
use App\Models\PackageType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Package extends Model
{
    use HasFactory, SoftDeletes;


    /**
     * Package and Activity ManyToMany Relationship
     *
     *
     */
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(
            Activity::class,
            'package_activity',
            'package_id',
            'activity_id'
            )->withPivot('day_limit', 'limit_per_visitor')
            ->withTimestamps();
    }

    /**
     * Return day model.
     *
     */
    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class, 'day_id');
    }

    /**
     * Return type model.
     *
     */
    public function package_type(): BelongsTo
    {
        return $this->belongsTo(PackageType::class, 'package_type_id');
    }

    /**
     * Return type model.
     *
     */
    public function free_activities()
    {
        return $this->belongsToMany(
            Activity::class,
            'package_activity',
            'package_id',
            'activity_id'
        )
        ->wherePrice(0)
        ->whereConcert(0)
        ->withPivot('day_limit', 'limit_per_visitor')
        ->withTimestamps()
        ->get();
    }

    /**
     * Return type model.
     *
     */
    public function paid_activities()
    {
        return $this->belongsToMany(
            Activity::class,
            'package_activity',
            'package_id',
            'activity_id'
        )
        ->where('price', '>', 0)
        ->whereConcert(0)
        ->withPivot('day_limit', 'limit_per_visitor')
        ->withTimestamps()
        ->get();
    }

    /**
     * Return type model.
     *
     */
    public function concert_activities()
    {
        return $this->belongsToMany(
            Activity::class,
            'package_activity',
            'package_id',
            'activity_id'
        )
        ->where('price', '>', 0)
        ->whereConcert(1)
        ->withPivot('day_limit', 'limit_per_visitor')
        ->withTimestamps()
        ->get();
    }

}
