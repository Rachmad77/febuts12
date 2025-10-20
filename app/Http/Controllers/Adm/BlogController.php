<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
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
                    $badgeClass = match($row->status) {
                        'published' => 'success',
                        'draft' => 'secondary',
                        'archived' => 'warning',
                        default => 'secondary'
                    };
                    return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="'.route('adm.blog.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <button data-id="'.$row->id.'" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                    ';
                })
                ->rawColumns(['thumbnail', 'status', 'action'])
                ->make(true);
        }

        $categories = BlogCategory::all();
        return view('adm.blog.index', compact('categories'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('adm.blog.form', [
            'blog' => new Blog(),
            'categories' => $categories,
            'action' => route('adm.blog.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['blog_category_id', 'title', 'content', 'status']);
        $data['slug'] = Str::slug($request->title);
        $data['status'] = $request->status ?? 'draft';

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('blog-thumbnails', 'public');
        }

        if ($data['status'] === 'published') {
            $data['published_at'] = Carbon::now();
        }

        Blog::create($data);

        return redirect()->route('adm.blog.index')->with('success', 'Blog berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::all();

        return view('adm.blog.form', [
            'blog' => $blog,
            'categories' => $categories,
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
            'content' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['blog_category_id', 'title', 'content', 'status']);
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama
            if ($blog->thumbnail && Storage::disk('public')->exists($blog->thumbnail)) {
                Storage::disk('public')->delete($blog->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('blog-thumbnails', 'public');
        }

        if ($data['status'] === 'published' && !$blog->published_at) {
            $data['published_at'] = Carbon::now();
        }

        $blog->update($data);

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
