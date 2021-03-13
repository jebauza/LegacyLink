<?php

namespace App\Models;

use App\Models\Employee;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfficeEmployee extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'office_employee';

    /**
     * Get the user that owns the OfficeEmployee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
