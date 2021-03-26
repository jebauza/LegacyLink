<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Http;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Log;

class SMSHelper {

// https://www.360nrs.com/apis/sms-gateway-http

    // Envio de sms
    public static function sendingSMS($phone, $text) {

        $user = config('360nrs.credentials.user');
        $password = config('360nrs.credentials.password');
        $url_api = config('360nrs.api');

        $phone_number = (string) PhoneNumber::make($phone)->ofCountry('ES');  // +3412345678;
        $phone_number = str_replace ('+' , '', $phone_number);

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                // 'Authorization' => 'Basic ' . base64_encode($user . ":" . $password)
            ])
            ->withBasicAuth($user, $password)
            ->post($url_api, [
                'message' => $text,
                'to' => [$phone_number],
                'from' => 'ALBIA',
                'campaignName' => 'Albia'
            ]);

            if ($response->successful()) {
                // $response->getBody()->getContents()
                return json_decode($response->getBody());
            } elseif ($response->failed()) {
                Log::channel('sms')->debug('SMS failed ' . $response->throw());
                return null;
            }

            return null;
        } catch (\Exception $e) {
           Log::channel('sms')->debug('SMS failed ' . $e->getMessage());
           return null;
        }
    }

    public static function internationalPhone($phone , $country = 'ES'){
        return (string) PhoneNumber::make($phone)->ofCountry($country);
    }

    public static function nationalPhone($phone, $country = 'ES'){
        return PhoneNumber::make($phone, $country)->formatForMobileDialingInCountry($country);
    }
}
