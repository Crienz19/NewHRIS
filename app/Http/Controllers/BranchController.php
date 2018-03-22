<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    public function loadBranch()
    {
        $branch = Branch::select(['id', 'name', 'created_at']);

        return datatables()->of($branch)
            ->addColumn('action', function($branch) {
                return '<button class="btn btn-success btn-xs" data="edit" data-id="'.$branch->id.'"><span class="glyphicon glyphicon-pencil"></span></button>
                        <button class="btn btn-danger btn-xs" data="remove" data-id="'.$branch->id.'"><span class="glyphicon glyphicon-trash"></span></button>';
            })->toJson();
    }

    public function storeBranch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch-name'      => 'required'
        ])->validate();

        Branch::create([
            'name'      => $request->input('branch-name')
        ]);

        return response()->json(['message' => 'Success']);
    }

    public function editBranch($id)
    {
        return response()->json(Branch::find($id));
    }

    public function updateBranch(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'branch-name'      => 'required'
        ])->validate();

        Branch::find($id)->update([
            'name'      => $request->input('branch-name')
        ]);

        return response()->json(['message' => 'Success']);
    }

    public function deleteBranch($id)
    {
        Branch::find($id)->delete();

        return response()->json(['message' => 'Success']);
    }
}
