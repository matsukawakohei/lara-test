<?php

namespace Tests\Unit\Dao;

use App\Dao\TaskDao;
use App\Dao\UserDao;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function タスク作成テスト(): void
    {
        $user = [
            'name'     => 'テスト太郎',
            'email'    => 'test1@exmaple.com',
            'password' => 'password',
        ];
        $userDao = new UserDao();
        $userDao->createUser($user);
        $createdUser = DB::table('users')
                        ->select('id')
                        ->orderBy('id', 'DESC')
                        ->first();
        $task = ['name' => 'タスク'];

        $taskDao = new TaskDao();
        $taskDao->createTask($task, $createdUser->id);

        $this->assertDatabaseHas(
            'tasks',
            [
                'name'    => $task['name'],
                'user_id' => $createdUser->id,
            ]
        );
    }

    /** @test */
    public function タスク取得テスト_0件の場合(): void
    {
        $user1 = [
            'name'     => 'テスト太郎',
            'email'    => 'test1@exmaple.com',
            'password' => 'password',
        ];
        $user2 = [
            'name'     => 'テスト次郎',
            'email'    => 'test2@exmaple.com',
            'password' => 'password',
        ];
        $userDao = new UserDao();
        $userDao->createUser($user1);
        $userDao->createUser($user2);
        $createdUser1 = DB::table('users')
                        ->select('id')
                        ->orderBy('id', 'DESC')
                        ->first();
        $createdUser2 = DB::table('users')
                        ->select('id')
                        ->orderBy('id')
                        ->first();
        $taskDao = new TaskDao();
        for ($i = 1; $i <= 10; $i++) {
            $task = ['name' => "タスク{$i}"];
            $taskDao->createTask($task, $createdUser1->id);
        }
        
        $tasks = $taskDao->getTasksByUserId($createdUser2->id);

        $this->assertSame(0, $tasks->count());
    }

    /** @test */
    public function タスク取得テスト_1件の場合(): void
    {
        $user1 = [
            'name'     => 'テスト太郎',
            'email'    => 'test1@exmaple.com',
            'password' => 'password',
        ];
        $user2 = [
            'name'     => 'テスト次郎',
            'email'    => 'test2@exmaple.com',
            'password' => 'password',
        ];
        $userDao = new UserDao();
        $userDao->createUser($user1);
        $userDao->createUser($user2);
        $createdUser1 = DB::table('users')
                        ->select('id')
                        ->orderBy('id', 'DESC')
                        ->first();
        $createdUser2 = DB::table('users')
                        ->select('id')
                        ->orderBy('id')
                        ->first();
        $taskDao = new TaskDao();
        for ($i = 1; $i <= 10; $i++) {
            $task = ['name' => "タスク{$i}"];
            $taskDao->createTask($task, $createdUser1->id);
        }
        $task = ['name' => "タスク"];
        $taskDao->createTask($task, $createdUser2->id);
        
        $tasks = $taskDao->getTasksByUserId($createdUser2->id);

        $this->assertSame(1, $tasks->count());
    }

    /** @test */
    public function タスク取得テスト_2件以上件の場合(): void
    {
        $user1 = [
            'name'     => 'テスト太郎',
            'email'    => 'test1@exmaple.com',
            'password' => 'password',
        ];
        $user2 = [
            'name'     => 'テスト次郎',
            'email'    => 'test2@exmaple.com',
            'password' => 'password',
        ];
        $userDao = new UserDao();
        $userDao->createUser($user1);
        $userDao->createUser($user2);
        $createdUser1 = DB::table('users')
                        ->select('id')
                        ->orderBy('id', 'DESC')
                        ->first();
        $createdUser2 = DB::table('users')
                        ->select('id')
                        ->orderBy('id')
                        ->first();
        $taskDao = new TaskDao();
        for ($i = 1; $i <= 10; $i++) {
            $task = ['name' => "タスク{$i}"];
            $taskDao->createTask($task, $createdUser1->id);
        }
        for ($i = 1; $i <= 2; $i++) {
            $task = ['name' => "タスク{$i}"];
            $taskDao->createTask($task, $createdUser2->id);
        }
        
        $tasks = $taskDao->getTasksByUserId($createdUser2->id);

        $this->assertSame(2, $tasks->count());
    }
}
