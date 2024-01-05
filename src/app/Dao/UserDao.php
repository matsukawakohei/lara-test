<?php

namespace App\Dao;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use stdClass;

class UserDao
{
    const TABLE_NAME = 'users';

    public function createUser(array $user): bool
    {
        return DB::table(self::TABLE_NAME)
                ->insert([
                    'name'     => $user['name'],
                    'email'    => $user['email'],
                    'password' => Hash::make($user['password']),
                ]);
    }

    public function getUserById(int $id): ?stdClass
    {
        return DB::table(self::TABLE_NAME)
                ->where('id', $id)
                ->first();
    }
}