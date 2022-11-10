@extends('layouts.front')
@section('main')
    <div class="container">
        <div class="d-flex py-3">
            <div class="p-2 w-100">
                <h2>Laravel AJAX</h2>
            </div>
            <div class="p-2 flex-shrink-0">
                <button class="btn btn-primary todo-modal" data-bs-toggle="modal" data-bs-target="#formModal">
                    Add Todo
                </button>
            </div>
        </div>
        <div>
            <div class="container">
                <div class="formSuccess"></div>
            </div>
            <table class="table table-inverse">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="todo-list" name="todos-list">
                    {{-- @forelse ($todos as $data)
                        <tr id="todo{{ $data->id }}">
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->title }}</td>
                            <td>{{ $data->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center fs-4">No data found</td>
                        </tr>
                    @endforelse --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- Form Modal --}}
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <!-- ========= Start - Add Todo Modal ======== -->
    <div class="modal fade" id="formModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Add New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="formErrors"></ul>
                    {{-- Form Start --}}
                    <form id="todoForm">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter Title">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" name="description" id="description" class="form-control"
                                placeholder="Enter description">
                        </div>
                    </form>
                    {{-- Form End --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit-form" form="todoForm">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ========= End - Add Todo Modal ======== -->

    <!-- ========= Start - Edit Todo Modal ======== -->
    <div class="modal fade" id="editTodoModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="editFormErrors"></ul>
                    {{-- Form Start --}}
                    <form id="editTodoForm">
                        <input type="hidden" name="editTodoId" id="editTodoId">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="editTitle" class="form-control"
                                placeholder="Enter Title">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" name="description" id="editDescription" class="form-control"
                                placeholder="Enter description">
                        </div>
                    </form>
                    {{-- Form End --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary edit-submit-form" form="editTodoForm">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ========= End - Edit Todo Modal ======== -->
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Fetching the todos data
            fetchTodo();

            function fetchTodo() {
                $.ajax({
                    type: "GET",
                    url: "fetch-todos",
                    dataType: "json",
                    success: function(response) {
                        $('#todo-list').html('');
                        $.each(response.todos, function(key, item) {
                            $('#todo-list').append('<tr>\
                            <td>' + item.id + '</td>\
                            <td>' + item.title + '</td>\
                            <td>' + item.description + '</td>\
                            <td>\
                                <button value="' + item.id + '" class="edit-todo btn btn-primary btn-sm">Edit</button>\
                                <button value="' + item.id + '" class="delete-todo btn btn-danger btn-sm">Delete</button>\
                            </td>\
                            </tr>');
                        });
                    }
                });
            }

            $(document).on('click', '.submit-form', function(e) {
                e.preventDefault();
                var data = {
                    'title': $('#title').val(),
                    'description': $('#description').val(),
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "todo",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $('.formErrors').html('');
                            $('.formErrors').addClass('alert alert-danger');
                            $.each(response.errors, function(key, val) {
                                $('.formErrors').append('<li>' + val + '</li>');
                            });
                        } else {
                            $('.formErrors').html('');
                            $('.formSuccess').addClass('alert alert-success');
                            $('.formSuccess').text(response.message);
                            $('#formModal').modal('hide');
                            $('#formModal').find('input').val('');
                            $('.formErrors').removeClass('alert alert-danger');
                            fetchTodo();
                        }
                    }
                });
            });

            $(document).on('click', '.edit-todo', function(e) {
                e.preventDefault();
                let todoId = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "todo/edit/" + todoId,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 404) {
                            $('.formSuccess').html('');
                            $('.formSuccess').addClass('alert alert-danger');
                            $('.formSuccess').append('<li>' + response.message + '</li>');
                        } else {
                            $('#editTodoModal').modal('show');
                            $('#editTitle').val(response.todo.title);
                            $('#editDescription').val(response.todo.description);
                            $('#editTodoId').val(response.todo.id);
                        }
                    }
                });

                $(document).on('click', '.submit-form', function(e) {
                    e.preventDefault();
                    var data = {
                        'title': $('#title').val(),
                        'description': $('#description').val(),
                    };

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "todo",
                        data: data,
                        dataType: "json",
                        success: function(response) {
                            if (response.status == 400) {
                                $('.formErrors').html('');
                                $('.formErrors').addClass('alert alert-danger');
                                $.each(response.errors, function(key, val) {
                                    $('.formErrors').append('<li>' + val +
                                        '</li>');
                                });
                            } else {
                                $('.formErrors').html('');
                                $('.formSuccess').addClass('alert alert-success');
                                $('.formSuccess').text(response.message);
                                $('#formModal').modal('hide');
                                $('#formModal').find('input').val('');
                                $('.formErrors').removeClass('alert alert-danger');
                                fetchTodo();
                            }
                        }
                    });
                });
            });

            $(document).on('click', '.edit-submit-form', function(e) {
                e.preventDefault();
                let data = {
                    'title': $('#editTitle').val(),
                    'description': $('#editDescription').val(),
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "todo/update/"+$('#editTodoId').val(),
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $('.editFormErrors').html('');
                            $('.editFormErrors').addClass('alert alert-danger');
                            $.each(response.errors, function(key, val) {
                                $('.editFormErrors').append('<li>' + val + '</li>');
                            });
                        } else {
                            $('.editFormErrors').html('');
                            $('.formSuccess').addClass('alert alert-success');
                            $('.formSuccess').text(response.message);
                            $('#editTodoModal').modal('hide');
                            $('#editTodoModal').find('input').val('');
                            $('.editFormErrors').removeClass('alert alert-danger');
                            fetchTodo();
                        }
                    }
                });
            });


        });
    </script>
@endpush
