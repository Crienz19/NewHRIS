<?php

namespace App\Http\Controllers\Auth;

use App\Credit;
use App\Employee;
use App\Helper;
use App\Mail\NewUserNotification;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:6|confirmed',
            'employee-id'   => 'required',
            'date-hired'    => 'required',
            'first-name'    => 'required',
            'middle-name'   => 'required',
            'last-name'     => 'required',
            'birthdate'     => 'required',
            'position'      => 'required',
            'department'    => 'required',
            'branch'        => 'required',
            'status'        => 'required',
            'contact-1'     => 'required',
            'contact-2'     => 'required',
            'pre-address'   => 'required',
            'perm-address'  => 'required',
            'skype'         => 'required',
            'tin'           => 'required',
            'sss'           => 'required',
            'hdmf'          => 'required',
            'phic'          => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
        ]);

        $details = User::where('email', $data['email'])->first();

        Employee::create([
            'user_id'           => $details->id,
            'employee_no'       => $data['employee-id'],
            'first_name'        => $data['first-name'],
            'middle_name'       => $data['middle-name'],
            'last_name'         => $data['last-name'],
            'full_name'         => $data['first-name'] .' '. $data['middle-name'][0] .'. '. $data['last-name'],
            'birthdate'         => $data['birthdate'],
            'date_hired'        => $data['date-hired'],
            'position_id'       => $data['position'],
            'department_id'     => $data['department'],
            'branch_id'         => $data['branch'],
            'civil_status'      => $data['status'],
            'contact_1'         => $data['contact-1'],
            'contact_2'         => $data['contact-2'],
            'present_address'   => $data['pre-address'],
            'permanent_address' => $data['perm-address'],
            'skype'             => $data['skype'],
            'tin'               => $data['tin'],
            'sss'               => $data['sss'],
            'hdmf'              => $data['hdmf'],
            'phic'              => $data['phic'],
            'profile_picture'   => 'default-user.png',
        ]);

        Credit::create([
            'user_id'           => $details->id,
            'VL'                => Helper::dateCount($data['date-hired']),
            'SL'                => Helper::dateCount($data['date-hired']),
            'OT'                => 0,
            'OB'                => 0,
            'PTO'               => Helper::dateCount($data['date-hired']),
            'unused_VL'         => Helper::dateCount($data['date-hired']),
            'unused_SL'         => Helper::dateCount($data['date-hired']),
            'total_PTO'         => Helper::dateCount($data['date-hired']),
            'total_VL'          => Helper::dateCount($data['date-hired']),
            'total_SL'          => Helper::dateCount($data['date-hired'])
        ]);

        $details->attachRole('user');

        Mail::to(env('ADMIN_EMAIL'))->send(new NewUserNotification(Employee::where('user_id', $details->id)->first()));

        return $user;
    }
}
