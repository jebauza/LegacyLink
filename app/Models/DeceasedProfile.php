<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function ceremonies()
    {
        return $this->hasMany(Ceremony::class);
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
