<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:send-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail to all users by this command';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
    $usersMail= User::select('email')->get();
    $emails=[];
    foreach($usersMail as $mail){
        $emails= $mail['email'];
    }

    Mail::send('emails.welcome',[],function($message) use ($emails){
$message->to($emails)->subject('This is test mail for cron');
    });
    }
}
