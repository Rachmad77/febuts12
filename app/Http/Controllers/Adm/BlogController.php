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
            $query = Blog::with(['category', 'tags'])->select('blogs.*');

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
                ->addColumn('tags', function ($row){
                    return $row->tags ? $row->tags->pluck('name')->implode(', ') : '-';
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

                // ->addColumn('created_at', function ($row) {
                //     return $row->created_at 
                //     ? $row->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') 
                //     : '-';
                // })

                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('adm.blog.edit', $row->id) . '" class="btn btn-sm btn-primary btn-edit">Edit</a>
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
        // dd($tags);

        $recycle = Blog::onlyTrashed()->get();

        return view('adm.blog.index', compact('categories', 'tags', 'statuses', 'recycle'));
    }

    public function dataTable(Request $request)
    {
        $query = Blog::with(['category', 'tags'])->select('blogs.*');

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
        
        ->addColumn('tags', function ($row){
                    return $row->tags ? $row->tags->pluck('name')->implode(', ') : '-';
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
        // <a href="' . route('adm.blog.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a> 
        ->addColumn('action', function ($row) {
            return '
                <button data-id=' . $row->id . ' class="btn btn-sm btn-primary btn-edit">Edit</button>
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

        return view('adm.blog.index', [
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
        try{

        // dd($request->all());
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
        // $baseSlug = Str::slug($request->slug ?? $request->title);
        $baseSlug = Str::slug($request->title);
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

        // return redirect()->route('adm.blog.index')->with('success', 'Blog berhasil ditambahkan!');
        return response()->json([
            'success' => true,
            'message' => 'Blog berhasil ditambahkan',
        ]);

        } catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan' . $e->getMessage(),
            ], 500);
        }
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

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $blog->id,
                'title' => $blog->title,
                'blog_category_id' => $blog->blog_category_id,
                'status' => $blog->status,
                'thumbnail' => $blog->thumbnail,
                'content' => $blog->content,
                'tags' => $blog->tags->map(fn($t)=>[
                    'id' => $t->id,
                    'name' => $t->name
                ]),
            ]
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

        //handle thumbnail
        if ($request->hasFile('thumbnail')) {
            // hapus thumbnail lama
            if ($blog->thumbnail && Storage::disk('public')->exists($blog->thumbnail)) {
                Storage::disk('public')->delete($blog->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail')->store('blog-thumbnails', 'public');
        }

        //published_at otomatis
        if ($data['status'] === 'published' && !$blog->published_at) {
            $data['published_at'] = Carbon::now();
        }

        //update blog
        $blog->update($data);

        //sync tags
        $blog->tags()->sync($request->tags ?? []);

        // return redirect()->route('adm.blog.index')->with('success', 'Blog berhasil diperbarui!');
        return response()->json([
            'success' => true,
            'message' => 'Blog berhasil diperbarui!'
        ]);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete(); // soft delete

        return response()->json([
            'success' => true, 
            'message' => 'Blog berhasil dihapus!']);
    }

    public function restore($id)
    {
        $blog = Blog::withTrashed()->findorFail($id);
        $blog->restore();

        return response()->json([
            'success' => true,
            'message' => 'Data blog berhasil dipulihkan'
        ]);
    }

    Public function forceDelete($id)
    {
        $blog = Blog::withTrashed()->findorFail($id);

        // Hapus thumbnail 
        if($blog->thumbnail && Storage::disk('public')->exists($blog->thumbnail)){
            Storage::disk('public')->delete($blog->thumbnail);
        }

        // Hapus relasi tags
        $blog->tags()->detach();

        // Hapus permanen
        $blog->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Data blog berhasil dihapus permanen'
        ]);
    }
}