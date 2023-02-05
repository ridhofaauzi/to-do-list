<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\TodolistService;
use Illuminate\Support\Facades\Session;


class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo("1", "Ridho");

        $todolist = Session::get("todolist");
        foreach ($todolist as $value) {
            self::assertEquals("1", $value['id']);
            self::assertEquals("Ridho", $value['todo']);
        }
    }

    public function testGetTodolistEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodolistNotEmpty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "Ridho"
            ],
        ];

        $this->todolistService->saveTodo("1", "Ridho");
        self::assertEquals($expected, $this->todolistService->getTodolist());
    }

    public function testRemoveTodo()
    {
        $this->todolistService->saveTodo("1", "Ridho");

        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("1");
        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
    }
}
