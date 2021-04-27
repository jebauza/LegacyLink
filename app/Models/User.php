<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Ceremony;
use App\Models\DeceasedProfile;
use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Events\Registered;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\User\VerifyEmailNotification;
use App\Notifications\User\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
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

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => Registered::class
    ];

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification); // my notification
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    protected $appends = ['fullName'];

    // Attributes
    function getFullNameAttribute()
    {
        return $this->name . ($this->lastname ? ' ' . $this->lastname : '');
    }

    // Scope
    public function scopeEmailDni($query, $param)
    {
        if ($param) {
            $query->where('email', 'like', "%$param%")
                    ->orWhere('dni', 'like', "%$param%");
        }
    }

    // Scope
    public function scopeSearch($query, $param)
    {
        if ($param) {
            $query->where('name', 'like', "%$param%")
                    ->orWhere('lastname', 'like', "%$param%")
                    ->orWhere('email', 'like', "%$param%")
                    ->orWhere('phone', 'like', "%$param%")
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

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    /**
     * The roles that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ceremonies()
    {
        return $this->belongsToMany(Ceremony::class, 'ceremony_user', 'user_id', 'ceremony_id')
                    ->withPivot('ceremony_id','user_id','assistance')
                    ->withTimestamps();
    }

    public function roleProfile($profile_id){
        $profile = $this->deceased_profiles()->find($profile_id);

        if ($profile) {
            return $profile->pivot->role;
        }

        return null;
    }
}
