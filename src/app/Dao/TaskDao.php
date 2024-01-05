<?php

namespace App\Dao;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TaskDao
{
    const TABLE_NAME = 'tasks';

    public function createTask(array $task, int $userId): bool
    {
        return DB::table(self::TABLE_NAME)
                ->insert([
                    'name'    => $task['name'],
                    'user_id' => $userId,
                ]);
    }

    public function getTasksByUserId(int $userId): Collection
    {
        return DB::table(self::TABLE_NAME)
                ->where('user_id', $userId)
                ->get();
    }

}