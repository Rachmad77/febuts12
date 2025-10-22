@extends('layouts.app')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                    <form id="form-blog" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        {{-- Judul --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="title" name="title">
                            <span class="text-danger" id="title_error"></span>
                        </div>

                        {{-- Kategori --}}
                        <div class="mb-3">
                            <label for="blog_category_id" class="form-label">Kategori</label>
                            <select id="blog_category_id" name="blog_category_id" class="form-control">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="blog_category_id_error"></span>
                        </div>

                        {{-- Tag --}}
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tag</label>
                            <select id="tags" name="tags[]" class="form-control" multiple>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Thumbnail --}}
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, atau JPEG.</small>
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control">
                                <option value="">-- Pilih Status --</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Konten --}}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

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

    // Select2 config
    $('#tags').select2({
        placeholder: 'Pilih tag',
        width: '100%',
        closeOnSelect: false,
        allowClear: true,
    });

    $('#modal-form').on('shown.bs.modal', function () {
        $('#tags').select2({
            placeholder: 'Pilih tag',
            width: '100%',
            closeOnSelect: false,
            allowClear: true,
        });
    });

    // 🔹 CKEditor 5 Setup
    let editorInstance;
    ClassicEditor
        .create(document.querySelector('#content'))
        .then(editor => {
            editorInstance = editor;
        })
        .catch(error => console.error(error));

    // 🔹 Tombol tambah data
    $('#add-show-form').click(function(){
        $('#modal-form').modal('show');
        $('#form-blog')[0].reset();
        $('#id').val('');
        $('#tags').val([]).trigger('change');

        if (editorInstance) {
            editorInstance.setData('');
        }
    });

    // 🔹 Tombol simpan
    $('#btn-save').click(function(e){
        e.preventDefault();
        let formData = new FormData($('#form-blog')[0]);
        formData.set('content', editorInstance.getData());

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
                    $('#form-blog')[0].reset();
                    editorInstance.setData('');
                    $('#tags').val([]).trigger('change');
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
                    $('#blog_category_id_error').text(errors.blog_category_id ? errors.blog_category_id[0] : '');
                    toastr.error('Data tidak valid, periksa kembali form kamu!');
                } else {
                    toastr.error('Terjadi kesalahan pada server!');
                }
            }
        });
    });
});
</script>
@endsection
