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
                        <li class="breadcrumb-item active" aria-current="page">DataTable jQuery</li>
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
                        Data Permission
                    </h5>
                    <button type="button" class="btn btn-primary block" data-bs-toggle="modal" id="show_modal_create">
                        Tambah Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- modal create product sale -->
                <div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="modal_formTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal_formTitle">Data Permission
                                </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name" class="form-label text-capitalize">Nama Role</label>
                                            <input type="text" class="form-control" name="name" id="name">
                                            <span class="text-danger" id="name_error"></span>
                                            <input type="hidden" id="id" name="id">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="guard_name" class="form-label text-capitalize">Guard name</label>
                                            <input type="text" class="form-control" name="guard_name" id="guard_name" value="web" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="button" class="btn btn-primary ms-1 btnSaveForm" id="">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Simpan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="permission">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap">No</th>
                                <th scope="col" class="text-start text-nowrap">Role</th>
                                <th scope="col" class="text-center text-nowrap">Guard Name</th>
                                <th scope="col" class="text-center text-nowrap">Aksi</th>
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#permission').DataTable({
            processing: true,
            ordering: false,
            serverside: false,
            ajax: {
                url: "{{ route('users.permission.index') }}",
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
                    className: 'text-nowrap',
                },
                {
                    data: 'guard_name',
                    name: 'guard_name',
                    className: 'text-center'
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-center text-nowrap',
                }
            ]
        });

        $('#show_modal_create').click(function(e) {
            e.preventDefault();
            $('#modal_form').modal('show');
            $('.btnSaveForm').attr('id', 'btnSave');

            $(document).on('click', '#btnSave', function(e) {
                e.preventDefault();
                var formData = new FormData();

                formData.append('name', $('#name').val());
                formData.append('guard_name', $('#guard_name').val());

                $.ajax({
                    url: "{{ route('users.permission.store') }}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.success) {
                            $('#permission').DataTable().ajax.reload();
                            toastr.success(res.message, 'Success');

                            $('#modal_form').modal('hide');
                            $('.btnSaveForm').attr('id', '');
                        } else {
                            toastr.error("Something went wrong", 'Error');
                        }
                    },
                    error: function(res) {
                        $('#name_error').text(res.responseJSON.errors.name);
                    }
                });
            });
        });

        $(document).on('click', '#btnEdit', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            console.log(id);
            $.ajax({
                url: '/users/permission/edit/' + id,
                type: 'GET',
                success: function(res) {
                    $('#modal_form').modal('show');
                    $('.btnSaveForm').attr('id', 'btnUpdate');

                    $('#id').val(res.data.id);
                    $('#name').val(res.data.name);
                    $('#guard_name').val(res.data.guard_name);
                },
                error: function(err) {
                    toastr.error(err.responseJSON.message, 'Terjadi Kesalahan');
                }
            });
        });

        $('body').on('click', '#btnUpdate', function(e) {
            var id = $('#id').val();
            var formData = new FormData();

            formData.append('_method', 'PUT');
            formData.append('name', $('#name').val());
            formData.append('guard_name', $('#guard_name').val());

            $.ajax({
                url: '/users/permission/update/' + id,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('#modal_form').modal('hide');

                    if (res.success) {
                        toastr.success(res.message, 'Success');
                        $('#permission').DataTable().ajax.reload();

                        $('.btnSaveForm').attr('id', '');
                    } else {
                        toastr.error(res.message, 'Terjadi Kesalahan');
                    }
                },
                error: function(res) {
                    $('#name_error').text(res.responseJSON.errors.name);
                }
            });
        });

        $(document).on('click', '#btnDelete', function(e) {
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
                        url: `/users/permission/delete/${id}`,
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

        $('#modal_form').on('hidden.bs.modal', function() {
            $('#name').val('');
            $('#guard_name').val('web');
        });
    })
</script>
@endsection
