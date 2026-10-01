<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // ← para colas
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeUserMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public array $userData;
    public $tries = 3; // reintentos si falla

    public function __construct(array $userData)
    {
        $this->userData = $userData;
    }

    public function build(): self
    {
        return $this->subject('Nuevo registro: ' . $this->userData['name'])
                    ->view('emails.welcome')
                    ->with([
                        'nombre'        => $this->userData['name'],
                        'email_usuario' => $this->userData['email'],
                        'mensaje'       => $this->userData['message'] ?? null,
                    ]);
    }
}