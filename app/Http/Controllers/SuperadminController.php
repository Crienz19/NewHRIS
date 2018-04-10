<?php

namespace App\Http\Controllers;

use App\Credit;
use App\Employee;
use App\Leave;
use App\Log;
use App\Overtime;
use App\Trip;
use App\User;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    public function loadLeaves()
    {
        $leaves = User::join('employees', 'employees.user_id', '=', 'users.id')
                      ->join('leaves', 'leaves.user_id', '=', 'users.id')
                      ->join('departments', 'departments.id', '=', 'employees.department_id')
                      ->join('branches', 'branches.id', '=', 'employees.branch_id')
                      ->select(['leaves.*', 'employees.full_name as employee', 'position_id as position', 'departments.name as department', 'branches.name as branch'])
                      ->get();

        return datatables()->of($leaves)
            ->addColumn('action', function($leave) {
                return '<button class="btn btn-default btn-xs" data="view" data-id="'.$leave->id.'"><span class="glyphicon glyphicon-eye-open"></span></button>';
            })->toJson();
    }

    public function loadSingleLeave($id)
    {
        return response()->json(Leave::find($id));
    }

    public function loadOvertimes()
    {
        $overtimes = User::join('employees', 'employees.user_id', '=', 'users.id')
                         ->join('overtimes', 'overtimes.user_id', '=', 'users.id')
                         ->join('departments', 'departments.id', '=', 'employees.department_id')
                         ->join('branches', 'branches.id', '=', 'employees.branch_id')
                         ->select(['overtimes.*', 'employees.full_name as employee', 'position_id as position', 'departments.name as department', 'branches.name as branch'])
                         ->orderBy('date', 'desc')
                         ->get();

        return datatables()->of($overtimes)
            ->addColumn('action', function($overtime) {
                return '<button class="btn btn-default btn-xs" data="view" data-id="'.$overtime->id.'"><span class="glyphicon glyphicon-eye-open"></span></button>';
            })->toJson();
    }

    public function loadSingleOvertime($id)
    {
        return response()->json(Overtime::find($id));
    }

    public function loadTrips()
    {
        $trips = User::join('employees', 'employees.user_id', '=', 'users.id')
                     ->join('trips', 'trips.user_id', '=', 'users.id')
                     ->join('departments', 'departments.id', '=', 'employees.department_id')
                     ->join('branches', 'branches.id', '=', 'employees.branch_id')
                     ->select(['trips.*', 'employees.full_name as employee', 'position_id as position', 'departments.name as department', 'branches.name as branch'])
                     ->get();

        return datatables()->of($trips)
            ->addColumn('action', function($trip) {
                return '<button class="btn btn-default btn-xs" data="view" data-id="'.$trip->id.'"><span class="glyphicon glyphicon-eye-open"></span></button>';
            })->toJson();
    }

    public function loadSingleTrip($id){
        return response()->json(Trip::find($id));
    }

    public function loadActivityLogs()
    {
        $logs = User::join('employees', 'employees.user_id', '=', 'users.id')
                    ->join('logs', 'logs.user_id', '=', 'users.id')
                    ->join('departments', 'departments.id', '=', 'employees.department_id')
                    ->join('branches', 'branches.id', '=', 'employees.branch_id')
                    ->select(['logs.*', 'employees.full_name as employee', 'position_id as position', 'departments.name as department', 'branches.name as branch'])
                    ->get();

        return datatables()->of($logs)
            ->addColumn('action', function($log) {
                return '<button class="btn btn-default btn-xs" data="remove" data-id="'.$log->id.'"><span class="glyphicon glyphicon-trash"></span></button>';
            })->toJson();
    }

    public function deleteLog($id)
    {
        Log::find($id)->delete();

        return response()->json(['message'  =>  'Log Deleted']);
    }

    public function updateCredits(Request $request, $id, $type)
    {
        switch ($type) {
            case 'VL':
                Credit::where('user_id', $id)->update([
                    'VL'        =>  $request->input('current-credit'),
                    'total_VL'  =>  $request->input('total-credit')
                ]);

                return response()->json(['message'  =>  'VL Credit Updated']);
                break;

            case 'SL':
                Credit::where('user_id', $id)->update([
                    'SL'        =>  $request->input('current-credit'),
                    'total_SL'  =>  $request->input('total-credit')
                ]);

                return response()->json(['message'  =>  'SL Credit Updated']);
                break;

            case 'PTO':
                Credit::where('user_id', $id)->update([
                    'PTO'       =>  $request->input('current-credit'),
                    'total_PTO' =>  $request->input('total-credit')
                ]);

                return response()->json(['message'  =>  'PTO Credit Updated']);
                break;
        }
    }
}
