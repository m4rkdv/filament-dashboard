<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\HolidayPending;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user=User::find(1);
        $data= array(
            'day'=>' day test',
            'name'=> User::find(1)->name,
            'email'=> User::find(1)->email,
        );
        Mail::to($user)->send(new HolidayPending($data));
    }
}
