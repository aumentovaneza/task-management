<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TaskEndpointTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_all_tasks_endpoint_to_return_data()
    {
        $user = User::factory()->create();
        $tasks = Task::factory()->count(2)->create();
        $response = $this->actingAs($user, 'api')
            ->get('api/v1/tasks');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $tasks[0]->id,
            'name' => $tasks[0]->name,
        ]);
    }

    public function test_get_a_task_endpoint_to_return_data()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $response = $this->actingAs($user, 'api')
            ->get('api/v1/tasks/' . $task->id);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $task->id,
            'name' => $task->name,

        ]);
    }

    public function test_create_a_task_endpoint_to_successfully_add_data()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')
            ->postJson('api/v1/tasks/',[
                'name' => 'Test Task'
            ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'Test Task',
        ]);
    }

    public function test_update_an_existing_task_endpoint_to_successfully_update_data()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'name' => 'Task Task 1'
        ]);

        $response = $this->actingAs($user, 'api')
            ->putJson('api/v1/tasks/' .  $task->id ,[
                'name' => 'Test Task 2'
            ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'name' => 'Test Task 2',
        ]);
    }

    public function test_delete_endpoint_to_successfully_delete_data()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'name' => 'Task Task 1'
        ]);

        $response = $this->actingAs($user, 'api')
            ->delete('api/v1/tasks/' .  $task->id);
        $response->assertStatus(204);
    }
}
