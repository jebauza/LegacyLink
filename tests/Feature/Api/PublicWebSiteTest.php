<?php

namespace Tests\Feature\Api;

use App\Models\DeceasedProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicWebSiteTest extends TestCase
{
    /**
     * @test
     * Can list all ceremony types.
     * @return void
    */
    public function can_get_deceased_profile_by_id()
    {
        $this->withoutExceptionHandling();
        
        $profile=DeceasedProfile::factory()->create();

        $response = $this->get(route('api.profile.byId',['profile_id'=>$profile->id]));

        $response->assertStatus(200)
        ->assertJsonStructure(['data']);
    }
}
