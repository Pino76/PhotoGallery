<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class TestEmail extends Mailable{

    use Queueable, SerializesModels;
    public $user;

    public function __construct(User $user){
        $this->user = $user;
    }


    public function build(){
        $messaggio = "La email è stata inviata correttamente";
        return $this->view('mails.testemail', ["messaggio" => $messaggio])
            ->with(['username'=>'Pinuccio'])
            ->to('pinuccio@libero.it')->from("test@studiotest.com");
    }
}
