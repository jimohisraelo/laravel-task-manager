@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Task</h2>

    {{-- Show validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Task Title</label>
            <input type="text" 
                   name="title" 
                   class="form-control" 
                   value="{{ old('title', $task->title) }}" 
                   required>
        </div>

        <div class="form-group">
            <label for="description">Task Description</label>
            <textarea name="description" 
                      class="form-control">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Task</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
