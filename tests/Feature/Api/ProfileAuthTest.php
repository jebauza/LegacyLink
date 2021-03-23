<?php

namespace Tests\Feature\Api;

use App\Models\DeceasedProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileAuthTest extends TestCase
{
    

    /**
     * @test
     * Can attempt user admin profile by token.
     * @return void
    */
    public function can_attempt_profile_by_token()
    {
        $this->withoutExceptionHandling();
        $profile = DeceasedProfile::factory()
        ->hasAttached(User::factory()->count(1),[
            'role' => 'admin',
            'declarant' => true
        ],'clients')
        ->create();



        $response = $this->get(route('api.auth.login.profile',['token'=>$profile->token]));

        $response->assertStatus(200)
         ;
    }
}
