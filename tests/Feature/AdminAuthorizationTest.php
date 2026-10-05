<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_user_cannot_access_admin_routes(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)
            ->get('/students')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/modules/reports')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/admin/requirements')
            ->assertForbidden();
    }

    public function test_admin_user_can_access_admin_routes(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get('/students')
            ->assertOk();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/students')->assertRedirect('/login');
    }

    public function test_student_cannot_access_web_admin_routes(): void
    {
        $student = \App\Models\Student::factory()->create();

        $this->actingAs($student, 'student')
            ->get('/students')
            ->assertRedirect('/login');
    }
}
