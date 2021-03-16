<?php

namespace App\Models;

use App\Models\Office;
use App\Models\OfficeEmployee;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
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
        'office_id'
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
     * Get all of the comments for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function office_sections()
    {
        return $this->hasMany(OfficeEmployee::class, 'employee_id', 'id');
    }

    /**
     * The roles that belong to the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function offices()
    {
        return $this->belongsToMany(Office::class, 'office_employee', 'employee_id', 'office_id')
                    ->withPivot('office_id','employee_id','default')->withTimestamps();
    }

    public function currentOffice()
    {
        $authUser = auth()->user();

        if ($authUser) {
            if(session('currentOffice')) {
                return $authUser->offices()->where('id', session('currentOffice'))->first();
            } else {
                return $authUser->offices()->wherePivot('default', true)->first();
            }
        }

        return null;
    }
}
