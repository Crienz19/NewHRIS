<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Leave;
use App\Position;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function SupervisorLeave($status)
    {
        return User::join('leaves', 'users.id', '=', 'leaves.user_id')
                        ->where('final_approval', $status)
                        ->whereRoleIs('supervisor')
                        ->count();
    }

    public function EmployeeLeave($status)
    {
        return User::join('employees', 'employees.user_id', '=', 'users.id')
                    ->join('leaves', 'leaves.user_id', '=', 'users.id')
                    ->join('departments', 'departments.id', '=', 'employees.department_id')
                    ->join('branches', 'branches.id', '=', 'employees.branch_id')
                    ->where('departments.supervisor', Auth::user()->id)
                    ->where('leaves.recommending_approval', $status)
                    ->whereRoleIs('user')
                    ->count();
    }

    public function EmployeeOT($status)
    {
        return User::join('employees', 'employees.user_id', '=', 'users.id')
                    ->join('overtimes', 'overtimes.user_id', '=', 'users.id')
                    ->join('departments', 'departments.id', '=', 'employees.department_id')
                    ->join('branches', 'branches.id', '=', 'employees.branch_id')
                    ->where('departments.supervisor', Auth::user()->id)
                    ->where('overtimes.status', $status)
                    ->whereRoleIs('user')
                    ->count();
    }
}
