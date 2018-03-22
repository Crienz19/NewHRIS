<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function loadDepartment()
    {
        $department = Department::leftjoin('employees','employees.user_id', '=', 'departments.supervisor')
                                ->select(['departments.*', 'employees.full_name as supervisor'])
                                ->get();

        return datatables()->of($department)
            ->addColumn('action', function($department) {
                return '<button class="btn btn-primary btn-xs" data="assign" data-id="'.$department->id.'"><span class="glyphicon glyphicon-plus"></span></button>&nbsp;
                        <button class="btn btn-success btn-xs" data="edit" data-id="'.$department->id.'"><span class="glyphicon glyphicon-pencil"></span></button>&nbsp;
                        <button class="btn btn-danger btn-xs" data="remove" data-id="'.$department->id.'"><span class="glyphicon glyphicon-trash"></span></button>';
            })->toJson();
    }

    public function storeDepartment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department-name'      => 'required',
            'department-value'     => 'required'
        ])->validate();

        Department::create([
            'name'          => $request->input('department-name'),
            'value'         => $request->input('department-value'),
            'supervisor'    => ''
        ]);

        return response()->json(['message' => 'Success']);
    }

    public function editDepartment($id)
    {
        return response()->json(Department::find($id));
    }

    public function updateDepartment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'department-name'      => 'required',
            'department-value'     => 'required'
        ])->validate();

        Department::find($id)->update([
            'name'          => $request->input('department-name'),
            'value'         => $request->input('department-value')
        ]);

        return response()->json(['message' => 'Success']);
    }

    public function deleteDepartment($id)
    {
        Department::find($id)->delete();

        return response()->json(['message' => 'Success']);
    }
}
