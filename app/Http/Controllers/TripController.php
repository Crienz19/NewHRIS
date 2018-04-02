<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Log;
use App\Mail\FileTripNotification;
use App\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TripController extends Controller
{
    public function loadTrip()
    {
        $trips = Trip::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return datatables()->of($trips)
            ->addColumn('action', function($trip) {
                if ($trip->status != 'Pending') {
                    return 'Not Applicable';
                } else {
                    return '<button class="btn btn-success btn-xs" data="edit" data-id="'.$trip->id.'"><span class="glyphicon glyphicon-pencil"></span></button>
                        <button class="btn btn-danger btn-xs" data="remove" data-id="'.$trip->id.'"><span class="glyphicon glyphicon-trash"></span></button>';
                }
            })->toJson();
    }

    public function storeTrip(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date-from'     => 'required',
            'date-to'       => 'required',
            'time-in'       => 'required',
            'time-out'      => 'required',
            'dest-from'     => 'required',
            'dest-to'       => 'required',
            'purpose'       => 'required'
        ])->validate();

        $data = [
            'user_id'           => Auth::user()->id,
            'fullname'          => Employee::where('user_id', Auth::user()->id)->first()->full_name,
            'date_from'         => $request->input('date-from'),
            'date_to'           => $request->input('date-to'),
            'time_in'           => date('h:i A', strtotime($request->input('time-in'))),
            'time_out'          => date('h:i A', strtotime($request->input('time-out'))),
            'destination_from'  => $request->input('dest-from'),
            'destination_to'   => $request->input('dest-to'),
            'purpose'           => $request->input('purpose'),
            'status'            => 'Pending',
            'remarks'           => ''
        ];

        Trip::create($data);

        Log::create([
            'user_id'   =>  $data['user_id'],
            'activity'  =>  'Filed Official Business Trip'
        ]);

        Mail::to(env('HR_EMAIL'))->send(new FileTripNotification($data));

        return response()->json(['message' => 'Success']);
    }

    public function editTrip($id)
    {
        $trip = Trip::find($id);

        $data = array(
            'date_from'         => $trip->date_from,
            'date_to'           => $trip->date_to,
            'time_in'           => date('H:i', strtotime($trip->time_in)),
            'time_out'          => date('H:i', strtotime($trip->time_out)),
            'destination_from'  => $trip->destination_from,
            'destination_to'    => $trip->destination_to,
            'purpose'           => $trip->purpose,
        );

        return response()->json($data);
    }

    public function updateTrip(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date-from'     => 'required',
            'date-to'       => 'required',
            'time-in'       => 'required',
            'time-out'      => 'required',
            'dest-from'     => 'required',
            'dest-to'       => 'required',
            'purpose'       => 'required'
        ])->validate();

        $data = [
            'date_from'         => $request->input('date-from'),
            'date_to'           => $request->input('date-to'),
            'time_in'           => date('h:i A', strtotime($request->input('time-in'))),
            'time_out'          => date('h:i A', strtotime($request->input('time-out'))),
            'destination_from'  => $request->input('dest-from'),
            'destination_to'    => $request->input('dest-to'),
            'purpose'           => $request->input('purpose')
        ];

        Trip::find($id)->update($data);

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  'Update Official Business Trip'
        ]);

        return response()->json(['message' => 'Success']);
    }

    public function deleteTrip($id)
    {
        Trip::find($id)->delete();

        Log::create([
            'user_id'   =>  Auth::user()->id,
            'activity'  =>  'Delete Official Business Trip'
        ]);

        return response()->json(['message' => 'Success']);
    }
}
