<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\TagCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class TagCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TagCategory::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn  = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-sm btn-circle btn-primary" id="btn-edit"><i class="bi bi-pen-fill"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-sm btn-circle btn-danger" id="btn-delete"><i class="bi bi-trash"></i></a>';

                    // $btn = '<button type="button" data-id="'.$row->id.'" class="btn btn-sm btn-warning editBtn">Edit</button> ';
                    // $btn .= '<button type="button" data-id="'.$row->id.'" class="btn btn-sm btn-danger deleteBtn">Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $recycle = TagCategory::onlyTrashed()->get();
        
        return view('adm.master.category_tag', compact('recycle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tag_categories,name',
        ]);

        TagCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json(['success' => 'Tag berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(TagCategory $tagCategory)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tagCategory = TagCategory::findOrFail($id);
        return response()->json($tagCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tagCategory = TagCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:tag_categories,name,'.$tagCategory->id,
        ]);

        $tagCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json(['success' => 'Tag berhasil diperbarui']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tagCategory = TagCategory::findOrFail($id);
        $tagCategory->delete();

        return response()->json(['success' => 'Tag berhasil dihapus']);
    }
}
