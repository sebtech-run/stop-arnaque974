<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // On va stocker les infos du formulaire ici

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Nouveau message de : ' . $this->data['name'])
            ->replyTo($this->data['email']) // Pour répondre directement à la personne
            ->view('emails.contact'); // La vue qui sert de modèle à l'email
    }
}
