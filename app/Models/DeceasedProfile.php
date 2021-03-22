<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
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
    ];

    protected $casts = [
        'birthday' => 'date',
        'death' => 'date',
    ];

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
                    ->withPivot('profile_id','user_id','role')->withTimestamps();
    }
}
