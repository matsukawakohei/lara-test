<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function ユーザー作成テスト(): void
    {
        $user = [
            'name'     => 'テスト太郎',
            'email'    => 'test1@exmaple.com',
            'password' => 'password',
        ];

        $userModel = new User();
        $userModel->createUser($user);

        $this->assertDatabaseHas(
            'users',
            [
                'name'  => $user['name'],
                'email' => $user['email'],
            ]
        );
    }

    /** @test */
    public function ユーザー取得テスト_idが存在する場合(): void
    {
        User::factory(10)->create();
        $user = User::factory()->create();

        $userModel = new User();
        $findUser  = $userModel->getUserById($user->id);

        $this->assertSame($user->id,    $findUser->id);
        $this->assertSame($user->name,  $findUser->name);
        $this->assertSame($user->email, $findUser->email);
    }

    /** @test */
    public function ユーザー取得テスト_idが存在しない場合(): void
    {
        User::factory(10)->create();

        $userModel = new User();
        $findUser  = $userModel->getUserById(-9999999);

        $this->assertNull($findUser);
    }
}
