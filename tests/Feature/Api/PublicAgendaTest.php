<?php

namespace Tests\Feature\Api;

use App\Models\Ceremony;
use App\Models\DeceasedProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicAgendaTest extends TestCase
{
    /**
     * @test
     * Can list all ceremony types.
     * @return void
    */
    public function can_get_ceremonies_by_profile_id()
    {
        $this->withoutExceptionHandling();

        $profile=DeceasedProfile::factory()
            ->create();

        $ceremonies= Ceremony::factory()
            ->count(3)
            ->create(['profile_id'=>$profile]);

        $response = $this->get(route('api.profile.agenda',['profile_id'=>$profile->id]));

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }
}
