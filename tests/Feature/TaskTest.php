<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskTest extends TestCase
{

    use DatabaseMigrations;
    use DatabaseTransactions;

    protected function setUp()
    {
        // テストデータ登録
        parent::setUp();
        (new \DatabaseSeeder())->run();
    }

    public function testIndex()
    {
        $response = $this->json('GET', '/api/tasks');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json());
    }

    public function testStore()
    {
        $data = ['name' => 'New Task'];
        $response = $this->json('POST', '/api/tasks', $data);

        $response->assertStatus(201);
        $response->assertJson($data);
        $task = Task::query()->find(2);
        $this->assertSame('New Task', $task->name);
    }

    public function testUpdateName()
    {
        $data = ['name' => 'Update Task'];
        $response = $this->json('PUT', '/api/tasks/1', $data);

        $response->assertStatus(200);
        $response->assertJson($data);
        $task = Task::query()->find(1);
        $this->assertSame('Update Task', $task->name);
    }

    public function testUpdateIsDone()
    {
        $data = ['is_done' => true];
        $response = $this->json('PUT', '/api/tasks/1', $data);

        $response->assertStatus(200);
        $response->assertJson($data);
        $task = Task::query()->find(1);
        $this->assertSame(true, $task->is_done);
    }

    public function testDelete()
    {
        $response = $this->delete('/api/tasks/1');
 
        $response->assertStatus(200);
        $this->assertNull(Task::query()->find(1));
    }
    
}