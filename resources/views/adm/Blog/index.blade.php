@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Manajemen Blog</h4>
        <button class="btn btn-primary" id="btnAdd">+ Tambah Blog</button>
    </div>

    <div class="mb-3">
        <select id="filterCategory" class="form-select w-auto d-inline-block">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>

        <select id="filterStatus" class="form-select w-auto d-inline-block">
            <option value="">Semua Status</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="archived">Archived</option>
        </select>
    </div>

    <table class="table table-bordered table-striped" id="blogTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Thumbnail</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Tanggal Publish</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="blogModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="blogForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="blog_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="blog_category_id" id="blog_category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Thumbnail</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                        <img id="preview" class="mt-2 rounded" width="100">
                    </div>

                    <div class="mb-3">
                        <label>Cuplikan</label>
                        <textarea name="excerpt" id="excerpt" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Konten</label>
                        <textarea name="content" id="content" class="form-control" rows="5"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
$(function(){
    CKEDITOR.replace('content');

    let table = $('#blogTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('adm.blog.index') }}",
            data: function(d) {
                d.category_id = $('#filterCategory').val();
                d.status = $('#filterStatus').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'thumbnail', name: 'thumbnail', orderable:false, searchable:false},
            {data: 'title', name: 'title'},
            {data: 'category', name: 'category.name'},
            {data: 'status', name: 'status'},
            {data: 'published_at', name: 'published_at'},
            {data: 'action', name: 'action', orderable:false, searchable:false},
        ]
    });

    $('#filterCategory, #filterStatus').change(function(){
        table.ajax.reload();
    });

    $('#btnAdd').click(function(){
        $('#blogForm')[0].reset();
        $('#blog_id').val('');
        CKEDITOR.instances['content'].setData('');
        $('#modalTitle').text('Tambah Blog');
        $('#blogModal').modal('show');
    });

    // Simpan / Update blog
    $('#blogForm').submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);
        formData.set('content', CKEDITOR.instances['content'].getData());

        let id = $('#blog_id').val();
        let url = id ? "{{ url('adm/blog') }}/" + id : "{{ route('adm.blog.store') }}";
        let method = id ? "POST" : "POST";
        if (id) formData.append('_method', 'PUT');

        $.ajax({
            url: url,
            method: method,
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                $('#blogModal').modal('hide');
                table.ajax.reload();
                alert('Blog berhasil disimpan!');
            },
            error: function(err){
                console.log(err);
                alert('Terjadi kesalahan!');
            }
        });
    });

    // Edit blog
