@extends('layouts.app')

@section('content')

<div class="welcome">
    <h1>Welcome back!</h1>
    <p>Manage your tasks and keep track of your progress.</p>
</div>

<div class="stats">

    <div class="stat-card">
        <h3>TOTAL TASKS</h3>
        <div class="stat-number">
            {{ $totalTasks }}
        </div>
    </div>

    <div class="stat-card">
        <h3>PENDING</h3>
        <div class="stat-number">
            {{ $pendingTasks }}
        </div>
    </div>

    <div class="stat-card">
        <h3>COMPLETED</h3>
        <div class="stat-number">
            {{ $completedTasks }}
        </div>
    </div>

</div>

<div class="tasks-header">
    <h2>My Tasks</h2>

    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
        + Add Task
    </a>
</div>

<div class="task-list">

    @forelse($tasks as $task)

        <div class="task">

            <div class="task-info">

                <h3>{{ $task->task_name }}</h3>

                <p>
                    {{ $task->description ?: 'No description provided.' }}
                </p>

                <span class="status {{ $task->status === 'Completed' ? 'completed' : 'pending' }}">
                    {{ $task->status }}
                </span>

                @if($task->due_date)
                    <div class="due-date">
                        Due: {{ \Carbon\Carbon::parse($task->due_date)->format('F d, Y') }}
                    </div>
                @endif

            </div>

            <div class="task-actions">

                <a href="{{ route('tasks.edit', $task) }}"
                   class="btn btn-edit">
                    Edit
                </a>

                <form action="{{ route('tasks.destroy', $task) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this task?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-delete">
                        Delete
                    </button>

                </form>

            </div>

        </div>

    @empty

        <div class="empty">
            <h3>No tasks yet.</h3>
            <p>Create your first task to get started.</p>
        </div>

    @endforelse

</div>

@endsection