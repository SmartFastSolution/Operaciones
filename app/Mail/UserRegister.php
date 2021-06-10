<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegister extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    // public $clave;
   
    
    public function __construct($users)
    {
        $this->user = $users;
        // $this->clave = $clave;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Bienvenido a Operaciones')
        ->view('mails.userregister1') 
                ->with([
                        'name'     => $this->user['name'],
                        'apellido' => $this->user['apellido'],
                        'email'    => $this->user['email'],
                        'clave'    => $this->user['password'],
                    ]);
    }
}
