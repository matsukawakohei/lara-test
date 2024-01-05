<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function createTask(array $task, int $userId): Task
    {
        return $this->create([
            'name'    => $task['name'],
            'user_id' => $userId,
        ]);
    }

    public function getTasksByUserId(int $userId): Collection
    {
        return $this->where('user_id', $userId)->get();
    }
}
