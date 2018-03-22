<?php

namespace App\Http\Controllers;

use App\Credit;
use App\Department;
use App\Leave;
use App\Log;
use App\Mail\ApproveOvertimeNotification;
use App\Mail\DisapproveLeaveNotification;
use App\Mail\DisapproveOvertimeNotification;
use App\Mail\LeaveRecommendationNotification;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Employee;
use App\Overtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SupervisorController extends Controller
{
    #Assign
    public function assignSupervisor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sup-name'  =>  'required'
        ])->validate();

        Department::find($request->input('dept-id'))->update(['supervisor' => $request->input('sup-name')]);

        return response()->json(['message'  =>  'Success']);
    }

    #Leave
    public function loadLeaveRequests($status)
    {
        $user = User::join('employees', 'employees.user_id', '=', 'users.id')
                    ->where('users.id', Auth::user()->id)
                    ->first();

        $leaves = User::join('employees', 'employees.user_id', '=', 'users.id')
                      ->join('leaves', 'leaves.user_id', '=', 'users.id')
                      ->join('positions', 'positions.id', '=', 'employees.position_id')
                      ->join('departments', 'departments.id', '=', 'employees.department_id')
                      ->join('branches', 'branches.id', '=', 'employees.branch_id')
                      ->select(['employees.full_name as employee', 'positions.name as position', 'departments.name as department', 'branches.name as branch', 'leaves.*'])
                      ->where('employees.department_id', $user->department_id)
                      ->where('employees.branch_id', $user->branch_id)
                      ->where('leaves.recommending_approval', $status)
                      ->whereRoleIs('user')
                      ->get();

        return datatables()->of($leaves)
            ->addColumn('action', function($leave) {
                return '<button class="btn btn-default btn-xs" data="view" data-id="'.$leave->id.'">View</button>';
            })->toJson();
    }

    public function viewLeaveRequests($id)
    {
        $leave = Leave::find($id);

        return response()->json($leave);
    }

    public function LeaveRequestApproved(Request $request, $id)
    {
        $leave = Leave::find($id);

        $leave->update([
            'recommending_approval'     => 'Approved',
            'remarks'                   => ($request->input('remarks') == '') ? 'Approved for Recommendation to HR' : $request->input('remarks')
        ]);

        Mail::to(env('HR_EMAIL'))->send(new LeaveRecommendationNotification());

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  Employee::where('user_id', $leave->user_id)->first()->full_name . ' Leave Recommendation Approved'
        ]);

        return response()->json(['message' => 'Approved']);
    }

    public function LeaveRequestDisapproved(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'remarks'   => 'required'
        ])->validate();

        $leave = Leave::find($id);

        $leave->update([
            'recommending_approval'     => 'Disapproved',
            'remarks'                   => $request->input('remarks')
        ]);

        Mail::to(User::where('id', $leave->user_id)->first()->email)->send(new DisapproveLeaveNotification());

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  Employee::where('user_id', $leave->user_id)->first()->full_name . ' Leave Recommendation Disapproved'
        ]);

        return response()->json(['message' => 'Disapproved']);
    }

    #Overtime
    public function loadOTRequests($status)
    {
        $user = User::join('employees', 'employees.user_id', '=', 'users.id')
                    ->where('users.id', Auth::user()->id)
                    ->first();

        $overtimes = User::join('employees', 'employees.user_id', '=', 'users.id')
                         ->join('overtimes', 'overtimes.user_id', '=', 'users.id')
                         ->join('positions', 'positions.id', '=', 'employees.position_id')
                         ->join('departments', 'departments.id', '=', 'employees.department_id')
                         ->join('branches', 'branches.id', '=', 'employees.branch_id')
                         ->select(['employees.full_name as employee', 'positions.name as position', 'departments.name as department', 'branches.name as branch', 'overtimes.*'])
                         ->where('employees.department_id', $user->department_id)
                         ->where('employees.branch_id', $user->branch_id)
                         ->where('overtimes.status', $status)
                         ->whereRoleIs('user')
                         ->get();

        return datatables()->of($overtimes)
            ->addColumn('action', function($overtime) {
                return '<button class="btn btn-default btn-xs" data="view" data-id="'.$overtime->id.'">View</button>';
            })->toJson();
    }

    public function viewOTRequests($id)
    {
        $overtime = Overtime::find($id);

        return response()->json($overtime);
    }

    public function OTRequestApproved(Request $request, $id)
    {
        $overtime = Overtime::find($id);
        $credit = Credit::where('user_id', $overtime->user_id)->first();

        Credit::where('user_id', $credit->user_id)->update(['OT'    =>  $credit->OT + 1]);

        $overtime->find($id)->update([
            'status'    => 'Approved',
            'remarks'   => ($request->input('remarks') == '') ? 'Overtime Request Approved' : $request->input('remarks')
        ]);

        Mail::to(User::where('id', $overtime->user_id)->first()->email)->send(new ApproveOvertimeNotification());

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  Employee::where('user_id', $overtime->user_id)->first()->full_name . ' Overtime Approved'
        ]);

        return response()->json(['message' => 'OT Approved']);
    }

    public function OTRequestDisapproved(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'remarks'   => 'required'
        ])->validate();

        $overtime = Overtime::find($id);

        $overtime->update([
            'status'    => 'Disapproved',
            'remarks'   => $request->input('remarks')
        ]);

        Mail::to(User::where('id', $overtime->user_id)->first()->email)->send(new DisapproveOvertimeNotification());

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  Employee::where('user_id', $overtime->user_id)->first()->full_name . ' Overtime Disapproved'
        ]);

        return response()->json(['message' => 'OT Disapproved']);
    }
    #Leave
}
