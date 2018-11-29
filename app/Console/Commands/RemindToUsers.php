<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Jobs\SendReminderEmail;
use Carbon\Carbon;

class RemindToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email remind to user';

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
      $data = DB::table('users')
        ->join('training_plans', 'users.id', '=', 'training_plans.user_id')
        ->get();
      $day_o_week_today = Carbon::now()->dayOfWeek;
      foreach ($data as $key => $value) {
        if(in_array($day_o_week_today, json_decode($value->weekday))) {
          $time = explode(":", $value->time);
          $y = Carbon::now()->year;
          $m = Carbon::now()->month;
          $d = Carbon::now()->day;
          $when = Carbon::create($y, $m, $d, $time[0], $time[1], 0);
          if(isset($value->email)) {
            $emailJob = (new SendReminderEmail($value->email))->delay($when);
            dispatch($emailJob);
          }
        } else {
          return;
        };
      }
    }
  }
