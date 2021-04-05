<?php

namespace App\Models;

use App\Models\DeceasedProfile;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',
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

    protected $appends = ['fullName'];

    // Attributes
    function getFullNameAttribute()
    {
        return $this->name . ($this->lastname ? ' ' . $this->lastname : '');
    }

    public function scopeEmailDni($query, $param)
    {
        if ($param) {
            $query->where('email', 'like', "%$param%")
                    ->orWhere('dni', 'like', "%$param%");
        }
    }

    /**
     * The deceased_profiles that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function deceased_profiles()
    {
        return $this->belongsToMany(DeceasedProfile::class, 'deceased_profile_user', 'user_id', 'profile_id')
                    ->withPivot('profile_id','user_id','role','declarant','token')->withTimestamps();
    }
}
