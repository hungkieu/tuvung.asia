<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReminderStudy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email to remind users about studying English';

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
        //
    }
}
