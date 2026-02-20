<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Models\Todo;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TodoController extends Controller
{
    public function index(): View
    {
        $todos = Todo::query()->latest()->get();

        return view('todos.index', [
            'todos' => $todos,
        ]);
    }

    public function store(StoreTodoRequest $request): RedirectResponse
    {
        Todo::query()->create($request->validated());

        return redirect()->route('todos.index');
    }

    public function toggle(Todo $todo): RedirectResponse
    {
        $todo->update(['is_completed' => ! $todo->is_completed]);

        return redirect()->route('todos.index');
    }

    public function destroy(Todo $todo): RedirectResponse
    {
        $todo->delete();

        return redirect()->route('todos.index');
    }
}
