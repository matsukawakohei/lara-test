<?php

namespace Tests\Unit\Models;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function タスク作成テスト(): void
    {
        $user = User::factory()->create();
        $task = ['name' => 'タスク'];

        $taskModel = new Task();
        $taskModel->createTask($task, $user->id);

        $this->assertDatabaseHas(
            'tasks',
            [
                'name'    => $task['name'],
                'user_id' => $user->id,
            ]
        );
    }

    /** @test */
    public function タスク取得テスト_0件の場合(): void
    {
        $user = User::factory()->create();
        Task::factory(10)->create();

        $taskModel = new Task();
        $tasks = $taskModel->getTasksByUserId($user->id);

        $this->assertSame(0, $tasks->count());
    }

    /** @test */
    public function タスク取得テスト_1件の場合(): void
    {
        Task::factory(10)->create();
        $user = User::factory()->create();
        Task::factory()->create(['user_id' => $user->id]);
        

        $taskModel = new Task();
        $tasks = $taskModel->getTasksByUserId($user->id);

        $this->assertSame(1, $tasks->count());
    }

    /** @test */
    public function タスク取得テスト_2件以上件の場合(): void
    {
        Task::factory(10)->create();
        $user = User::factory()->create();
        Task::factory(2)->create(['user_id' => $user->id]);
        

        $taskModel = new Task();
        $tasks = $taskModel->getTasksByUserId($user->id);

        $this->assertSame(2, $tasks->count());
    }
}
