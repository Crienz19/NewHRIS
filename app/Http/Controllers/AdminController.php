<?php

namespace App\Http\Controllers;

use App\Credit;
use App\Employee;
use App\Leave;
use App\Mail\ApproveLeaveNotification;
use App\Mail\DisapproveLeaveNotification;
use App\Mail\LeaveComment;
use App\Overtime;
use App\Trip;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    #Leave Request!
    public function loadLeaveRequests($role, $status = 'Pending')
    {
        $leaves = User::join('employees', 'employees.user_id', '=', 'users.id')
                     ->join('leaves', 'leaves.user_id', '=', 'users.id')
                     ->join('departments', 'departments.id', '=', 'employees.department_id')
                     ->join('branches', 'branches.id', '=', 'employees.branch_id')
                     ->select(['employees.full_name as employee', 'position_id as position', 'departments.name as department', 'branches.name as branch', 'leaves.*'])
                     ->where('leaves.final_approval', $status)
                     ->whereRoleIs($role)
                     ->get();

        return datatables()->of($leaves)
            ->addColumn('action', function($leave) {
                return '<button class="btn btn-default btn-xs" data="view" data-id="'.$leave->id.'"><span class="glyphicon glyphicon-eye-open"></span></button>
                        <button class="btn btn-success btn-xs" data="send" data-id="'.$leave->id.'"><span class="glyphicon glyphicon-send"></span></button>';
            })->toJson();
    }

    public function viewLeaveRequest($id)
    {
        return response()->json(Leave::find($id));
    }

    public function LeaveRequestApproved($id)
    {
        $leave = Leave::find($id);
        $credit = Credit::where('user_id', $leave->user_id)->first();

        if ($leave->final_approval == 'Pending' || $leave->final_approval == 'Disapproved') {
            if ($leave->type == 'VL' && $leave->pay_type == 'With Pay') {
                Credit::where('user_id', $credit->user_id)->update(['VL'    => $credit->VL - $leave->count]);
            } elseif ($leave->type == 'VL-Half' && $leave->pay_type == 'With Pay') {
                Credit::where('user_id', $credit->user_id)->update(['VL'    => $credit->VL - .5]);
            } elseif ($leave->type == 'SL' && $leave->pay_type == 'With Pay') {
                Credit::where('user_id', $credit->user_id)->update(['SL'    => $credit->SL - $leave->count]);
            } elseif ($leave->type == 'PTO' && $leave->pay_type == 'With Pay') {
                Credit::where('user_id', $credit->user_id)->update(['PTO'    => $credit->PTO - $leave->count]);
            } elseif ($leave->type == 'PTO-Half' && $leave->pay_type == 'With Pay') {
                Credit::where('user_id', $credit->user_id)->update(['PTO'    => $credit->PTO - .5]);
            }
        }

        $leave->update([
            'final_approval'    =>  'Approved'
        ]);

        Mail::to(User::where('id', $leave->user_id)->first()->email)->send(new ApproveLeaveNotification());

        return response()->json(['message' => 'Success']);
    }

    public function LeaveRequestDisapproved($id)
    {
        $leave = Leave::find($id);
        $credit = Credit::where('user_id', $leave->user_id)->first();

        if ($leave->final_approval == 'Approved') {
            if ($leave->type == 'VL' && $leave->pay_type == 'With Pay') {
                Credit::where('user_id', $credit->user_id)->update(['VL'    => $credit->VL + $leave->count]);
            } elseif ($leave->type == 'VL-Half' && $leave->pay_type == 'With Pay') {
                Credit::where('user_id', $credit->user_id)->update(['VL'    => $credit->VL + .5]);
            } elseif ($leave->type == 'SL' && $leave->pay_type == 'With Pay') {
                Credit::where('user_id', $credit->user_id)->update(['SL'    => $credit->SL + $leave->count]);
            } elseif ($leave->type == 'PTO' && $leave->pay_type == 'With Pay') {
                Credit::where('user_id', $credit->user_id)->update(['PTO'    => $credit->PTO + $leave->count]);
            } elseif ($leave->type == 'PTO-Half' && $leave->pay_type == 'With Pay') {
                Credit::where('user_id', $credit->user_id)->update(['PTO'    => $credit->PTO + .5]);
            }
        }

        $leave->update([
            'final_approval'    =>  'Disapproved'
        ]);

        Mail::to(User::where('id', $leave->user_id)->first()->email)->send(new DisapproveLeaveNotification());

        return response()->json(['message' => 'Success']);
    }

    public function loadOvertimeRequests($role, $status = 'Pending')
    {
        $overtimes = User::join('employees', 'employees.user_id', '=', 'users.id')
                        ->join('overtimes', 'overtimes.user_id', '=', 'users.id')
                        ->join('departments', 'departments.id', '=', 'employees.department_id')
                        ->join('branches', 'branches.id', '=', 'employees.branch_id')
                        ->select(['employees.full_name as employee', 'position_id as position', 'departments.name as department', 'branches.name as branch', 'overtimes.*'])
                        ->where('overtimes.status', $status)
                        ->whereRoleIs($role)
                        ->get();

        return datatables()->of($overtimes)
            ->addColumn('action', function($overtime) {
                return '<button class="btn btn-default btn-xs" data="view" data-id="'.$overtime->id.'">VIEW</button>';
            })->toJson();
    }

    public function viewOvertimeRequest($id)
    {
        return response()->json(Overtime::find($id));
    }

    public function loadTripRequests($role, $status = 'Pending')
    {
        $trips = User::join('employees', 'employees.user_id', '=', 'users.id')
                    ->join('trips', 'trips.user_id', '=', 'users.id')
                    ->join('departments', 'departments.id', '=', 'employees.department_id')
                    ->join('branches', 'branches.id', '=', 'employees.branch_id')
                    ->select(['trips.*', 'employees.full_name as employee', 'departments.name as department', 'position_id as position', 'branches.name as branch'])
                    ->where('trips.status', $status)
                    ->whereRoleis($role)
                    ->get();

        return datatables()->of($trips)
            ->addColumn('action', function($trip) {
                return '<button class="btn btn-default btn-xs" data="view" data-id="'.$trip->id.'">VIEW</button>';
            })->toJson();
    }

    public function viewTripRequest($id)
    {
        return response()->json(Trip::find($id));
    }

    public function sendLeaveComment(Request $request, $id)
    {
        $leave = Leave::find($id);

        $data = [
            'from'      =>  $leave->from,
            'to'        =>  $leave->to,
            'reason'    =>  $leave->reason,
            'comment'   =>  $request->input('comment-text')
        ];

        Mail::to(User::where('id', $leave->user_id)->first()->email)->send(new LeaveComment($data));

        return response()->json(['message' => 'Comment Sent']);
    }
}
