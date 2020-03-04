<?php

namespace App\Listeners;

use App\Events\NewAlbumCreated;
use App\Mail\NotifyAdminAlbum;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminNewAlbum {
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){

    }

    /**
     * Handle the event.
     *
     * @param  NewAlbumCreated  $event
     * @return void
     */
    public function handle(NewAlbumCreated $event){
        $admins = User::where('role','admin')->get();
        foreach ($admins AS $admin){
            \Mail::to($admin->email)->send(new NotifyAdminAlbum($event->album));
        }
    }
}
