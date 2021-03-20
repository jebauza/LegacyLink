<?php

namespace App\Models;

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

    public function ceremonies()
    {
        return $this->hasMany(Ceremony::class,'profile_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function adviser()
    {
        return $this->belongsTo(Employee::class);
    }
}
