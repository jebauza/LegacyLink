<?php

namespace App\Models;

use App\Models\User;
use App\Models\Candle;
use DateTimeInterface;
use App\Models\Comment;
use App\Models\Invitation;
use Illuminate\Support\Str;
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
        'photo',
        'title_epitaph',
        'message_epitaph'
    ];

    protected $casts = [
        'birthday' => 'date',
        'death' => 'date',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($profile) {
            $profile->web_code = Str::random(3) . $profile->id . Str::random(3);
            $profile->title_epitaph = 'Para nosotros no te has ido, estás en nuestros corazones';
            $profile->message_epitaph = 'FUISTE UNA PERSONA MUY ESPECIAL SIEMPRE TE LLEVAREMOS EN NUESTROS CORAZONES ASÍ COMO TODAS LAS AVENTURAS VIVIDAS NOS REENCONTRAREMOS EN LA OTRA VIDA';
            $profile->save();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $appends = ['fullName', 'urlPhoto', 'urlWeb'];

    // Attributes
    function getFullNameAttribute()
    {
        return $this->name . ($this->last_name ? ' ' . $this->last_name : '');
    }

    function getUrlPhotoAttribute()
    {
        return Storage::disk('public')->exists($this->photo) ? Storage::disk('public')->url($this->photo) : null;
    }

    function getUrlWebAttribute()
    {
        return config('albia.web_client_url') . '/home/' . $this->web_code;
    }

    // SCOPES
    public function scopeFilterByRole($query)
    {
        $authUser = auth()->user();

        if ($authUser->hasRole('Admin Sucursal')) {
            $offices = $authUser->offices()->pluck('offices.id');
            return $query->whereHas('office', function (Builder $query) use ($offices){
                $query->whereIn('office_id', $offices);
            });
        }

        if ($authUser->hasRole('Asesor')) {
            return $query->where('adviser_id', $authUser->id);
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
                    ->withPivot('profile_id','user_id','role','declarant','token')
                    ->withTimestamps();
    }

    /**
     * The clients that belong to the DeceasedProfile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clientDeclarant()
    {
        return $this->clients()
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

    /**
     * Get all of the comments for the DeceasedProfile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'profile_id', 'id');
    }

    /**
     * Get all of the comments for the DeceasedProfile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function candles()
    {
        return $this->hasMany(Candle::class, 'profile_id', 'id');
    }
}
