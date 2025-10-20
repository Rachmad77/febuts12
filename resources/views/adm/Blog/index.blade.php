@extends('layouts.app')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Blog</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Daftar Blog</h5>
                <button type="button" class="btn btn-primary" id="add-show-form">Tambah Data</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="blog-table">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Tag</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal Form --}}
    <div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal_formTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Blog</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-blog">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="title" name="title">
                            <span class="text-danger" id="title_error"></span>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select id="category_id" name="category_id" class="form-control">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="category_id_error"></span>
                        </div>

                        <div class="mb-3">
                            <label for="tags" class="form-label">Tag</label>
                            <input type="text" class="form-control" id="tags" name="tags" placeholder="Pisahkan dengan koma (,)" />
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Konten</label>
                            <textarea id="content" name="content" class="form-control" rows="6"></textarea>
                            <span class="text-danger" id="content_error"></span>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btn-save">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
$(document).ready(function () {
    CKEDITOR.replace('content');

    // Setup AJAX CSRF
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // DataTable
    let table = $('#blog-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('adm.blog.index') }}",
        columns: [
            { data: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'category', name: 'category' },
            { data: 'tags', name: 'tags' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', className: 'text-center' },
        ],
    });

    // Tampilkan modal tambah
    $('#add-show-form').click(function(){
        $('#modal-form').modal('show');
        $('#form-blog')[0].reset();
        CKEDITOR.instances['content'].setData('');
        $('#id').val('');
    });

    // Simpan Blog
    $('#btn-save').click(function(e){
        e.preventDefault();
        let formData = new FormData($('#form-blog')[0]);
        formData.append('content', CKEDITOR.instances['content'].getData());

        $.ajax({
            url: "{{ route('adm.blog.store') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                if(response.success){
                    toastr.success(response.message);
                    $('#modal-form').modal('hide');
                    table.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr){
                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    $('#title_error').text(errors.title ? errors.title[0] : '');
                    $('#content_error').text(errors.content ? errors.content[0] : '');
                    $('#category_id_error').text(errors.category_id ? errors.category_id[0] : '');
                } else {
                    toastr.error('Terjadi kesalahan!');
                }
            }
        });
    });
});
</script>
@endsection
