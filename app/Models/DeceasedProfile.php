<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeceasedProfile extends Model
{
    use HasFactory;

    protected $table = 'deceased_profiles';

    protected $fillable = [
        'name',
        'last_name',
        'birthday',
        'death',
        'adviser_id',
        'office_id',
        'photo'
    ];

    protected $casts = [
        'birthday' => 'date',
        'death' => 'date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'token'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $appends = ['fullName', 'urlPhoto'];

    // Attributes
    function getFullNameAttribute()
    {
        return $this->name . ($this->lastname ? ' ' . $this->lastname : '');
    }

    function getUrlPhotoAttribute()
    {
        return Storage::disk('public')->exists($this->photo) ? Storage::disk('public')->url($this->photo) : null;
    }

    // SCOPES
    public function scopeFilterByRole($query)
    {
        $authUser = auth()->user();

        if (!$authUser->hasRole('Super Admin')) {
            $offices = $authUser->offices()->pluck('offices.id');
            return $query->whereHas('office', function (Builder $query) use ($offices){
                $query->whereIn('office_id', $offices);
            });
        }
    }

    public function scopeOffice($query, $param)
    {
        if ($param) {
            $query->where('office_id', $param);
        }
    }

    public function scopeName($query, $param)
    {
        if ($param) {
            $query->where('name', 'like',"%$param%")
                    ->orWhere('last_name', 'like',"%$param%");
        }
    }

    public function scopeDeclarant($query, $param)
    {
        if ($param) {
            return $query->whereHas('clients', function (Builder $query) use ($param){
                $query->where('deceased_profile_user.declarant', true)
                        ->where(function($query) use ($param){
                            $query->where('users.name', 'like',"%$param%")
                                    ->orWhere('users.lastname', 'like',"%$param%")
                                    ->orWhere('users.phone', 'like',"%$param%")
                                    ->orWhere('users.email', 'like',"%$param%")
                                    ->orWhere('users.dni', 'like',"%$param%");
                        });
            });
        }
    }

    /**
     * Get all of the ceremonies for the DeceasedProfile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ceremonies()
    {
        return $this->hasMany(Ceremony::class, 'profile_id', 'id');
    }

    /**
     * Get the office that owns the DeceasedProfile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }

    /**
     * Get the adviser that owns the DeceasedProfile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adviser()
    {
        return $this->belongsTo(Employee::class, 'adviser_id', 'id');
    }

    /**
     * The clients that belong to the DeceasedProfile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clients()
    {
        return $this->belongsToMany(User::class, 'deceased_profile_user', 'profile_id', 'user_id')
                    ->withPivot('profile_id','user_id','role','declarant')->withTimestamps();
    }

    /**
     * The clients that belong to the DeceasedProfile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clientDeclarant()
    {
        return $this->belongsToMany(User::class, 'deceased_profile_user', 'profile_id', 'user_id')
                    ->withPivot('profile_id','user_id','role','declarant')->withTimestamps()
                    ->wherePivot('declarant', true);
    }


    /**
     * Get all of the comments for the DeceasedProfile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'profile_id', 'id');
    }
}
