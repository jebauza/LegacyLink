<?php

namespace App\Jobs\DeceasedProfile;

use App\Helpers\SMSHelper;
use Illuminate\Bus\Queueable;
use App\Models\DeceasedProfile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Mail\DeceasedProfile\DeclarantAccessMail;

class NotificationDeclarantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
    * The number of times the job may be attempted.
    *
    * @var int
    */
    public $tries = 5;

    protected $profile, $send_sms, $send_email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DeceasedProfile $profile, $send_sms = true, $send_email = true)
    {
        $this->profile = $profile->withoutRelations();
        $this->send_sms = $send_sms;
        $this->send_email = $send_email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->profile = $this->profile->fresh('clientDeclarant');
        $client = $this->profile->clientDeclarant->first();
        $token = $client->pivot->token;
        $adviser = $this->profile->adviser;

        if ($this->send_sms) {
            $message = 'Su acceso para la web de ' . $this->profile->fullName . ' es ' . config('albia.web_client_url') . '/admin?token=' . $token . ' .Este acceso es intransferible, solo usted puede utilizarlo.';
            $smsResp = SMSHelper::sendingSMS($client->phone, $message);
        }

        if ($this->send_email) {
            $mail = Mail::to($client->email);
            if ($adviser && $adviser->email) {
                $mail->cc($adviser->email);
            }

            $mail->send(new DeclarantAccessMail($this->profile));
        }
    }
}
