<?php

namespace App\Http\Controllers;

use App\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoticeController extends Controller
{
    public function loadNotice()
    {
        $notice = Notice::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return datatables()->of($notice)
            ->addColumn('action', function($notice) {
                return '<button class="btn btn-success btn-xs" data="edit" data-id="'.$notice->id.'"><span class="glyphicon glyphicon-pencil"></span></button>
                        <button class="btn btn-danger btn-xs" data="remove" data-id="'.$notice->id.'"><span class="glyphicon glyphicon-trash"></span></button>';
            })->toJson();
    }

    public function storeNotice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'notice-nature'         =>  'required',
            'notice-date'           =>  'required',
            'notice-In'             =>  'required',
            'notice-explanation'    =>  'required'
        ])->validate();

        Notice::create([
            'user_id'       =>  Auth::user()->id,
            'nature'        =>  $request->input('notice-nature'),
            'date'          =>  $request->input('notice-date'),
            'time_in'       =>  date('h:i A', strtotime($request->input('notice-In'))),
            'time_out'      =>  date('h:i A', strtotime($request->input('notice-Out'))),
            'explanation'   =>  $request->input('notice-explanation'),
            'status'        =>  'Pending',
            'remarks'       =>  ''
        ]);

        return response()->json(['message'  =>  'Notice Stored']);
    }

    public function editNotice($id)
    {
        $notice = Notice::find($id);

        $data = array(
            'nature'        =>  $notice->nature,
            'date'          =>  $notice->date,
            'time_in'       =>  date('H:i', strtotime($notice->time_in)),
            'time_out'      =>  date('H:i', strtotime($notice->time_out)),
            'explanation'   =>  $notice->explanation
        );

        return response()->json($data);
    }

    public function updateNotice(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'notice-nature'         =>  'required',
            'notice-date'           =>  'required',
            'notice-In'             =>  'required',
            'notice-explanation'    =>  'required'
        ])->validate();

        Notice::find($id)->update([
            'user_id'       =>  Auth::user()->id,
            'nature'        =>  $request->input('notice-nature'),
            'date'          =>  $request->input('notice-date'),
            'time_in'       =>  date('h:i A', strtotime($request->input('notice-In'))),
            'time_out'      =>  date('h:i A', strtotime($request->input('notice-Out'))),
            'explanation'   =>  $request->input('notice-explanation')
        ]);

        return response()->json(['message'  =>  'Notice Updated']);
    }

    public function deleteNotice($id)
    {
        Notice::find($id)->delete();

        return response()->json(['message'  =>  'Notice Deleted']);
    }
}
