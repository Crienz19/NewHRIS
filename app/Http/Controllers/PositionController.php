<?php

namespace App\Http\Controllers;

use App\Department;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    public function loadPosition()
    {
        $position = Position::join('departments', 'departments.id', '=', 'positions.department_id')
            ->select(['positions.id', 'positions.name', 'departments.name as department', 'positions.description', 'positions.created_at']);

        return datatables()->of($position)
            ->addColumn('action', function($position) {
                return '<button class="btn btn-success btn-xs" data="edit" data-id="'.$position->id.'"><span class="glyphicon glyphicon-pencil"></span></button>
                       <button class="btn btn-danger btn-xs" data="remove" data-id="'.$position->id.'"><span class="glyphicon glyphicon-trash"></span></button>';
            })
            ->toJson();
    }

    public function storePosition(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'position-name'     => 'required',
            'position-description'    => 'required',
            'position-dept'     => 'required'
        ])->validate();

        Position::create([
            'department_id'  => $request->input('position-dept'),
            'name'           => $request->input('position-name'),
            'description'    => $request->input('position-description')
        ]);

        return response()->json(['message' => 'Success']);
    }

    public function editPosition($id)
    {
        $position = Position::join('departments', 'departments.id', '=', 'positions.department_id')
            ->select(['positions.id', 'positions.name', 'departments.name as department', 'positions.description', 'positions.created_at'])
            ->where('positions.id', $id)
            ->first();

        return response()->json($position);
    }

    public function updatePosition(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'position-name'     => 'required',
            'position-description'    => 'required',
            'position-dept'     => 'required'
        ])->validate();

        Position::find($id)->update([
            'department_id'  => $request->input('position-dept'),
            'name'           => $request->input('position-name'),
            'description'    => $request->input('position-description')
        ]);

        return response()->json(['message' => 'Success']);
    }

    public function deletePosition($id)
    {
        Position::find($id)->delete();

        return response()->json(['message' => 'Success']);
    }
}
