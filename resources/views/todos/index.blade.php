@extends('layouts.app')

@section('title', 'Todo List')

@section('content')
    <div class="flex-1 flex items-start justify-center px-4 py-16">
        <div class="w-full max-w-lg">
            <div class="fade-in text-center mb-8">
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Todo List</h1>
                <p class="text-slate-500 mt-1">Keep track of what needs to be done</p>
            </div>

            <div class="fade-in fade-in-delay-1 card-subtle rounded-2xl p-6 shadow-sm">
                <form action="{{ route('todos.store') }}" method="POST" class="flex gap-3 mb-6">
                    @csrf
                    <input
                        type="text"
                        name="title"
                        placeholder="Add a new todo..."
                        value="{{ old('title') }}"
                        class="flex-1 rounded-lg border border-slate-200 px-4 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-100 transition"
                        required
                    >
                    <button
                        type="submit"
                        class="bg-laravel text-white px-5 py-2.5 rounded-lg text-sm font-medium btn-lift hover:bg-laravel-dark"
                    >
                        Add
                    </button>
                </form>

                @error('title')
                    <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
                @enderror

                @if($todos->isEmpty())
                    <p class="text-center text-slate-400 py-8">No todos yet. Add one above!</p>
                @else
                    <ul class="space-y-2">
                        @foreach($todos as $todo)
                            <li class="flex items-center gap-3 rounded-lg px-3 py-2.5 hover:bg-slate-50 transition group">
                                <form action="{{ route('todos.toggle', $todo) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="flex items-center justify-center w-5 h-5 rounded border {{ $todo->is_completed ? 'bg-laravel border-red-400' : 'border-slate-300' }} transition">
                                        @if($todo->is_completed)
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @endif
                                    </button>
                                </form>

                                <span class="flex-1 text-sm {{ $todo->is_completed ? 'line-through text-slate-400' : 'text-slate-700' }}">
                                    {{ $todo->title }}
                                </span>

                                <form action="{{ route('todos.destroy', $todo) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="fade-in fade-in-delay-2 text-center mt-6">
                <a href="{{ route('home') }}" class="text-sm text-slate-400 hover:text-laravel transition">
                    &larr; Back to home
                </a>
            </div>
        </div>
    </div>
@endsection
