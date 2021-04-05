<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Office extends Model
{
    use HasFactory;

    protected $table = 'offices';

    protected $fillable = ['name','cif','address','extra_address','city','cp','province','country','timezone','phone','contact_person','email','latitude','longitude'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($office) {
            $office->phone = (string) PhoneNumber::make($office->phone)->ofCountry('ES'); // +3412345678;
        });

        static::updating(function ($office) {
            $office->phone = (string) PhoneNumber::make($office->phone)->ofCountry('ES'); // +3412345678;
        });
    }

    // SCOPES
    public function scopeFilterByRole($query)
    {
        $authUser = auth()->user();

        if (!$authUser->hasRole('Super Admin')) {
            $offices = $authUser->offices()->pluck('offices.id');
            $query->whereIn('id', $offices);
        }
    }

    public function scopeName($query, $param)
    {
        if ($param) {
            $query->where('name', 'like', "%$param%");
        }
    }

    public function scopeAddress($query, $param)
    {
        if ($param) {
            $query->where('address', 'like', "%$param%")
                ->orWhere('extra_address', 'like', "%$param%")
                ->orWhere('city', 'like', "%$param%")
                ->orWhere('cp', 'like', "%$param%");
        }
    }

    protected $appends = ['fullAddress'];

    // Attributes
    function getFullAddressAttribute()
    {
        return $this->address
                . ($this->extra_address ? ', ' . $this->extra_address : '')
                . ($this->cp ? ', ' . $this->cp : '')
                . ($this->city ? ' ' . $this->city : '')
                . ($this->country ? ', ' . $this->country : '');
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
