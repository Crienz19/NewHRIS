<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FilterController extends Controller
{
    public function filterOTRequests($role, $start, $end, $status, $branch)
    {
        $overtimes = User::join('employees', 'employees.user_id', '=', 'users.id')
                         ->join('overtimes', 'overtimes.user_id', '=', 'users.id')
                         ->join('departments', 'departments.id', '=', 'employees.department_id')
                         ->join('positions', 'positions.id', '=', 'employees.position_id')
                         ->join('branches', 'branches.id', '=', 'employees.branch_id')
                         ->select(['overtimes.*', 'employees.full_name as employee', 'departments.name as department', 'position_id as position', 'branches.name as branch'])
                         ->where('overtimes.status', $status)
                         ->where('employees.branch_id', $branch)
                         ->whereBetween('overtimes.date', [$start, $end])
                         ->whereRoleIs($role)
                         ->get();

        return datatables()->of($overtimes)
            ->addColumn('action', function($overtime) {
                return '<button class="btn btn-default btn-xs">View</button>';
            })->toJson();
    }

    public function filterLeaveRequests($role, $start, $end, $status, $branch)
    {

    }

    public function filterOBRequests($role, $start, $end, $status, $branch)
    {

    }
}
