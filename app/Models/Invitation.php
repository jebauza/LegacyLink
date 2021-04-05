<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Str;
use App\Models\DeceasedProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $table = 'invitations';

    protected $fillable = ['phone','message','role','email', 'name'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($invitation) {
            $invitation->phone = (string) PhoneNumber::make($invitation->phone)->ofCountry('ES'); // +3412345678;
            $id = DB::table('invitations')->max('id');
            $invitation->token = Str::random(8) . ($id ? $id+1 : 1);
            $profile = DeceasedProfile::find($invitation->profile_id);
            $invitation->message = "Se le ha invitado a unirse a la web de " .$profile->fullName. " su link es " . config('albia.web_client_url') . "/invitation?token=" . $invitation->token . "&profile=" . $profile->web_code;
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Get the user that owns the Invitation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(DeceasedProfile::class, 'profile_id');
    }
}
