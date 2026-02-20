<?php

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('todo index page displays successfully', function () {
    $this->get(route('todos.index'))->assertOk();
});

test('todo index page shows todos', function () {
    $todo = Todo::factory()->create(['title' => 'Buy groceries']);

    $this->get(route('todos.index'))
        ->assertOk()
        ->assertSee('Buy groceries');
});

test('a todo can be created', function () {
    $this->post(route('todos.store'), ['title' => 'Write tests'])
        ->assertRedirect(route('todos.index'));

    $this->assertDatabaseHas('todos', [
        'title' => 'Write tests',
        'is_completed' => false,
    ]);
});

test('a todo requires a title', function () {
    $this->post(route('todos.store'), ['title' => ''])
        ->assertSessionHasErrors('title');
});

test('a todo can be toggled', function () {
    $todo = Todo::factory()->create(['is_completed' => false]);

    $this->patch(route('todos.toggle', $todo))
        ->assertRedirect(route('todos.index'));

    expect($todo->fresh()->is_completed)->toBeTrue();
});

test('a completed todo can be toggled back', function () {
    $todo = Todo::factory()->completed()->create();

    $this->patch(route('todos.toggle', $todo))
        ->assertRedirect(route('todos.index'));

    expect($todo->fresh()->is_completed)->toBeFalse();
});

test('a todo can be deleted', function () {
    $todo = Todo::factory()->create();

    $this->delete(route('todos.destroy', $todo))
        ->assertRedirect(route('todos.index'));

    $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
});
