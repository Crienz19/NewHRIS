<?php

namespace App\Http\Controllers;

use App\Credit;
use App\Employee;
use App\Leave;
use App\Log;
use App\Mail\ApproveLeaveNotification;
use App\Mail\ApproveOvertimeNotification;
use App\Mail\ApproveTripNotification;
use App\Mail\DisapproveLeaveNotification;
use App\Mail\DisapproveOvertimeNotification;
use App\Notice;
use App\Overtime;
use App\Trip;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HRController extends Controller
{
    #Leave
    public function loadLeaveRequests($status, $role)
    {
        $leaves = User::join('employees', 'employees.user_id', '=', 'users.id')
                      ->join('leaves', 'leaves.user_id', '=', 'users.id')
                      ->join('departments', 'departments.id', '=', 'employees.department_id')
                      ->join('branches', 'branches.id', '=', 'employees.branch_id')
                      ->select(['leaves.*', 'employees.full_name as employee', 'departments.name as department', 'position_id as position', 'branches.name as branch'])
                      ->where('leaves.recommending_approval', 'Approved')
                      ->where('leaves.final_approval', $status)
                      ->whereRoleIs($role)
                      ->get();

        return datatables()->of($leaves)
            ->addColumn('action', function($leave) {
                return '<button class="btn btn-default btn-xs" data="view" data-id="'.$leave->id.'">View</button>';
            })->toJson();
    }

    public function viewLeaveRequests($id)
    {
        $leaves = Leave::find($id);

        return response()->json($leaves);
    }

    public function FinalLeaveApproved($id)
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

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  Employee::where('user_id', $leave->user_id)->first()->full_name. ' Leave Request Approved'
        ]);

        Mail::to(User::where('id', $leave->user_id)->first()->email)->send(new ApproveLeaveNotification());

        return response()->json(['message' => 'Success']);
    }

    public function FinalLeaveDisapproved($id)
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

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  Employee::where('user_id', $leave->user_id)->first()->full_name. ' Leave Request Disapproved'
        ]);

        return response()->json(['message' => 'Success']);
    }

    #Overtime
    public function loadOTRequests($status, $role)
    {
        $overtimes = User::join('employees', 'employees.user_id', '=', 'users.id')
                         ->join('overtimes', 'overtimes.user_id', '=', 'users.id')
                         ->join('departments', 'departments.id', '=', 'employees.department_id')
                         ->join('branches', 'branches.id', '=', 'employees.branch_id')
                         ->select(['overtimes.*', 'employees.full_name as employee', 'departments.name as department', 'position_id as position', 'branches.name as branch'])
                         ->where('overtimes.status', $status)
                         ->whereRoleIs($role)
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

    public function overtimeRequestApproved(Request $request, $id)
    {
        $overtime = Overtime::find($id);

        $overtime->update([
            'status'    =>  'Approved',
            'remarks'   =>  ($request->input('remarks') == '') ? 'Overtime Approved!' : $request->input('remarks')
        ]);

        Mail::to(User::find($overtime->user_id)->email)->send(new ApproveOvertimeNotification());

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  Employee::where('user_id', $overtime->user_id)->first()->full_name. ' Overtime Request Approved'
        ]);

        return response()->json(['message'  =>  'Overtime Approved']);
    }

    public function overtimeRequestDisapproved(Request $request, $id)
    {
        $overtime = Overtime::find($id);

        $overtime->update([
            'status'    =>  'Disapproved',
            'remarks'   =>  ($request->input('remarks') == '') ? 'Overtime Approved!' : $request->input('remarks')
        ]);

        Mail::to(User::find($overtime->user_id)->email)->send(new DisapproveOvertimeNotification());

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  Employee::where('user_id', $overtime->user_id)->first()->full_name. ' Overtime Request Disapproved'
        ]);

        return response()->json(['message'  =>  'Overtime Disapproved']);
    }

    #Trip
    public function loadTripRequests($status, $role)
    {
        $trips = User::join('employees', 'employees.user_id', '=', 'users.id')
                     ->join('trips', 'trips.user_id', '=', 'users.id')
                     ->join('departments', 'departments.id', '=', 'employees.department_id')
                     ->join('branches', 'branches.id', '=', 'employees.branch_id')
                     ->select(['trips.*', 'employees.full_name as employee', 'departments.name as department', 'position_id as position', 'branches.name as branch'])
                     ->where('trips.status', $status)
                     ->whereRoleIs($role)
                     ->get();

        return datatables()->of($trips)
            ->addColumn('action', function($trip) {
                return '<button class="btn btn-default btn-xs" data="view" data-id="'.$trip->id.'">View</button>';
            })->toJson();
    }

    public function viewTripRequests($id)
    {
        $trip = Trip::find($id);

        return response()->json($trip);
    }

    public function TripRequestsAcknowledged(Request $request, $id)
    {
        $trip = Trip::find($id);
        $credit = Credit::where('user_id', $trip->user_id)->first();

        Credit::where('user_id', $trip->user_id)->update(['OB'  =>  $credit->OB + 1]);

        $trip->update([
            'status'    =>  'Acknowledged',
            'remarks'   =>  ($request->input('remarks') == '') ? 'Official Business Trip Acknowledged!' : $request->input('remarks')
        ]);

        Mail::to(User::find($trip->user_id)->email)->send(new ApproveTripNotification());

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  Employee::where('user_id', $trip->user_id)->first()->full_name. ' OB Request Acknowledged'
        ]);

        return response()->json(['message'  => 'Success']);
    }

    #Notice Slip
    public function loadNoticeSlipRequests($status, $role)
    {
        $notices = User::join('employees', 'employees.user_id', '=', 'users.id')
                       ->join('notices', 'notices.user_id', '=', 'users.id')
                       ->join('departments', 'departments.id', '=', 'employees.department_id')
                       ->join('branches', 'branches.id', '=', 'employees.branch_id')
                       ->select(['notices.*', 'employees.full_name as employee', 'departments.name as department', 'position_id as position', 'branches.name as branch'])
                       ->where('status', $status)
                       ->whereRoleIs($role)
                       ->get();

        return datatables()->of($notices)
            ->addColumn('action', function($notice) {
                return '<button class="btn btn-default btn-xs" data="view" data-id="'.$notice->id.'">View</button>';
            })->toJson();
    }

    public function viewNoticeSlipRequest($id)
    {
        $notice = Notice::find($id);

        return response()->json($notice);
    }

    public function noticeSlipAcknowledged($id)
    {
        Notice::find($id)->update([
            'status'    =>  'Acknowledged'
        ]);

        return response()->json(['message'  =>  'Notice Slip Acknowledged!']);
    }
}
