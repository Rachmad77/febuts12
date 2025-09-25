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
        $data = ProgramStudi::all();

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

        $recycle = ProgramStudi::onlyTrashed()->get();
        return view('adm.master.programstudi', compact('recycle'));
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