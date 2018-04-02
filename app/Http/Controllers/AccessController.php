<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AccessController extends Controller
{
    public function loadAccessControl()
    {
        $access = User::select(['id', 'name', 'email', 'created_at']);

        return datatables()->of($access)
            ->addColumn('action', function($access) {
                return '<button class="btn btn-primary btn-xs" data="assign"><span class="glyphicon glyphicon-plus"></span></button>
                        <button class="btn btn-success btn-xs" data="edit"><span class="glyphicon glyphicon-pencil"></span></button>
                        <button class="btn btn-danger btn-xs" data="remove"><span class="glyphicon glyphicon-trash"></span></button>';
            })->toJson();
    }

    public function assignAccess(Request $request, $id)
    {
        $user = User::find($id);

        if ($user->hasRole() == true) {
            $user->detachRole($user->roles()->first()->name);
            $user->attachRole($request->input('role'));
        } else {
            $user->attachRole($request->input('role'));
        }
        return response()->json(['message'  =>  'Role Assigned!']);
    }
}
