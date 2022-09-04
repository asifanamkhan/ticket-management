<?php

namespace App\Models;

use App\Models\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PackageType extends Model
{
    use HasFactory;


    /**
     * Package and Activity ManyToMany Relationship
     *
     *
     */
    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    public function package_days(): HasMany
    {
        return $this->hasMany(Package::class)
                ->leftJoin('days', 'packages.day_id', '=', 'days.id')
                ->select('days.name as day_name', 'packages.*');
    }

    public function days()
    {
        return $this->hasMany(Package::class)
            ->leftJoin('days', 'packages.day_id', '=', 'days.id')
            ->select('days.name as day_name', 'packages.*')
            ->get()
            ->groupBy('day_name');
    }
}
