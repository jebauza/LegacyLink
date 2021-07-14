<?php

namespace App\Models;

use App\Models\DeceasedProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candle extends Model
{
    use HasFactory;

    protected $table = 'candles';

    protected $fillable = ['author','message'];

    public function profile()
    {
        return $this->belongsTo(DeceasedProfile::class,'profile_id');
    }
}
