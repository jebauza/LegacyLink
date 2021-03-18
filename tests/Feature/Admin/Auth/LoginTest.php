<?php

namespace Tests\Feature\Admin\Auth;

use Tests\TestCase;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function employee_can_view_a_login_form()
    {
        $response = $this->get(route('admin.login'));

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function employee_cannot_view_a_login_form_when_authenticated()
    {
        $employee = Employee::factory()->create();

        $response = $this->actingAs($employee)->get(route('admin.login'));

        $response->assertRedirect(route('admin.home'));
    }

    /** @test */
    public function employee_can_login_with_correct_credentials()
    {
        $password = 'password';
        $employee = Employee::factory()->create(['password' => Hash::make($password)]);

        $response = $this->post(route('admin.login'), [
            'email' => $employee->email,
            'password' => $password,
        ]);

        $response->assertRedirect(route('admin.home'));
        $this->assertAuthenticatedAs($employee);
    }

    /** @test */
    public function employee_cannot_login_with_incorrect_password()
    {
        $employee = Employee::factory()->create();

        $response = $this->from(route('admin.login'))->post(route('admin.login'), [
            'email' => $employee->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertGuest();
    }

    /** @test */
    public function remember_me_functionality()
    {
        $password = 'password';
        $employee = Employee::factory()->create(['password' => Hash::make($password)]);

        $response = $this->post(route('admin.login'), [
            'email' => $employee->email,
            'password' => $password,
            'remember' => 'on',
        ]);

        $response->assertRedirect(route('admin.home'));
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $employee->id,
            $employee->getRememberToken(),
            $employee->password,
        ]));
        $this->assertAuthenticatedAs($employee);
    }
}
