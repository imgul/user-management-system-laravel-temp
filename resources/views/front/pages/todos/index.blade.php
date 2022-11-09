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
                    </tr>
                </thead>
                <tbody id="todos-list" name="todos-list">
                    @forelse ($todos as $data)
                        <tr id="todo{{ $data->id }}">
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->title }}</td>
                            <td>{{ $data->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center fs-4">No data found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Form Modal --}}
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
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
                            <input type="text" name="title" id="title" class="form-control title"
                                placeholder="Enter Title">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" name="description" id="description" class="form-control description"
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
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.submit-form', function(e) {
                e.preventDefault();
                var data = {
                    'title': $('.title').val(),
                    'description': $('.description').val(),
                };
                console.log(data);

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
                        console.log(response);
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
                        }
                    }
                });
            });
        });
    </script>
@endpush
