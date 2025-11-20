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
                        <li class="breadcrumb-item active" aria-current="page">Program Studi</li>
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
                        Program Studi
                    </h5>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary block" data-bs-toggle="modal" id="add-show-form">
                            Tambah Data
                        </button>
                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#recycleModal">
                            <i class="fas fa-recycle"></i>Recycle Bin
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
                                <h5 class="modal-title" id="modal_formTitle">Program Studi
                                </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="form-programstudi">
                                    <div class="row">
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="code" class="form-label">Kode</label>
                                                    <input type="text" class="form-control" name="code" id="code">
                                                    <span class="text-danger" id="code_error"></span>
                                                </div>
                                            </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label text-capitalize">Program Studi</label>
                                                <input type="text" class="form-control" name="name" id="name">
                                                <span class="text-danger" id="name_error"></span>
                                                <input type="hidden" id="id" name="id">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" id="email">
                                                <span class="text-danger" id="email_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="phone" class="form-label">Nomor Telepon</label>
                                                <input type="text" class="form-control" name="phone" id="phone">
                                                <span class="text-danger" id="phone_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1" checked>
                                                <label class="form-check-label" for="is_active">Aktif</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="button" class="btn btn-primary ms-1 btn-action" id="btn-save">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Simpan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table" id="programstudi">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap">No</th>
                                <th scope="col" class="text-center text-nowrap">Kode</th>
                                <th scope="col" class="text-start text-nowrap">Nama Program Studi</th>
                                <th scope="col" class="text-center text-nowrap">Email</th>
                                <th scope="col" class="text-center text-nowrap">Nomor Telepon</th>
                                <th scope="col" class="text-center text-nowrap">Status</th>
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

