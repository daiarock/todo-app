<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Task::class, 5)->create();
        $task = new \App\Task();
        $task->name = "Test Task";
        $task->is_done = false;
        $task->save();
    }
}
