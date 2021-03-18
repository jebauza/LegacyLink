<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ceremony extends Model
{
    use HasFactory;

    protected $table = 'ceremonies';

    protected $fillable = [
        'main',
        'start',
        'end',
        'room_name',
        'additional_info',
        'address',
        'latitude',
        'longitude',
        'type_id',
        'profile_id'
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function profile()
    {
        return $this->belongsTo(DeceasedProfile::class,'profile_id');
    }

    public function type()
    {
        return $this->belongsTo(CeremonyType::class,"type_id");
    }
}
