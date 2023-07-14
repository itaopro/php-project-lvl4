<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TaskStatus;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCannotAccessCreateForm()
    {
        $response = $this->get(route('task_statuses.create'));

        $response->assertRedirect(route('login'));
    }

    public function testUserCanAccessCreateForm()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('task_statuses.create'));

        $response->assertStatus(200);
        $response->assertViewIs('task_statuses.create');
    }

    public function testGuestCannotStoreStatus()
    {
        $response = $this->post(route('task_statuses.store'), [
            'name' => 'New Status',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('task_statuses', 0);
    }

    public function testUserCanStoreStatus()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('task_statuses.store'), [
                'name' => 'New Status',
            ]);

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', [
            'name' => 'New Status',
        ]);
    }
}

