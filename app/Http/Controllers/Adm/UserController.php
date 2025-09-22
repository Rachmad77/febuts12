<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $data = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'administrator');
        })->get();

        if (request()->ajax()) {

            return DataTables::of($data)
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('email', function ($row) {
                    return $row->email;
                })
                ->addColumn('roles', function ($row) {
                    if ($row->roles->isEmpty()) {
                        return '<span class="badge bg-secondary">No Role</span>';
                    }

                    $badges = $row->roles->map(function ($role) {
                        return '<span class="badge bg-primary me-1">#' . e($role->name) . '</span>';
                    })->implode(' ');

                    return $badges;
                })
                ->addColumn('action', function ($data) {
                    $button  = '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-sm btn-circle btn-primary" id="btn-edit"><i class="bi bi-pen-fill"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-sm btn-circle btn-danger" id="btn-delete"><i class="bi bi-trash"></i></a>';

                    return $button;
                })
                ->rawColumns(['roles', 'action'])
                ->addIndexColumn()
                ->make(true);
        }

        $roles = Role::where('name', '!=', 'administrator')->get();
        return view('adm.manage.users', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'roles'     => 'required|exists:roles,name',
        ]);


        $data = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::where('name', $request->roles)->first();
        $data->assignRole($role);

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
        $data = User::with('roles')->find($id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'roles'     => 'required|exists:roles,name',
        ]);


        $data = User::findOrFail($id);

        $updateData = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $data->update($updateData);

        if ($request->has('roles')) {
            $data->syncRoles([$request->roles]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);

        $deleted = $data->delete();

        return response()->json([
            'success' => $deleted,
            'message' => $deleted ? 'Data deleted successfully' : 'Data delete failed',
        ]);
    }
}
