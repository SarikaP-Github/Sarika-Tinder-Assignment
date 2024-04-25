<?php

namespace App\Console\Commands;

use App\Mail\MostlikedUserMail;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendLikeEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'like:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'if some person got liked more than 50 people, it sends email to admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('mail_like_counter', 50)->get();

        if(count($users)) {
            foreach ($users as $key => $user) {
                try {
                    Mail::to('admin@mailinator.com')->send(new MostlikedUserMail($user));
                } catch (\Exception $e) {
                    Log::debug('Send EMAIL : ', ['error' => $e]);
                }
            }
        }
        
    }
}
