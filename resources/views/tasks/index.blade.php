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
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $task->title }}</td>
                        <td>
                            <span class="badge 
                                @if($task->status == 'Pending') badge-warning 
                                @elseif($task->status == 'Completed') badge-success 
                                @else badge-secondary 
                                @endif">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>
                        <td>{{ $task->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $task->id }}">
                                Delete
                            </button>
                    
                            <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $task->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirm Delete</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete <strong>{{ $task->title }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
