@extends('layouts.app')

@section('content')

<div class="form-card">

    <h2>Edit Task</h2>

    <form action="{{ route('tasks.update', $task) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Task Name</label>

            <input
                type="text"
                name="task_name"
                class="form-control"
                value="{{ old('task_name', $task->task_name) }}"
            >

            @error('task_name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Description</label>

            <textarea
                name="description"
                class="form-control"
            >{{ old('description', $task->description) }}</textarea>

            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Status</label>

            <select name="status" class="form-control">

                <option value="Pending"
                    {{ $task->status === 'Pending' ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="Completed"
                    {{ $task->status === 'Completed' ? 'selected' : '' }}>
                    Completed
                </option>

            </select>

            @error('status')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Due Date</label>

            <input
                type="date"
                name="due_date"
                class="form-control"
                value="{{ old('due_date', $task->due_date) }}"
            >

            @error('due_date')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Update Task
        </button>

        <a href="{{ route('tasks.index') }}" class="btn btn-edit">
            Cancel
        </a>

    </form>

</div>

@endsection