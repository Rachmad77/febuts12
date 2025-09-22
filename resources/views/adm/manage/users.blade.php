@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Users</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title">
                        Data Users
                    </h5>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary block" data-bs-toggle="modal" id="add-show-form">
                            Tambah Data
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- modal create -->
                <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal_formTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal_formTitle">Buat User
                                </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name" class="form-label text-capitalize">Nama</label>
                                            <input type="text" class="form-control" name="name" id="name">
                                            <span class="text-danger" id="name_error"></span>
                                            <input type="hidden" id="id" name="id">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email" class="form-label text-capitalize">Email</label>
                                            <input type="email" class="form-control" name="email" id="email">
                                            <span class="text-danger error-message" id="email_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="roles" class="form-label text-capitalize">Roles</label>
                                            <select class="form-control" name="roles" id="roles">
                                                <option value="">Silahkan Pilih..</option>
                                                @foreach ($roles as $item )
                                                <option class="text-capitalize" value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-message" id="roles_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="password" class="form-tabel text-capitalize">Password</label>
                                            <input type="password" class="form-control" name="password" id="password">
                                            <span class="text-danger error-message" id="password_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="form-label text-capitalize">Konfirmasi Password</label>
                                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                                            <span class="text-danger error-message" id="password_confirmation_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="button" class="btn btn-primary ms-1 btn-action" id="">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Simpan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table" id="users-table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap">No</th>
                                <th scope="col" class="text-start text-nowrap">Nama</th>
                                <th scope="col" class="text-start text-nowrap">Email</th>
                                <th scope="col" class="text-start text-nowrap">Roles</th>
                                <th scope="col" class="text-start text-nowrap">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic Tables end -->

</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 4000);

        function resetForm() {
            $('#id').val('');
            $('#name').val('');
            $('#email').val('');
            $('#roles').val('');
            $('#password').val('');
            $('#password_confirmation').val('');

            $('#name_error').text('');
            $('#email_error').text('');
            $('#password_error').text('');
            $('#password_confirmation_error').text('');
            $('#roles_error').text('');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#users-table').DataTable({
            processing: true,
            ordering: false,
            serverside: false,
            ajax: {
                url: "{{  route('users.index') }}",
                type: 'GET',
            },
            responsive: true,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                },
                {
                    data: 'name',
                    name: 'name',
                    className: 'text-capitalize',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'roles',
                    name: 'roles',
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-center',

                },
            ],
        });


        $('#add-show-form').click(function() {
            resetForm();
            $('#modal-form').modal('show');
            $('.btn-action').attr('id', 'btn-save');

            $(document).on('click', '#btn-save', function(e) {
                e.preventDefault();

                var formData = new FormData();
                formData.append('name', $('#name').val());
                formData.append('email', $('#email').val());
                formData.append('password', $('#password').val());
                formData.append('password_confirmation', $('#password_confirmation').val());
                formData.append('roles', $('#roles').val());

                $.ajax({
                    url: "{{ route('users.store') }}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#users-table').DataTable().ajax.reload();
                            toastr.success(response.message, 'Success');

                            $('#modal-form').modal('hide');
                            resetForm();
                        } else {
                            toastr.error("Something went wrong", 'Error');
                        }
                    },
                    error: function(response) {
                        var res = response.responseJSON;
                        $('#name_error').text(res?.errors?.name ?? '');
                        $('#email_error').text(res?.errors?.email ?? '');
                        $('#password_error').text(res?.errors?.password ?? '');
                        $('#password_confirmation_error').text(res?.errors?.password_confirmation ?? '');
                        $('#roles_error').text(res?.errors?.roles ?? '');
                    }
                });
            });
        });

        $('#users-table').on("click", "#btn-edit", function(e) {
            let id = $(this).data("id");

            $.ajax({
                url: '/users/' + id + '/edit',
                type: 'GET',
                success: function(response) {
                    $('.btn-action').attr('id', 'btn-update');
                    $('#modal-form').modal('show');
                    $('#name').val(response.data.name);
                    $('#email').val(response.data.email);
                    if (response.data.roles.length > 0) {
                        $('#roles').val(response.data.roles[0].name);
                    }


                    $('#id').val(response.data.id);
                },
                error: function(response) {
                    toastr.error(response.responseJSON.message, 'Terjadi Kesalahan');
                }
            })
        });

        $('body').on('click', '#btn-update', function(e) {
            var id = $('#id').val();
            var formData = new FormData();

            formData.append('_method', 'PUT');
            formData.append('name', $('#name').val());
            formData.append('email', $('#email').val());
            formData.append('roles', $('#roles').val());
            formData.append('password', $('#password').val());
            formData.append('password_confirmation', $('#password_confirmation').val());

            $.ajax({
                url: '/users/' + id,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#modal-form').modal('hide');

                    if (response.success) {
                        toastr.success(response.message, 'Success');
                        $('#users-table').DataTable().ajax.reload();

                        resetForm();
                    } else {
                        toastr.error(response.message, 'Terjadi Kesalahan');
                    }
                },
                error: function(response) {
                    var res = response.responseJSON;
                    $('#name_error').text(res?.errors?.name ?? '');
                    $('#email_error').text(res?.errors?.email ?? '');
                    $('#password_error').text(res?.errors?.password ?? '');
                    $('#password_confirmation_error').text(res?.errors?.password_confirmation ?? '');
                    $('#roles_error').text(res?.errors?.roles ?? '');
                }
            });
        });

        $(document).on('click', '#btn-delete', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let token = $('meta[name="csrf-token"]').attr('content');

            swal.fire({
                title: 'Are you sure?',
                text: "Anda akan menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#015488',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/users/${id}`,
                        type: 'DELETE',
                        data: {
                            "_token": token
                        },
                        success: function(response) {
                            toastr.success('success', response.message);
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        },
                        error: function(err) {
                            toastr.error('Error', 'Something went wrong');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
