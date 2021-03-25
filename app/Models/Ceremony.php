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
        'profile_id',
        'visible'
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    // SCOPES
    public function scopeVisibleClient($query, $clientRole)
    {
        if ($clientRole) {
            if ($clientRole == 'close_friend') {
                $query->where('visible', 'close_friend')
                        ->orWhere('visible', 'public');
            }
        }
    }

    public function profile()
    {
        return $this->belongsTo(DeceasedProfile::class,'profile_id');
    }

    public function type()
    {
        return $this->belongsTo(CeremonyType::class,"type_id");
    }
}
