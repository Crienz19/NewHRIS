<?php

namespace App\Http\Controllers;

use App\Credit;
use App\Employee;
use App\Leave;
use App\Department;
use App\Log;
use App\Mail\DeleteLeaveNotification;
use App\Mail\FileLeaveNotification;
use App\Mail\UpdateLeaveNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{
    public function loadLeave()
    {
        $leaves = Leave::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return datatables()->of($leaves)
            ->addColumn('action', function($leave) {
                if ($leave->final_approval != 'Pending') {
                    return 'Not Applicable';
                } else {
                    return '<button class="btn btn-success btn-xs" data="edit" data-id="'.$leave->id.'"><span class="glyphicon glyphicon-pencil"></span></button>
                        <button class="btn btn-danger btn-xs" data="remove" data-id="'.$leave->id.'"><span class="glyphicon glyphicon-trash"></span></button>';
                }
            })->toJson();
    }

    public function storeLeave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leave-type'    =>  'required',
            'leave-pay'     =>  'required',
            'leave-reason'  =>  'required',
            'leave-from'    =>  'required',
            'leave-to'      =>  'required'
        ])->validate();

        $data = [
            'user_id'                    =>  Auth::user()->id,
            'fullname'                   =>  Employee::where('user_id', Auth::user()->id)->first()->full_name,
            'type'                       =>  $request->input('leave-type'),
            'pay_type'                   =>  $request->input('leave-pay'),
            'reason'                     =>  $request->input('leave-reason'),
            'from'                       =>  $request->input('leave-from'),
            'to'                         =>  $request->input('leave-to'),
            'time_from'                  =>  ($request->input('leave-type') == 'VL-Half' || $request->input('leave-type') == 'PTO-Half') ? date('h:i A', strtotime($request->input('time-from'))) : '',
            'time_to'                    =>  ($request->input('leave-type') == 'VL-Half' || $request->input('leave-type') == 'PTO-Half') ? date('h:i A', strtotime($request->input('time-to'))) : '',
            'remarks'                    =>  '',
            'recommending_approval'      =>  (Auth::user()->hasRole('supervisor') || Auth::user()->hasRole('hr')) ? 'Approved' : 'Pending',
            'final_approval'             =>  'Pending',
            'count'                      =>  (date_diff(new \DateTime($request->input('leave-from')), new \DateTime($request->input('leave-to')))->format('%a') == 0) ? '1'  : date_diff(new \DateTime($request->input('leave-from')), new \DateTime($request->input('leave-to')))->format('%a'),
        ];

        $credit = Credit::where('user_id', Auth::user()->id)->first();

        if ($request->input('leave-type') == 'VL' && $request->input('leave-pay') == 'With Pay' && $credit->VL == 0) {
            return response()->json(['VL Credits Depleted!']);
        } elseif ($request->input('leave-type') == 'VL-Half' && $request->input('leave-pay') == 'With Pay' && $credit->VL == 0) {
            return response()->json(['VL Credits Depleted!']);
        } elseif ($request->input('leave-type') == 'SL' && $request->input('leave-pay') == 'With Pay' && $credit->SL == 0) {
            return response()->json(['SL Credits Depleted']);
        } elseif ($request->input('leave-type') == 'PTO' && $request->input('leave-pay') == 'With Pay' && $credit->PTO == 0) {
            return response()->json(['PTO Credits Depleted']);
        } elseif ($request->input('leave-type') == 'PTO-Half' && $request->input('leave-pay') == 'With Pay' && $credit->PTO == 0) {
            return response()->json(['PTO Credits Depleted!']);
        } else {
            Leave::create($data);

            $dept_id = User::join('employees', 'employees.user_id', '=', 'users.id')->select(['employees.department_id'])->where('users.id', Auth::user()->id)->first()->department_id;
            $dept_head = Department::join('users', 'departments.supervisor', '=', 'users.id')
                ->where('departments.id', $dept_id)
                ->select(['users.email'])
                ->first()->email;

            if (Auth::user()->hasRole('user')) {
                Log::create([
                    'user_id'   =>  $data['user_id'],
                    'activity'  =>  'Filed ' . $data['type'] . ' request'
                ]);

                Mail::to($dept_head)->send(new FileLeaveNotification($data));
                Mail::to(env('ADMIN_EMAIL'))->send(new FileLeaveNotification($data));
                Mail::to(env('HR_EMAIL'))->send(new FileLeaveNotification($data));
            } elseif (Auth::user()->hasRole('supervisor')) {
                Log::create([
                    'user_id'   =>  $data['user_id'],
                    'activity'  =>  'Filed' . $data['type']
                ]);

                Mail::to(env('HR_EMAIL'))->send(new FileLeaveNotification($data));
                Mail::to(env('ADMIN_EMAIL'))->send(new FileLeaveNotification($data));
            } elseif (Auth::user()->hasRole('hr'))  {
                Log::create([
                    'user_id'   =>  $data['user_id'],
                    'activity'  =>  'Filed' . $data['type']
                ]);

                Mail::to(env('ADMIN_EMAIL'))->send(new FileLeaveNotification($data));
            }

            return response()->json(['message' => 'Success']);
        }
    }

    public function editLeave($id)
    {
        $leave = Leave::find($id);

        $data = array(
            'type'      => $leave->type,
            'pay_type'  => $leave->pay_type,
            'reason'    => $leave->reason,
            'from'      => $leave->from,
            'to'        => $leave->to,
            'time_from' => date('H:i', strtotime($leave->time_from)),
            'time_to'   => date('H:i', strtotime($leave->time_to))
        );

        return response()->json($data);
    }

    public function updateLeave(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'leave-type'    =>  'required',
            'leave-pay'     =>  'required',
            'leave-reason'  =>  'required',
            'leave-from'    =>  'required',
            'leave-to'      =>  'required'
        ])->validate();

        $data = [
            'type'                       =>  $request->input('leave-type'),
            'pay_type'                   =>  $request->input('leave-pay'),
            'reason'                     =>  $request->input('leave-reason'),
            'from'                       =>  $request->input('leave-from'),
            'to'                         =>  $request->input('leave-to'),
            'time_from'                  =>  ($request->input('leave-type') == 'VL-Half' || $request->input('leave-type') == 'PTO-Half') ? date('h:i A', strtotime($request->input('time-from'))) : '',
            'time_to'                    =>  ($request->input('leave-type') == 'VL-Half' || $request->input('leave-type') == 'PTO-Half') ? date('h:i A', strtotime($request->input('time-to'))) : '',
            'remarks'                    =>  '',
            'recommending_approval'      =>  (Auth::user()->hasRole('supervisor')) ? 'Approved' : 'Pending',
            'final_approval'             =>  'Pending',
            'count'                      =>  (date_diff(new \DateTime($request->input('leave-from')), new \DateTime($request->input('leave-to')))->format('%a') == 0) ? '1'  : date_diff(new \DateTime($request->input('leave-from')), new \DateTime($request->input('leave-to')))->format('%a'),
        ];

        Leave::find($id)->update($data);

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  'Update Leave Request'
        ]);

        return response()->json(['message' => 'Success']);
    }

    public function deleteLeave($id)
    {
        Leave::find($id)->delete();

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  'Delete Leave Request'
        ]);

        return response()->json(['message' => 'Success']);
    }
}
