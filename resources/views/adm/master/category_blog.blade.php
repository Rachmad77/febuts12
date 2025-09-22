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
                <h3>Master</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kategori Blog</li>
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
                        Kategori Blog
                    </h5>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary block" data-bs-toggle="modal" id="add-show-form">
                            Tambah Data
                        </button>
                        <button type="button" class="btn btn-warning block" data-bs-toggle="modal" id="show-recycle-form">
                            <i class="bi bi-recycle"></i>
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
                                <h5 class="modal-title" id="modal_formTitle">Kategori Blog
                                </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name" class="form-label text-capitalize">Nama Kategori</label>
                                            <input type="text" class="form-control" name="name" id="name">
                                            <span class="text-danger" id="name_error"></span>
                                            <input type="hidden" id="id" name="id">
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

                <!-- modal recycle form -->
                <div class="modal fade" id="recycle-form" tabindex="-1" role="dialog" aria-labelledby="modal_formTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal_formTitle">Recycle Kategori Blog
                                </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table" id="recycle-blog-category">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center text-nowrap">No</th>
                                                <th scope="col" class="text-start text-nowrap">Nama kategori</th>
                                                <th scope="col" class="text-start text-nowrap">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($recycle as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm btn-restore" data-id="{{ $item->id }}">
                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm btn-force-delete" data-id="{{ $item->id }}">
                                                        <i class="bi bi-x-circle-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center">Tidak ada data</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table" id="blog-category">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap">No</th>
                                <th scope="col" class="text-start text-nowrap">Nama kategori</th>
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
            $('#name').val('');
            $('#id').val('');
            $('#name_error').text('');
            $('.btn-action').attr('id', '');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#blog-category').DataTable({
            processing: true,
            ordering: false,
            serverside: false,
            ajax: {
                url: "{{  route('master.blog-category.index') }}",
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
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-center',

                },
            ],
        });


        $('#add-show-form').click(function() {
            $('#modal-form').modal('show');
            $('.btn-action').attr('id', 'btn-save');

            $(document).on('click', '#btn-save', function(e) {
                e.preventDefault();
                console.log('sukses');
                var formData = new FormData();

                formData.append('name', $('#name').val());

                $.ajax({
                    url: "{{ route('master.blog-category.store') }}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#blog-category').DataTable().ajax.reload();
                            toastr.success(response.message, 'Success');

                            $('#modal-form').modal('hide');
                            resetForm();
                        } else {
                            toastr.error("Something went wrong", 'Error');
                        }
                    },
                    error: function(response) {
                        $('#name_error').text(res.responseJSON.errors.name);
                    }
                });
            });
        });

        $('#blog-category').on("click", "#btn-edit", function(e) {
            let id = $(this).data("id");

            $.ajax({
                url: '/master/blog-category/' + id,
                type: 'GET',
                success: function(response) {
                    $('.btn-action').attr('id', 'btn-update');
                    $('#modal-form').modal('show');
                    $('#name').val(response.data.name);
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

            $.ajax({
                url: '/master/blog-category/' + id,
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
                        $('#blog-category').DataTable().ajax.reload();

                        resetForm();
                    } else {
                        toastr.error(response.message, 'Terjadi Kesalahan');
                    }
                },
                error: function(response) {
                    $('#name_error').text(response.responseJSON.errors.name);
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
                        url: `/master/blog-category/${id}`,
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

        $('#show-recycle-form').click(function(e) {
            e.preventDefault();
            $('#recycle-form').modal('show');

            $(document).on('click', '.btn-restore', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: "Yakin ingin mengembalikan data ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Kembalikan!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/master/blog-category/restore/' + id,
                            type: 'PUT',
                            success: function(res) {
                                toastr.success(res.message);
                                location.reload();
                            },
                            error: function() {
                                toastr.error('Gagal mengembalikan data');
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.btn-force-delete', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: "Yakin ingin menghapus permanen data ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/master/blog-category/force-delete/' + id,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                toastr.success(res.message);
                                location.reload();
                            },
                            error: function() {
                                toastr.error('Gagal menghapus data');
                            }
                        });
                    }
                });
            });
        });
    });
</script>
@endsection