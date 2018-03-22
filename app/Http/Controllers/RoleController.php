<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function loadRoles()
    {
        $roles = Role::select(['*'])->get();

        return datatables()->of($roles)
            ->addColumn('action', function ($role) {
                return '<button class="btn btn-success btn-xs" data="edit" data-id="'.$role->id.'"><span class="glyphicon glyphicon-pencil"></span></button>
                        <button class="btn btn-danger btn-xs" data="remove" data-id="'.$role->id.'"><span class="glyphicon glyphicon-trash"></span></button>';
            })->toJson();
    }

    public function storeRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role-name'             => 'required',
            'role-display-name'     =>  'required',
            'role-description'      =>  'required'
        ])->validate();

        Role::create([
            'name'          =>  $request->input('role-name'),
            'display_name'  =>  $request->input('role-display-name'),
            'description'   =>  $request->input('role-description')
        ]);

        return response()->json(['message'  =>  'Role Stored!']);
    }

    public function editRole($id)
    {
        return response()->json(Role::find($id));
    }

    public function updateRole(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role-name'         =>  'required',
            'role-display-name' =>  'required',
            'role-description'  =>  'required'
        ])->validate();

        Role::find($id)->update([
            'name'          =>  $request->input('role-name'),
            'display_name'  =>  $request->input('role-display-name'),
            'description'   =>  $request->input('role-description')
        ]);

        return response()->json(['message'  =>  'Role Updated']);
    }

    public function deleteRole($id)
    {
        Role::find($id)->delete();

        return response()->json(['message'  =>  'Role Deleted']);
    }
}
