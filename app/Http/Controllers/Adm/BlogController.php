<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\TagCategory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Blog::with('category')->select('blogs.*');

            // Filter berdasarkan kategori
            if ($request->filled('category_id')) {
                $query->where('blog_category_id', $request->category_id);
            }

            // Filter berdasarkan status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('category', fn($row) => $row->category ? $row->category->name : '-')
                ->addColumn('thumbnail', function ($row) {
                    if ($row->thumbnail) {
                        return '<img src="' . asset('storage/' . $row->thumbnail) . '" width="80" class="rounded">';
                    }
                    return '-';
                })
                ->addColumn('status', function ($row) {
                    $badgeClass = match ($row->status) {
                        'published' => 'success',
                        'draft' => 'secondary',
                        'archived' => 'warning',
                        default => 'secondary'
                    };
                    return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('adm.blog.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                        <button data-id="' . $row->id . '" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                    ';
                })
                ->rawColumns(['thumbnail', 'status', 'action'])
                ->make(true);
        }

        // ✅ tambahkan status di index
        $statuses = [
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived',
        ];

        // ini penting! harus di bawah ini biar ke-load di view
        $categories = BlogCategory::all();
        $tags = TagCategory::all();
        dd($tags);
        return view('adm.blog.index', compact('categories', 'tags', 'statuses'));
    }

    public function dataTable(Request $request)
{
    $query = Blog::with('category')->select('blogs.*');

    if ($request->filled('category_id')) {
        $query->where('blog_category_id', $request->category_id);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('category', fn($row) => $row->category ? $row->category->name : '-')
        ->addColumn('thumbnail', function ($row) {
            if ($row->thumbnail) {
                return '<img src="' . asset('storage/' . $row->thumbnail) . '" width="80" class="rounded">';
            }
            return '-';
        })
        ->addColumn('status', function ($row) {
            $badgeClass = match ($row->status) {
                'published' => 'success',
                'draft' => 'secondary',
                'archived' => 'warning',
                default => 'secondary'
            };
            return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
        })
        ->addColumn('action', function ($row) {
            return '
                <a href="' . route('adm.blog.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                <button data-id="' . $row->id . '" class="btn btn-sm btn-danger btn-delete">Hapus</button>
            ';
        })
        ->rawColumns(['thumbnail', 'status', 'action'])
        ->make(true);
}

    public function create()
    {
        $categories = BlogCategory::all();
        $tags = TagCategory::all();

        $statuses = [
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived',
        ];

        return view('adm.blog.form', [
            'blog' => new Blog(),
            'categories' => $categories,
            'tags' => $tags,
            'statuses' => $statuses,
            'action' => route('adm.blog.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blogs,slug',
            'content' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['blog_category_id', 'title', 'content', 'status']);
        $data['status'] = $request->status ?? 'draft';

        // ✅ perbaikan slug unik
        $baseSlug = Str::slug($request->slug ?? $request->title);
        $slug = $baseSlug;
        $counter = 2;

        while (Blog::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('blog-thumbnails', 'public');
        }

        if ($data['status'] === 'published') {
            $data['published_at'] = Carbon::now();
        }

        $blog = Blog::create($data);

        if ($request->has('tags')) {
            $blog->tags()->attach($request->tags);
        }

        return redirect()->route('adm.blog.index')->with('success', 'Blog berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $blog = Blog::with('tags')->findOrFail($id);
        $categories = BlogCategory::all();
        $tags = TagCategory::all();

        $statuses = [
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived',
        ];

        return view('adm.blog.form', [
            'blog' => $blog,
            'categories' => $categories,
            'tags' => $tags,
            'statuses' => $statuses,
            'action' => route('adm.blog.update', $blog->id),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blogs,slug,' . $id,
            'content' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'nullable|in:draft,published,archived',
        ]);

        $data = $request->only(['blog_category_id', 'title', 'content', 'status']);

        // ✅ perbaikan slug unik saat update
        $baseSlug = Str::slug($request->slug ?? $request->title);
        $slug = $baseSlug;
        $counter = 2;

        while (Blog::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $data['slug'] = $slug;

        if ($request->hasFile('thumbnail')) {
            // hapus thumbnail lama
            if ($blog->thumbnail && Storage::disk('public')->exists($blog->thumbnail)) {
                Storage::disk('public')->delete($blog->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail')->store('blog-thumbnails', 'public');
        }

        if ($data['status'] === 'published' && !$blog->published_at) {
            $data['published_at'] = Carbon::now();
        }

        $blog->update($data);
        $blog->tags()->sync($request->tags ?? []);

        return redirect()->route('adm.blog.index')->with('success', 'Blog berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->thumbnail && Storage::disk('public')->exists($blog->thumbnail)) {
            Storage::disk('public')->delete($blog->thumbnail);
        }

        $blog->delete();

        return response()->json(['success' => true, 'message' => 'Blog berhasil dihapus!']);
    }
}