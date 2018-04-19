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

        $user = new \App\User();
        $user->name = "Test User";
        $user->email = "test@test.com";
        $user->password = bcrypt('test');
        $user->remember_token  = str_random(10);
        $user->save();

        $user->tasks()->save(
            factory(App\Task::class)->make()
        );
    }
}
