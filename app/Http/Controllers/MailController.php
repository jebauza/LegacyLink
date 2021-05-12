<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeceasedProfile;
use Vimeo\Laravel\Facades\Vimeo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeceasedProfile\DeclarantAccessMail;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $profile = DeceasedProfile::first();
        Mail::to('jebauza1989@gmail.com')->send(new DeclarantAccessMail($profile));
        dd('email enviado'); */

        //$vimeo = Vimeo::request('/me', [], 'GET');
        //$vimeo = Vimeo::request('/me/videos', ["upload" => ["approach" => "live"]], 'POST');

        /* $response = Http::withHeaders([
            'Accept' => 'application/vnd.vimeo.*+json;version=3.4',
            'Authorization' => 'bearer ' . config('vimeo.connections.main.access_token')
        ])
        ->get('https://api.vimeo.com/me'); */

        /* $response = Http::withHeaders([
            'Accept' => 'application/vnd.vimeo.*+json;version=3.4',
            'Authorization' => 'bearer ' . config('vimeo.connections.main.access_token'),
            'Content-Type' => 'application/json'
        ])
        ->post('https://api.vimeo.com/me/videos', [
            'upload' => [
                'approach' => "streaming"
            ],
        ]); */

        /* $response = Http::withHeaders([
            'Accept' => 'application/vnd.vimeo.*+json;version=3.4',
            'Authorization' => 'bearer ' . config('vimeo.connections.main.access_token'),
            'Content-Type' => 'application/json'
        ])
        ->patch('https://api.vimeo.com/videos/548052204', [
            'streaming' => [
                'status' => "ready"
            ],
        ]); */

        /* $response = Http::withHeaders([
            'Accept' => 'application/vnd.vimeo.*+json;version=3.4',
            'Authorization' => 'bearer ' . config('vimeo.connections.main.access_token'),
        ])
        ->get('https://api.vimeo.com/videos/548052204'); */

        /* $vimeo = Vimeo::request('/me/videos', [
            'upload' => [
                'approach' => "streaming",
                'name' => 'albia_2222'
            ]
        ], 'POST'); */

        /* $vimeo = Vimeo::request('/videos/548049279', [
            "streaming" => [
                "status" => "ready"
            ]
        ], 'PATCH'); */

        /* $vimeo = Vimeo::request('/users/139895714/live_events', [
            "title " => 'Algo'
        ], 'POST'); */

        // $this->createVimeo();
        // $this->startVimeo();
        // $this->checkVimeo();
        $this->endVimeo();

    }

    private function createVimeo() {
        $response = Http::withHeaders([
            'Accept' => 'application/vnd.vimeo.*+json;version=3.4',
            'Authorization' => 'bearer ' . config('vimeo.connections.main.access_token'),
            'Content-Type' => 'application/json'
        ])
        ->post('https://api.vimeo.com/me/videos', [
            'upload' => [
                'approach' => "streaming"
            ],
        ]);

        dd($response->json(), $response->headers());
    }

    private function startVimeo() {
        $response = Http::withHeaders([
            'Accept' => 'application/vnd.vimeo.*+json;version=3.4',
            'Authorization' => 'bearer ' . config('vimeo.connections.main.access_token'),
            'Content-Type' => 'application/json'
        ])
        ->patch('https://api.vimeo.com/videos/548284999', [
            'streaming' => [
                'status' => "ready"
            ],
        ]);

        dd($response->json(), $response->headers());
    }

    private function endVimeo() {
        $response = Http::withHeaders([
            'Accept' => 'application/vnd.vimeo.*+json;version=3.4',
            'Authorization' => 'bearer ' . config('vimeo.connections.main.access_token'),
            'Content-Type' => 'application/json'
        ])
        ->patch('https://api.vimeo.com/videos/548284999', [
            'streaming' => [
                'status' => "done"
            ],
        ]);

        dd($response->json(), $response->headers());
    }

    private function checkVimeo() {
        $response = Http::withHeaders([
            'Accept' => 'application/vnd.vimeo.*+json;version=3.4',
            'Authorization' => 'bearer ' . config('vimeo.connections.main.access_token')
        ])
        ->get('https://api.vimeo.com/videos/548284999');

        dd($response->json(), $response->headers());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
