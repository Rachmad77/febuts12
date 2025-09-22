<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $data = Permission::all();

        if (request()->ajax()) {

            return datatables()::of($data)
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('guard_name', function ($row) {
                    return "<span class='text-capitalize badge bg-primary text-white text-wrap'>$row->guard_name</span>";
                })
                ->addColumn('action', function ($data) {
                    $button  = '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-sm btn-circle btn-primary" id="btnEdit"><i class="bi bi-pen-fill"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-sm btn-circle btn-danger" id="btnDelete"><i class="bi bi-trash"></i></a>';

                    return $button;
                })
                ->rawColumns(['guard_name', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('adm.manage.permission');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'guard_name'    => ['required', 'string', 'max:255'],
        ]);

        $data = Permission::create([
            'name'          =>  $validatedData['name'],
            'guard_name'   =>  $validatedData['guard_name'],
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

    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $data = Permission::find($id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'guard_name'    => ['required', 'string', 'max:255'],
        ]);

        $data = Permission::findOrFail($id);
        $data->update([
            'name'          =>  $validatedData['name'],
            'guard_name'   =>  $validatedData['guard_name'],
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
    public function destroy(string $id)
    {
        $data = Permission::findOrFail($id);
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
