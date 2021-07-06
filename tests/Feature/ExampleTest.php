<?php

namespace Tests\Feature;

use Tests\TestCase;
use Vimeo\Laravel\Facades\Vimeo;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
       /*  $response = $this->get('/');

        $response->assertStatus(200); */

        $vimeo = Vimeo::request('/me/videos', ['per_page' => 5], 'GET');

        dd($vimeo);
    }
}
