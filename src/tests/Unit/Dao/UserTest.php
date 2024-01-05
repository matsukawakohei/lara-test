<?php

namespace Tests\Unit\Dao;

use App\Dao\UserDao;
use Illuminate\Support\Facades\DB;
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

        $userDao = new UserDao();
        $userDao->createUser($user);

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
        $userDao = new UserDao();

        for ($i = 1; $i <= 11; $i++) {
            $userDao->createUser([
                'name'     => "テスト{$i}",
                'email'    => "test{$i}@exmaple.com",
                'password' => 'password'
            ]);
        }

        $lastUser = DB::table('users')
                ->select('id', 'name', 'email')
                ->orderBy('id', 'DESC')
                ->first();
        
        $findUser = $userDao->getUserById($lastUser->id);

        $this->assertSame($lastUser->id,    $findUser->id);
        $this->assertSame($lastUser->name,  $findUser->name);
        $this->assertSame($lastUser->email, $findUser->email);
    }

    /** @test */
    public function ユーザー取得テスト_idが存在しない場合(): void
    {
        $userDao = new UserDao();

        for ($i = 1; $i <= 11; $i++) {
            $userDao->createUser([
                'name'     => "テスト{$i}",
                'email'    => "test{$i}@exmaple.com",
                'password' => 'password'
            ]);
        }

        $lastUser = DB::table('users')
                ->select('id', 'name', 'email')
                ->orderBy('id', 'DESC')
                ->first();
        
        $findUser = $userDao->getUserById($lastUser->id + 1);

        $this->assertNull($findUser);
    }
}
