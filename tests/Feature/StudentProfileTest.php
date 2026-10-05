<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_view_profile_page(): void
    {
        $student = Student::factory()->create();

        $response = $this->actingAs($student, 'student')
            ->get(route('student.profile.edit'));

        $response->assertOk();
        $response->assertSee($student->name);
    }

    public function test_student_can_update_name_and_email(): void
    {
        $student = Student::factory()->create([
            'email' => 'old@example.com',
        ]);

        $response = $this->actingAs($student, 'student')
            ->patch(route('student.profile.update'), [
                'name' => 'Updated Name',
                'email' => 'new@example.com',
            ]);

        $response->assertRedirect(route('student.profile.edit'));
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Updated Name',
            'email' => 'new@example.com',
        ]);
    }

    public function test_student_can_update_password(): void
    {
        $student = Student::factory()->create([
            'password' => 'password',
        ]);

        $response = $this->actingAs($student, 'student')
            ->put(route('student.profile.password'), [
                'current_password' => 'password',
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        $response->assertRedirect(route('student.profile.edit'));

        $student->refresh();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('newpassword123', $student->password));
    }

    public function test_guest_cannot_access_student_profile(): void
    {
        $response = $this->get(route('student.profile.edit'));

        $response->assertRedirect(route('login'));
    }
}
