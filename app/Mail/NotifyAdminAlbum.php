<?php

namespace App\Mail;

use App\Models\Album;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyAdminAlbum extends Mailable{
    use Queueable, SerializesModels;
    public $album;
    public $album_name;
    /**
     * @var $album
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Album $album ){
        $this->album = $album;
        $this->album_name = $album->album_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->view('mails.notifyadminnewalbum');
    }
}
