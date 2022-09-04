<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetAdminPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SpecialUser extends User
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'full_name',
        'company_name',
        'type',
        'email',
        'mobile',
        'address',
        'city',
        'country_id',
        'password',
        'document',
    ];



    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
