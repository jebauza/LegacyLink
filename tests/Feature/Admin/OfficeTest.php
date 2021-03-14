<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OfficeTest extends TestCase
{
    
    /** @test */
    public function employee_can_view_a_office_list()
    {
        $employee = Employee::factory()->create(['password' => Hash::make('password')]);

        $response = $this->actingAs($employee)->get(route('admin.office.indexView'));

        $response->assertSee('Sucursales', $escaped = true);
    }

    /** @test */
    public function employee_cannot_view_a_office_list()
    {
        $response = $this->get(route('admin.office.indexView'));

        $response->assertRedirect(route('admin.login'));
    }
}
