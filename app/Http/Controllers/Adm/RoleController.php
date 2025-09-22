<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $data = Role::all();

        if (request()->ajax()) {

            return datatables()::of($data)
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('guard_name', function ($row) {
                    return "<span class='text-capitalize badge bg-primary text-white text-wrap'>$row->guard_name</span>";
                })
                ->addColumn('action', function ($data) {
                    $button = '&nbsp;&nbsp;';
                    $button  .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-sm btn-circle btn-warning" id="show_modal_permissions"><i class="bi bi-eye-fill"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-sm btn-circle btn-primary" id="btnEdit"><i class="bi bi-pen-fill"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-sm btn-circle btn-danger" id="btnDelete"><i class="bi bi-trash-fill"></i></a>';

                    return $button;
                })
                ->rawColumns(['guard_name', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
        $permissions = Permission::all();
        return view('adm.manage.roles', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'guard_name'    => ['required', 'string', 'max:255'],
        ]);

        $data = Role::create([
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
        $permissions = Permission::all();
        $data = Role::with('permissions')->find($id);
        return response()->json([
            'data'          => $data,
            'permissions'   => $permissions
        ]);
    }

    public function checked(Request $request, string $id)
    {
        $data = Role::findOrFail($id);
        $permissions = $request->input('permissions', []);

        $validPermissions = Permission::whereIn('id', $permissions)->pluck('id')->toArray();
        $data->syncPermissions($validPermissions);

        return response()->json([
            'success'   =>  true,
            'message'   =>  'Data updated successfully',
        ]);
    }

    public function edit(string $id)
    {
        $data = Role::find($id);
        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'guard_name'    => ['required', 'string', 'max:255'],
        ]);

        $data = Role::findOrFail($id);
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
        $data = Role::findOrFail($id);
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
