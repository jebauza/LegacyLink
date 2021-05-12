<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'visible',
        'streaming'
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

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

    public function scopeDeceasedProfile($query, $param)
    {
        if ($param) {
            $query->where('profile_id', $param);
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

    /**
     * The roles that belong to the Ceremony
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'ceremony_user', 'ceremony_id', 'user_id')
                    ->withPivot('ceremony_id','user_id','assistance')
                    ->withTimestamps();
    }

}
