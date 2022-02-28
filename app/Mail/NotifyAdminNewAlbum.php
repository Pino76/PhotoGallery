<?php

namespace App\Mail;

use App\Models\Album;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class NotifyAdminNewAlbum extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $album;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $admin, Album $album)
    {
        $this->admin = $admin;
        $this->album = $album;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.notifyAdminNewAlbum', [
            "admin"=>$this->admin,
            "album"=> $this->album
        ]);
    }
}
