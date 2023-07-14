<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder
{
public function run()
{
TaskStatus::create(['name' => 'Новый']);
TaskStatus::create(['name' => 'В работе']);
TaskStatus::create(['name' => 'На тестировании']);
TaskStatus::create(['name' => 'Завершен']);
}
}
