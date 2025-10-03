<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adm\ProgramStudiRequest;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $data = ProgramStudi::select('id','code','name','email','phone','is_active');

    if (request()->ajax()) {
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return '
                    <div class="d-flex justify-content-center gap-1">
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-sm btn-circle btn-primary" id="btn-edit">
                            <i class="bi bi-pen-fill"></i>
                        </a>
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-sm btn-circle btn-danger" id="btn-delete">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }
    return view('adm.master.programstudi');
}

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //    if(request()->ajax()){
    //         return datatables()->of(ProgramStudi::query())
    //         ->addIndexColumn()
    //         ->addColumn('action', function($row){
    //             return '
    //                 <button data-id="'.$row->id.'" class="btn btn-sm btn-primary editBtn">Edit</button>
    //                 <button data-id="'.$row->id.'" class="btn btn-sm btn-danger deleteBtn">Delete</button>
    //             ';
    //     })
    //     ->rawColumns(['action'])
    //     ->make(true);
    // }

    // return view('adm.master.programstudi', compact('recycle'));
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProgramStudiRequest $request)
    {
       $validatedData = $request->validated();

        $data = ProgramStudi::create([
            'code'          =>  $validatedData['code'],
            'name'          =>  $validatedData['name'],
            'slug'          =>  Str::slug($validatedData['name']), // generate slug otomatis
            'email'         =>  $validatedData['email'] ?? null, // bisa nullable
            'phone'         =>  $validatedData['phone'] ?? null, // bisa nullable
            // 'is_active' =>  $request->has('is_active') ? 1 : 0,
            'is_active'     =>  $validatedData['is_active'] ?? true, // default aktif
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ProgramStudi::find($id);
        return response()->json([
            'data' => $data
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ProgramStudiRequest $request, $id)
    {
        $validatedData = $request->validated();
        $data = ProgramStudi::findOrFail($id);
        $data->update([
            'code'  => $validatedData['code'],
            'name'  => $validatedData['name'],
            'slug'  => \Str::slug($validatedData['name']), // update slug juga biar konsisten
            'email'     => $request->filled('email') ? $request->input('email') : $data->email,
            'phone'     => $request->filled('phone') ? $request->input('phone') : $data->phone,
            // 'is_active' =>  $request->has('is_active') ? 1 : 0,
            'is_active' => $validatedData['is_active'] ?? true, // default aktif
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
         $data = ProgramStudi::withTrashed()->findOrFail($id);
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
        $data = ProgramStudi::withTrashed()->findOrFail($id);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $data = ProgramStudi::findOrFail($id);
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