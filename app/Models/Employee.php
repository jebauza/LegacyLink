<?php

namespace App\Models;

use App\Models\Office;
use App\Models\OfficeEmployee;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $table = 'employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_name',
        'phone',
        'extra_info'
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


    public function scopeFilterByRole($query)
    {
        $authUser = auth()->user();

        if (!$authUser->hasRole('Super Admin')) {
            $offices = $authUser->offices()->pluck('offices.id');
            return $query->whereHas('offices', function (Builder $query) use ($offices){
                $query->whereIn('offices.id', $offices);
            });
        }

    }

    /**
     * The roles that belong to the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function offices()
    {
        return $this->belongsToMany(Office::class, 'office_employee', 'employee_id', 'office_id')
                    ->withPivot('office_id','employee_id')->withTimestamps();
    }


    /**
     * The roles that belong to the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getCanAssignRoles()
    {
        $myRole = $this->roles()->orderBy('id')->first();

        if ($myRole) {
            return Role::where('id', '>=', $myRole->id)->get();
        }

        return collect([]);
    }
}
