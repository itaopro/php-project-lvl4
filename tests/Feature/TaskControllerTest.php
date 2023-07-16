<?php
namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверяем, что гость не может получить доступ к форме создания задачи.
     *
     * @return void
     */
    public function testGuestCannotAccessCreateForm()
    {
        $response = $this->get(route('tasks.create'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Проверяем, что пользователь может получить доступ к форме создания задачи.
     *
     * @return void
     */
    public function testUserCanAccessCreateForm()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.create'));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.create');
    }

    /**
     * Проверяем, что гость не может создать задачу.
     *
     * @return void
     */
    public function testGuestCannotStoreTask()
    {
        $taskData = [
            'name' => 'New Task',
            'description' => 'Task description',
            'status_id' => TaskStatus::factory()->create()->id,
        ];

        $response = $this->post(route('tasks.store'), $taskData);

        $response->assertRedirect(route('login'));

        $this->assertDatabaseMissing('tasks', $taskData);
    }

    /**
     * Проверяем, что пользователь может создать задачу.
     *
     * @return void
     */
    public function testUserCanStoreTask()
    {
        $user = User::factory()->create();

        $taskData = [
            'name' => 'New Task',
            'description' => 'Task description',
            'status_id' => TaskStatus::factory()->create()->id,
        ];

        $response = $this->actingAs($user)->post(route('tasks.store'), $taskData);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', $taskData);
    }

    /**
     * Проверяем, что гость не может получить доступ к форме редактирования задачи.
     *
     * @return void
     */
    public function testGuestCannotAccessEditForm()
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', $task));

        $response->assertRedirect(route('login'));
    }

    /**
     * Проверяем, что пользователь может получить доступ к форме редактирования задачи.
     *
     * @return void
     */
    public function testUserCanAccessEditForm()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.edit', $task));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.edit');
    }

    /**
     * Проверяем, что гость не может обновить задачу.
     *
     * @return void
     */
    public function testGuestCannotUpdateTask()
    {
        $task = Task::factory()->create();

        $taskData = [
            'name' => 'Updated Task',
            'description' => 'Updated task description',
            'status_id' => TaskStatus::factory()->create()->id,
        ];

        $response = $this->put(route('tasks.update', $task), $taskData);

        $response->assertRedirect(route('login'));

        $this->assertDatabaseMissing('tasks', $taskData);
    }

    /**
     * Проверяем, что пользователь может обновить задачу.
     *
     * @return void
     */
    public function testUserCanUpdateTask()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $taskData = [
            'name' => 'Updated Task',
            'description' => 'Updated task description',
            'status_id' => TaskStatus::factory()->create()->id,
        ];

        $response = $this->actingAs($user)->put(route('tasks.update', $task), $taskData);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', $taskData);
    }

    /**
     * Проверяем, что гость не может удалить задачу.
     *
     * @return void
     */
    public function testGuestCannotDeleteTask()
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    /**
     * Проверяем, что пользователь может удалить свою задачу.
     *
     * @return void
     */
    public function testUserCanDeleteOwnTask()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /**
     * Проверяем, что пользователь не может удалить задачу, созданную другим пользователем.
     *
     * @return void
     */
    public function testUserCannotDeleteOtherUserTask()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $otherUser->id]);

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}
