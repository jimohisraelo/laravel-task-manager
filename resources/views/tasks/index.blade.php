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
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $task->title }}</td>
                        <td>
                            <span class="badge 
                                @if($task->status == 'pending') badge-warning 
                                @elseif($task->status == 'completed') badge-success 
                                @else badge-secondary 
                                @endif">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>
                        <td>{{ $task->created_at->format('d M Y, H:i') }}</td>
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
