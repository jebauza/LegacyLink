<?php

namespace App\Models;

use App\Models\Office;
use App\Models\Employee;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfficeEmployee extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'office_employee';

    protected $fillable = ['office_id', 'employee_id', 'default'];

    /**
     * Get the user that owns the OfficeEmployee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    /**
     * Get the user that owns the OfficeEmployee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }
}
