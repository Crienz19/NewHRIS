<?php

namespace App\Console\Commands;

use App\Credit;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AnnualCreditReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Annually Reset Credits';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now()->format('Y-m-d');
        $employees = Employee::all();

        foreach ($employees as $employee) {
            if ($now == $employee->date_hired) {
                $d1 = new DateTime($now);
                $d2 = new DateTime($employee->date_hired);
                $diff = $d2->diff($d1);

                if ($diff->y > 1) {
                    $credits = Credit::where('user_id', $employee->user_id);

                    $credits->update([
                        'VL'            =>  $credits->first()->total_VL + 1,
                        'SL'            =>  $credits->first()->total_SL + 1,
                        'PTO'           =>  $credits->first()->VL + $credits->first()->SL,
                        'total_VL'      =>  $credits->first()->total_VL + 1,
                        'total_SL'      =>  $credits->first()->total_SL + 1,
                        'total_PTO'     =>  $credits->first()->VL + $credits->first()->SL
                    ]);
                } else {
                    $credits = Credit::where('user_id', $employee->user_id);

                    $credits->update([
                        'VL'            =>  6,
                        'SL'            =>  6,
                        'PTO'           =>  0,
                        'total_VL'      =>  6,
                        'total_SL'      =>  6,
                        'total_PTO'     =>  0
                    ]);
                }
            } else {
                echo 'False: ' . $employee->user_id . '<br>';
            }
        }
    }
}
