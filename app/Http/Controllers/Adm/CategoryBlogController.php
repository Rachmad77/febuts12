<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adm\BlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryBlogController extends Controller
{
    public function index()
    {
        $data = BlogCategory::all();

        if (request()->ajax()) {

            return DataTables::of($data)
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('action', function ($data) {
                    $button  = '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-sm btn-circle btn-primary" id="btn-edit"><i class="bi bi-pen-fill"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-sm btn-circle btn-danger" id="btn-delete"><i class="bi bi-trash"></i></a>';

                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        $recycle = BlogCategory::onlyTrashed()->get();
        return view('adm.master.category_blog', compact('recycle'));
    }

    public function store(BlogCategoryRequest $request)
    {
        $validatedData = $request->validated();
        $data = BlogCategory::create([
            'name'          =>  $validatedData['name'],
        ]);

        if ($data) {
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Data created successfully',
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Data created failed',
            ]);
        }
    }

    public function edit($id)
    {
        $data = BlogCategory::find($id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function update(BlogCategoryRequest $request, $id)
    {
        $validatedData = $request->validated();

        $data = BlogCategory::findOrFail($id);
        $data->update([
            'name'  => $validatedData['name'],
        ]);

        if ($data) {
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Data updated successfully',
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Data updated failed',
            ]);
        }
    }

    public function restore($id)
    {
        $data = BlogCategory::withTrashed()->findOrFail($id);
        $data->restore();

        if ($data) {
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Data restored successfully',
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Data restored failed',
            ]);
        }
    }

    public function forceDelete($id)
    {
        $data = BlogCategory::withTrashed()->findOrFail($id);
        $data->forceDelete();

        if ($data) {
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Data deleted successfully',
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Data deleted failed',
            ]);
        }
    }

    public function destroy($id)
    {
        $data = BlogCategory::findOrFail($id);
        $data->delete();

        if ($data) {
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Data deleted successfully',
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Data deleted failed',
            ]);
        }
    }
}
