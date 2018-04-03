<?php

namespace App\Http\Controllers;

use App\Credit;
use App\Employee;
use App\Helper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function loadEmployee()
    {
        $employees = User::join('employees', 'employees.user_id', '=', 'users.id')
                         ->join('departments', 'departments.id', '=', 'employees.department_id')
                         ->join('branches', 'branches.id', '=', 'employees.branch_id')
                         ->select(['users.id','employees.full_name','position_id as position','departments.name as department', 'users.email', 'branches.name as branch'])
                         ->get();

        return datatables()->of($employees)
            ->addColumn('action', function($employee) {
                if (Auth()->user()->hasRole('superadmin') == true) {
                    return '<button class="btn btn-default btn-xs" data="view" data-id="'.$employee->id.'"><span class="glyphicon glyphicon-eye-open"></span></button>
                        <button class="btn btn-primary btn-xs" data="assign" data-id="'.$employee->id.'"><span class="glyphicon glyphicon-check"></span></button>
                        <button class="btn btn-warning btn-xs" data="reset" data-id="'.$employee->id.'"><span class="glyphicon glyphicon-refresh"></span></button>';
                } else {
                    return '<button class="btn btn-default btn-xs" data="view" data-id="'.$employee->id.'"><span class="glyphicon glyphicon-eye-open"></span></button>';
                }
            })->toJson();
    }

    public function showEmployee($id)
    {
        $employee = User::join('employees', 'employees.user_id', '=', 'users.id')
                        ->join('credits', 'credits.user_id', '=', 'users.id')
                        ->join('positions', 'positions.id', '=', 'employees.position_id')
                        ->join('departments', 'departments.id', '=', 'employees.department_id')
                        ->join('branches', 'branches.id', '=', 'employees.branch_id')
                        ->where('employees.user_id', $id)
                        ->select(['employees.*', 'credits.VL', 'credits.SL', 'credits.OT', 'credits.OB', 'credits.PTO', 'credits.unused_VL', 'credits.unused_SL', 'credits.total_PTO', 'credits.total_VL', 'credits.total_SL', 'positions.name as position', 'departments.name as department', 'branches.name as branch', 'users.email'])
                        ->first();

        return response()->json($employee);
    }

    public function showEmployeeProfile()
    {
        $employee = User::join('employees', 'employees.user_id', '=', 'users.id')
                        ->join('credits', 'credits.user_id', '=', 'users.id')
                        ->join('positions', 'positions.id', '=', 'employees.position_id')
                        ->join('departments', 'departments.id', '=', 'employees.department_id')
                        ->join('branches', 'branches.id', '=', 'employees.branch_id')
                        ->select(['employees.*', 'credits.VL', 'credits.SL', 'credits.OT', 'credits.OB', 'credits.PTO', 'credits.unused_VL', 'credits.unused_SL', 'credits.total_PTO', 'credits.total_VL', 'credits.total_SL', 'positions.name as position', 'departments.name as department', 'branches.name as branch', 'users.email'])
                        ->where('employees.user_id', Auth::user()->id)
                        ->first();

        return response()->json($employee);
    }

    public function uploadPhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo'     =>  'required'
        ])->validate();

        if ($request->hasFile('photo')){
            $destinationPath = 'assets/profilePictures';
            $file = $request->file('photo');
            $extenstion = $file->getClientOriginalExtension();
            $filename = 'profile-'.rand(1,9999).'.'.$extenstion;
            File::delete($destinationPath."/".Auth::user()->profile_picture);
            $file->move($destinationPath, $filename);
        }

        $data = [
            'profile_picture'   =>  $filename
        ];

        Employee::where('user_id', Auth::user()->id)->update($data);

        return response()->json(['message'  =>  'User Photo Uploaded']);
    }

    public function resetPassword($id)
    {
        $data = [
            'password'  =>  Hash::make('z1ptr4v3l')
        ];

        User::find($id)->update($data);

        return response()->json(['message'  =>  'Password Resetted']);
    }

    public function updateEmpNumber(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
            'employee_no'   =>  $request->input('emp-id-field')
        ]);

        return response()->json(['message'  =>  'Employee Number Updated!']);
    }

    public function updateFullName(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
            'first_name'    =>  $request->input('firstname-field'),
            'middle_name'   =>  $request->input('middlename-field'),
            'last_name'     =>  $request->input('lastname-field'),
            'full_name'     =>  $request->input('firstname-field') . ' ' . $request->input('middlename-field')[0] . '. ' .$request->input('lastname-field')
        ]);

        return response()->json(['message'  =>  'Full Name Updated!']);
    }

    public function updateBirthdate(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
            'birthdate'     =>  $request->input('birthdate-field')
        ]);

        return response()->json(['message'  =>  'Birthdate Updated!']);
    }

    public function updateDepartment(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
            'department_id' =>  $request->input('department-field'),
            'position_id'   =>  $request->input('position-field')
        ]);

        return response()->json(['message'  =>  'Department Updated!']);
    }

    public function updateBranch(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
           'branch_id'      =>  $request->input('branch-field')
        ]);

        return response()->json(['message'  =>  'Branch Updated!']);
    }

    public function updateStatus(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
           'civil_status'   =>  $request->input('status-field')
        ]);

        return response()->json(['message'  =>  'Civil Status Updated']);
    }

    public function updateContact1(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
            'contact_1'     =>  $request->input('contact-field-1')
        ]);

        return response()->json(['message'  =>  'Contact Updated']);
    }

    public function updateContact2(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
            'contact_2'     =>  $request->input('contact-field-2')
        ]);

        return response()->json(['message'  =>  'Contact Updated']);
    }

    public function updateDatehired(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
           'date_hired'     =>  $request->input('date-hired-field')
        ]);

        $credit = Credit::where('user_id', $id)->first();

        Credit::where('user_id', $id)->update([
            'PTO'               => $credit->VL + $credit->SL,
            'unused_VL'         => Helper::dateCount($request->input('date-hired-field')),
            'unused_SL'         => Helper::dateCount($request->input('date-hired-field')),
            'total_PTO'         => $credit->VL + $credit->SL,
            'total_VL'          => Helper::dateCount($request->input('date-hired-field')),
            'total_SL'          => Helper::dateCount($request->input('date-hired-field'))
        ]);

        return response()->json(['message'  =>  'Date Hired Field']);
    }

    public function updatePreAddress(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
            'present_address'   =>  $request->input('pre-address-field')
        ]);

        return response()->json(['message'  =>  'Present Address Updated']);
    }

    public function updatePerAddress(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
            'permanent_address' =>  $request->input('perm-address-field')
        ]);

        return response()->json(['message'  =>  'Permanent Address Updated']);
    }

    public function updateSkype(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
           'skype'  =>  $request->input('skype-field')
        ]);

        return response()->json(['message'  =>  'Skype Updated']);
    }

    public function updateEmail(Request $request, $id)
    {
        User::find($id)->update([
            'email' =>  $request->input('email-field')
        ]);

        return response()->json(['message'  =>  'Email Updated!']);
    }

    public function updateTIN(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
            'tin'   =>  $request->input('tin-field')
        ]);

        return response()->json(['message'  =>  'TIN Updated']);
    }

    public function updateSSS(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
            'sss'   =>  $request->input('sss-field')
        ]);

        return response()->json(['message'  =>  'SSS Updated!']);
    }

    public function updateHDMF(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
            'hdmf'  =>  $request->input('hdmf-field')
        ]);

        return response()->json(['message'  =>  'HDMF Updated!']);
    }

    public function updatePHIC(Request $request, $id)
    {
        Employee::where('user_id', $id)->update([
            'phic'  =>  $request->input('phic-field')
        ]);

        return response()->json(['message'  =>  'PHIC Updated!']);
    }
}
