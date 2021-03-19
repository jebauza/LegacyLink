<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Office extends Model
{
    use HasFactory;

    protected $table = 'offices';

    protected $fillable = ['code','name','cif','address','extra_address','city','cp','province','country','timezone','phone','contact_person','email','latitude','longitude'];

    public function scopeFilterByRole($query)
    {
        $authUser = auth()->user();

        if (!$authUser->hasRole('Super Admin')) {
            $offices = $authUser->offices()->pluck('offices.id');
            $query->whereIn('id', $offices);
        }
    }

    /**
     * The roles that belong to the Office
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'office_employee', 'office_id', 'employee_id')
                    ->withPivot('office_id','employee_id')->withTimestamps();
    }

    /**
     * Get all of the comments for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employee_sections()
    {
        return $this->hasMany(OfficeEmployee::class, 'office_id', 'id');
    }
}
