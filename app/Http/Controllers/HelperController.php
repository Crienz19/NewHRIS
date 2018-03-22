<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Position;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function comboDepartment()
    {
        return response()->json(Department::all());
    }

    public function comboPosition($id)
    {
        return response()->json(Position::where('department_id', $id)->orderBy('name', 'asc')->get());
    }

    public function comboBranch()
    {
        return response()->json(Branch::orderBy('name', 'asc')->get());
    }

    public function comboRole()
    {
        return response()->json(Role::all());
    }

    public function comboSupervisor()
    {
        $supervisors = User::join('employees', 'employees.user_id', '=', 'users.id')
                           ->select(['users.id', 'employees.full_name as employee'])
                           ->orderBy('name', 'asc')
                           ->whereRoleIs('supervisor')
                           ->get();

        return response()->json($supervisors);
    }
}
