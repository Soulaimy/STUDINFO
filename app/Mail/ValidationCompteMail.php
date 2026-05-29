<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ValidationCompteMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    /**
     * Crée une nouvelle instance du mail.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Définit l’enveloppe du message.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre compte a été validé',
        );
    }

    /**
     * Définit le contenu du message.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.validation_compte',
            with: [
                'user' => $this->user,
            ],
        );
    }

    /**
     * Pièces jointes éventuelles (aucune ici).
     */
    public function attachments(): array
    {
        return [];
    }
}