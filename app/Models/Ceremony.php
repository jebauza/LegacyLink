<?php

namespace App\Models;

use App\Models\User;
use App\Models\Video;
use DateTimeInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($ceremony) {
            if ($ceremony->main) {
                DB::table('ceremonies')->where('profile_id', $ceremony->profile_id)->update(['main' => false]);
            }
        });

        static::updating(function ($ceremony) {
            if ($ceremony->main) {
                DB::table('ceremonies')->where('profile_id', $ceremony->profile_id)
                                        ->where('id','!=',$ceremony->id)
                                        ->update(['main' => false]);
            }
        });

        static::deleted(function ($ceremony) {
            if ($ceremony->main && DB::table('ceremonies')->where('profile_id', $ceremony->profile_id)->count() > 0) {
                DB::table('ceremonies')->where('profile_id', $ceremony->profile_id)
                                        ->orderBy('start')
                                        ->take(1)
                                        ->update(['main' => true]);
            }
        });
    }

    public function scopeDeceasedProfile($query, $param)
    {
        if ($param) {
            $query->where('profile_id', $param);
        }
    }

    public function scopeFilterByRole($query)
    {
        return $query->whereHas('profile', function (Builder $q) {
            $q->filterByRole();
        });
    }

    public function scopeStreaming($query)
    {
        $query->where('streaming', true);
    }

    public function scopeOffice($query, $param)
    {
        if ($param) {
            return $query->whereHas('profile', function (Builder $query) use ($param){
                $query->office($param);
            });
        }
    }

    public function scopeProfile($query, $param)
    {
        if ($param) {
            return $query->whereHas('profile', function (Builder $query) use ($param){
                $query->name($param)
                        ->orWhere('web_code', 'like', "%$param%");
            });
        }
    }

    public function scopeDeclarant($query, $param)
    {
        if ($param) {
            return $query->whereHas('profile', function (Builder $query) use ($param){
                $query->declarant($param);
            });
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

    /**
     * Get the user associated with the Ceremony
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function video()
    {
        return $this->hasOne(Video::class, 'ceremony_id', 'id');
    }

}
