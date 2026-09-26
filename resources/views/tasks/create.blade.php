@extends('layouts.app')

@section('content')

<div class="form-card">

    <h2>Add New Task</h2>

    <form action="{{ route('tasks.store') }}" method="POST">

        @csrf

        <div class="form-group">
            <label>Task Name</label>

            <input
                type="text"
                name="task_name"
                class="form-control"
                value="{{ old('task_name') }}"
                placeholder="Enter task name"
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
                placeholder="Enter task description"
            >{{ old('description') }}</textarea>

            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Status</label>

            <select name="status" class="form-control">

                <option value="Pending">
                    Pending
                </option>

                <option value="Completed">
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
                value="{{ old('due_date') }}"
            >

            @error('due_date')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Add Task
        </button>

        <a href="{{ route('tasks.index') }}" class="btn btn-edit">
            Cancel
        </a>

    </form>

</div>

@endsection