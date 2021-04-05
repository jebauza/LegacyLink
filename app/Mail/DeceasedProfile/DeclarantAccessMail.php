<?php

namespace App\Mail\DeceasedProfile;

use App\Models\DeceasedProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeclarantAccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $profile;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(DeceasedProfile $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->profile = $this->profile->fresh('clientDeclarant');

        $client = $this->profile->clientDeclarant()->first();
        $token = $client->pivot->token;

        return $this->subject('Gracias por utilizar nuestro servicio Albia')
                    ->markdown('emails.deceasedProfiles.declarantAccess')
                    ->with([
                        'client' => $client,
                        'profile' => $this->profile,
                        'token' => $token
                    ]);
    }
}
