<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $name;
    public $identityNumber;
    public $verificationCode;
    public function __construct($type, $name, $identityNumber, $verificationCode)
    {
        $this->type = $type;
        $this->name = $name;
        $this->identityNumber = $identityNumber;
        $this->verificationCode = $verificationCode;
    }

    public function build()
    {
        return $this->subject('Verifikasi Pendaftaran Akun ' . $this->type)
                    ->view('mail.registration', [
                        'type' => $this->type,
                        'name' => $this->name,
                        'identityNumber' => $this->identityNumber,
                        'verificationCode' => $this->verificationCode
                    ]);
    }
}