<!-- Modal Recycle -->
 <div class="modal fade" id="recycleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Recycle Bin Program Studi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-baby">
                <table class="table" id="recycleTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
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
            // reset form input
            $('#form-programstudi')[0].reset();

            // hapus error message kalau ada
            $('#name_error').text('');

            // pastikan tombol save aktif lagi
            $('#btn-save').prop('disabled', false);
            // $('#name').val('');
            // $('#id').val('');
            // $('#name_error').text('');
            // $('.btn-action').attr('id', '');
        }

        // reset form & error setiap kali modal ditutup
        $('#modal-form').on('hidden.bs.modal', function () {
            resetForm();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#programstudi').DataTable({
            processing: true,
            serverSide: true, // ✅ fix huruf S
            ordering: false,
            ajax: {
                url: "{{ route('master.programstudi.index') }}",
                type: 'GET',
            },
            responsive: true,
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center' },
                { data: 'code', name: 'code', className: 'text-center' },
                { data: 'name', name: 'name', className: 'text-start' },
                { data: 'email', name: 'email', className: 'text-center' },
                { data: 'phone', name: 'phone', className: 'text-center' },
                {
                    data: 'is_active',
                    name: 'is_active',
                    className: 'text-center',
                    render: function(data) {
                        return data == 1
                            ? '<span class="badge bg-success">Aktif</span>'
                            : '<span class="badge bg-danger">Tidak Aktif</span>';
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
        });

        $('#add-show-form').click(function() {
            resetForm();
            $('#modal-form').modal('show');
            $('#btn-save').prop('disabled', false);
            // $('#name').val('');
            // $('#name_error').text('');
            // $('#btn-save').prop('disabled', false);
            // $('.btn-action').attr('id', 'btn-save');
        });

        $(document).on('click', '#btn-save', function(e) {
                e.preventDefault();
                $(this).prop('disabled', true); //disable tombol dari klik berkali-kali
                console.log('sukses');
                var formData = new FormData();

                formData.append('name', $('#name').val());
                formData.append('code', $('#code').val());
                formData.append('email', $('#email').val());
                formData.append('phone', $('#phone').val());
                formData.append('is_active', $('#is_active').is(':checked') ? 1 : 0);


                $.ajax({
                    url: "{{ route('master.programstudi.store') }}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#programstudi').DataTable().ajax.reload();
                            toastr.success(response.message, 'Success');

                            resetForm();
                            $('#modal-form').modal('hide');
                            $('#btn-save').prop('disabled', false); // enable tombol lagi
                        } else {
                            toastr.error("Something went wrong", 'Error');
                            $('#btn-save').prop('disabled', false); // enable tombol lagi
                        }
                    },
                    error: function(response) {
                        console.log(response); // debug di console browser

                        if (response.status === 422) { // error validasi Laravel
                            let errors = response.responseJSON.errors;

                            if (errors.code) {
                                $('#code_error').text(errors.code[0]);
                                toastr.error(errors.code[0], 'Error');
                            }
                            if (errors && errors.name) {
                                $('#name_error').text(errors.name[0]);
                                toastr.error(errors.name[0], 'Error');
                            }
                            if (errors.email) {
                                $('#email_error').text(errors.email[0]);
                                toastr.error(errors.email[0], 'Error');
                            }
                            if (errors.phone) {
                                $('#phone_error').text(errors.phone[0]);
                                toastr.error(errors.phone[0], 'Error');
                            }
                        } else {
                            toastr.error(response.responseJSON.message ?? 'Terjadi kesalahan tidak diketahui', 'Error');
                        }
                        $('#btn-save').prop('disabled', false); // enable tombol lagi
                    }
                });
            });

        $('#programstudi').on("click", "#btn-edit", function(e) {
            let id = $(this).data("id");

            $.ajax({
                url: '/master/programstudi/' + id,
                type: 'GET',
                success: function(response) {
                    $('.btn-action').attr('id', 'btn-update');
                    $('#modal-form').modal('show');

                    // isi semua field dari response
                    $('#id').val(response.data.id);
                    $('#code').val(response.data.code);
                    $('#name').val(response.data.name);
                    $('#email').val(response.data.email);
                    $('#phone').val(response.data.phone);
                    $('#is_active').prop('checked', response.data.is_active == 1);
                },

                error: function(response) {
                    if (response.status === 422) {
                        let errors = response.responseJSON.errors;
                        if (errors.code) {
                                $('#code_error').text(errors.code[0]);
                                toastr.error(errors.code[0], 'Error');
                            }
                            if (errors && errors.name) {
                                $('#name_error').text(errors.name[0]);
                                toastr.error(errors.name[0], 'Error');
                            }
                            if (errors.email) {
                                $('#email_error').text(errors.email[0]);
                                toastr.error(errors.email[0], 'Error');
                            }
                            if (errors.phone) {
                                $('#phone_error').text(errors.phone[0]);
                                toastr.error(errors.phone[0], 'Error');
                            }
                        } else {
                            toastr.error(response.responseJSON.message ?? 'Terjadi kesalahan tidak diketahui', 'Error');
                        }
                }
            })
        });

        $('body').on('click', '#btn-update', function(e) {
            e.preventDefault(); // ⬅️ ini penting biar tombol/enter gak reload form

            var id = $('#id').val();
            var formData = new FormData();

            formData.append('_method', 'PUT');
            formData.append('name', $('#name').val());
            formData.append('code', $('#code').val());
            formData.append('email', $('#email').val());
            formData.append('phone', $('#phone').val());
            formData.append('is_active', $('#is_active').is(':checked') ? 1 : 0);

            $.ajax({
                url: '/master/programstudi/' + id,
                type: 'POST', // tetap POST karena _method:PUT
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
                        $('#programstudi').DataTable().ajax.reload();

                        resetForm();
                    } else {
                        toastr.error(response.message, 'Terjadi Kesalahan');
                    }
                },
                error: function(response) {
                    if (response.status === 422) {
                        let errors = response.responseJSON.errors;
                        if (errors.name) {
                            $('#name_error').text(errors.name[0]);
                            toastr.error(errors.name[0], 'Error');
                        }
                        if (errors.code) {
                            $('#code_error').text(errors.code[0]);
                            toastr.error(errors.code[0], 'Error');
                        }
                        if (errors.email) {
                            $('#email_error').text(errors.email[0]);
                            toastr.error(errors.email[0], 'Error');
                        }
                        if (errors.phone) {
                            $('#phone_error').text(errors.phone[0]);
                            toastr.error(errors.phone[0], 'Error');
                        }
                    } else {
                        toastr.error(response.responseJSON.message ?? 'Terjadi kesalahan tidak diketahui', 'Error');
                    }
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
                        url: `/master/programstudi/${id}`,
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

        $('#form-programstudi').on('keydown', function(e) {
            if (e.key === "Enter") {
                e.preventDefault(); // cegah reload page

                if ($('#btn-update').length && $('#btn-update').is(':visible')) {
                    $('#btn-update').click(); // kalau lagi edit
                } else {
                    $('#btn-save').click();   // kalau lagi tambah
                }
            }
        });
    });

    $('$recycleTable').DataTable({
        processing: true,
        serverRide: true,
        ajax: "{{ route('master.programstudi.trash}}"
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center' },
            { data: 'code', name: 'code', className: 'text-center' },
            { data: 'name', name: 'name', className: 'text-start' },
            { data: 'email', name: 'email', className: 'text-center' },
            { data: 'phone', name: 'phone', className: 'text-center' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ], 
    });

    $(document).on('click', '.btn-restore', function(){
        let id = $(this).data("id");

        $.ajax({
            url: "/master/programstudi/restore/" + id,
            type: "POST",
            data: {_token: "{{ csrf_token()}}"},
            success: function(response){
                toastr.success(response.message);
                $('#recycleTable').DataTable().ajax.reload();
                $('#programstudi').DataTable().ajax.reload();
            }
        });
    });

    $(document).on('click', '.btn-force-delete', function(){
        let id = $(this).add("id");

        $.ajax({
            url: "/master/programstudi/force-delete/" + id,
            type: "DELETE",
            data: {_token: "{{ csrf_token()}}"},
            success: function(response){
                toastr.success(response.message);
                $('#recycleTable').DataTable().ajax.reload();
            }
        })
    })
</script>
@endsection