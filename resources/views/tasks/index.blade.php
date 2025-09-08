@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h2 class="mb-2">Task List</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-2">+ Add Task</a>
    </div>

    {{-- Search bar --}}
    <form action="{{ route('tasks.index') }}" method="GET" class="mb-3 row">
        <div class="col-12 col-md-9 mb-2 mb-md-0">
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="form-control rounded" placeholder="Search by title or status...">
        </div>
        <div class="col-12 col-md-3">
            <button class="btn btn-outline-secondary btn-block rounded" type="submit">Search</button>
        </div>
    </form>

    @if($tasks->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped rounded" id="taskTable">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="sortable">
                @foreach($tasks as $task)
                <tr data-id="{{ $task->id }}" @if($task->status == 'Completed') class="table-success" @endif>
                    <td class="row-number">{{ $loop->iteration }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description ?? '-' }}</td>
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
                    <td>{{ $task->updated_at->format('d M Y, H:i') }}</td>
                    <td>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm rounded mb-1 mb-md-0">Edit</a>
                        <button class="btn btn-danger btn-sm rounded mb-1 mb-md-0" data-toggle="modal" data-target="#deleteModal{{ $task->id }}">
                            Delete
                        </button>
                    </td>
                </tr>

                {{-- Delete Confirmation Modal --}}
                <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1" role="dialog"
                     aria-labelledby="deleteModalLabel{{ $task->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content rounded">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $task->id }}">Confirm Delete</h5>
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
                                    <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger rounded">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $tasks->links('pagination::bootstrap-4') }}
    </div>
    @else
    <div class="alert alert-info rounded">
        No tasks found. <a href="{{ route('tasks.create') }}">Create one now</a>.
    </div>
    @endif
</div>
@endsection

{{-- Scripts --}}
@section('scripts')
    {{-- jQuery & jQuery UI (sortable) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script>
        $(function () {
            $("#sortable").sortable({
                helper: function(e, tr) {
                    var $originals = tr.children();
                    var $helper = tr.clone();
                    $helper.children().each(function(index) {
                        $(this).width($originals.eq(index).width());
                    });
                    return $helper;
                },
                update: function () {
                    let order = [];
                    $('#sortable tr').each(function (index) {
                        $(this).find('.row-number').text(index + 1);
                        order.push({
                            id: $(this).attr('data-id'),
                            position: index + 1
                        });
                    });

                    $.ajax({
                        type: "POST",
                        url: "{{ route('tasks.reorder') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            order: order
                        },
                        success: function (response) {
                            console.log("Order saved:", response.message);
                        },
                        error: function (xhr) {
                            console.error("Error saving order:", xhr.responseText);
                        }
                    });
                }
            }).disableSelection();
        });
    </script>

    <style>
        #sortable tr {
            cursor: move;
        }
        @media (max-width: 576px) {
            td .btn {
                width: 100%;
            }
        }
    </style>
@endsection
