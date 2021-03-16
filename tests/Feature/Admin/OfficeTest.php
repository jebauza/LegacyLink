<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Office;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OfficeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function employee_can_view_a_office_list()
    {
        $employee = Employee::factory()->create();

        $response = $this->actingAs($employee)->get(route('admin.offices.indexView'));

        $response->assertSee('Sucursales', $escaped = true);
    }

    /** @test */
    public function employee_cannot_view_a_office_list()
    {
        $response = $this->get(route('admin.offices.indexView'));

        $response->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function get_office_index_ok()
    {
        $employee = Employee::factory()->create();

        $response = $this->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])->actingAs($employee)
                    ->getJson(route('admin.ajax.offices.index'));

        $response->assertStatus(200)
                    ->assertJson([
                        'success' => true
                    ]);

        $this->assertAuthenticatedAs($employee);
    }

    /** @test */
    public function post_office_store_ok()
    {
        $employee = Employee::factory()->create();
        $office = Office::factory()->make([
            'created_by' => $employee->id,
            'updated_by' => $employee->id
        ]);

        $response = $this->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])->actingAs($employee)
                    ->postJson(route('admin.ajax.offices.store'),  $office->toArray());

        $response->assertStatus(201)
        ->assertJson([
            'success' => true
        ]);

        $this->assertDatabaseHas('offices', [
            'code' => $office->code,
            'cif' => $office->cif,
            'email' => $office->email
        ]);

        $this->assertAuthenticatedAs($employee);
    }

    /** @test */
    public function put_office_update_ok()
    {
        $employee = Employee::factory()->create();
        $office = Office::factory()->create([
            'created_by' => $employee->id,
            'updated_by' => $employee->id
        ]);

        $office->code = '4444';
        $office->name = 'New name';

        $response = $this->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])->actingAs($employee)
                    ->putJson(route('admin.ajax.offices.update'),  $office->toArray());

        $response->assertStatus(200)
        ->assertJson([
            'success' => true
        ]);

        $this->assertDatabaseHas('offices', [
            'code' => $office->code,
            'cif' => $office->cif,
            'email' => $office->email
        ]);

        $this->assertAuthenticatedAs($employee);
    }
}
