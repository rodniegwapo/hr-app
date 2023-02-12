<?php

namespace App\Listeners;

use App\Events\TimeOffProcessed;
use App\Mail\UserRequestTimeOffMessage;
use App\Models\TimeOff;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendRequestTimeOffNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TimeOffProcessed  $event
     * @return void
     */
    public function handle(TimeOffProcessed $event)
    {
        //
        // $manager = User::where()
        $time_off = TimeOff::where('id', $event->time_off->id)->with(['user', 'type'])->first();
        $manager = User::where('id', $time_off->user->manager_id)->first();

        Mail::to($manager->email)->send(new UserRequestTimeOffMessage($time_off));
    }
}
