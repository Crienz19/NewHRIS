<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use App\Log;
use App\Mail\DeleteOvertimeNotification;
use App\Mail\FileOvertimeNotification;
use App\Mail\UpdateOvertimeNotification;
use App\Overtime;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OvertimeController extends Controller
{
    public function loadOvertime()
    {
        $overtimes = Overtime::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return datatables()->of($overtimes)
                ->addColumn('action', function($overtime){
                    if ($overtime->status != 'Pending') {
                        return '<button class="btn btn-default btn-xs" data="view" data-id="'.$overtime->id.'">View</button>';
                    } else {
                        return '<button class="btn btn-success btn-xs" data="edit" data-id="'.$overtime->id.'"><span class="glyphicon glyphicon-pencil"></span></button>
                                <button class="btn btn-danger btn-xs" data="remove" data-id="'.$overtime->id.'"><span class="glyphicon glyphicon-trash"></span></button>';
                    }
                })->toJson();
    }

    public function storeOvertime(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ot-date'       =>  'required',
            'ot-from'       =>  'required',
            'ot-to'         =>  'required',
            'ot-reason'     =>  'required'
        ])->validate();

        $data = [
            'user_id'       =>  Auth::user()->id,
            'fullname'      =>  Employee::where('user_id', Auth::user()->id)->first()->full_name,
            'date'          =>  $request->input('ot-date'),
            'from'          =>  date('h:i A', strtotime($request->input('ot-from'))),
            'to'            =>  date('h:i A', strtotime($request->input('ot-to'))),
            'reason'        =>  $request->input('ot-reason'),
            'status'        =>  'Pending',
            'remarks'       =>  ''
        ];

        $dept_id = User::join('employees', 'employees.user_id', '=', 'users.id')->select(['employees.department_id'])->where('users.id', Auth::user()->id)->first()->department_id;
        $dept_head = Department::join('users', 'departments.supervisor', '=', 'users.id')
                                ->where('departments.id', $dept_id)
                                ->select(['users.email'])
                                ->first()->email;

        Mail::to($dept_head)->send(new FileOvertimeNotification($data));

        Overtime::create($data);
        Log::create([
            'user_id'   =>  $data['user_id'],
            'activity'  =>  'File Overtime'
        ]);

        return response()->json(['message' => 'Success']);
    }

    public function editOvertime($id)
    {
        $overtime = Overtime::find($id);

        $data = array(
            'date'      =>  $overtime->date,
            'from'      =>  date('H:i', strtotime($overtime->from)),
            'to'        =>  date('H:i', strtotime($overtime->to)),
            'reason'    =>  $overtime->reason,
            'remarks'   =>  $overtime->remarks
        );

        return response()->json($data);
    }

    public function updateOvertime(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ot-date'       =>  'required',
            'ot-from'       =>  'required',
            'ot-to'         =>  'required',
            'ot-reason'     =>  'required'
        ])->validate();

        $data = [
            'date'          =>  $request->input('ot-date'),
            'from'          =>  date('h:i A', strtotime($request->input('ot-from'))),
            'to'            =>  date('h:i A', strtotime($request->input('ot-to'))),
            'reason'        =>  $request->input('ot-reason'),
            'remarks'       =>  ''
        ];

        Overtime::find($id)->update($data);

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  'Update Overtime'
        ]);

        return response()->json(['message' => 'Success']);
    }

    public function deleteOvertime($id)
    {
        Overtime::find($id)->delete();

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  'Delete Overtime'
        ]);

        return response()->json(['message' => 'Success']);
    }
}
