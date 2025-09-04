@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Task List</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ Add Task</a>
    </div>

    @if($tasks->count() > 0)
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr @if($task->status == 'Completed') class="table-success" @endif>
                <td>{{ $loop->iteration }}</td>
                <td>
                    {{ $task->title }}
                </td>
                <td>
                    <form action="{{ route('tasks.toggle', $task->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="toggle{{ $task->id }}"
                                onchange="this.form.submit()" {{ $task->status == 'Completed' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="toggle{{ $task->id }}">
                                {{ $task->status }}
                            </label>
                        </div>
                    </form>
                </td>

                <td>{{ $task->created_at->format('d M Y, H:i') }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $task->id }}">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="alert alert-info">
        No tasks found. <a href="{{ route('tasks.create') }}">Create one now</a>.
    </div>
    @endif
</div>
@endsection