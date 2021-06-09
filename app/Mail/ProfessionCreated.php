<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use phpDocumentor\Reflection\Types\Collection;

class ProfessionCreated extends Mailable
{
    use Queueable, SerializesModels;

    private string $user;
    private array $beforeProfessions;
    private array $updatedProfessions;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $user, array $beforeProfessions, array $updatedProfessions)
    {
        $this->user = $user;
        $this->beforeProfessions = $beforeProfessions;
        $this->updatedProfessions = $updatedProfessions;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.professions')
            ->with('user', $this->user)
            ->with('beforeProfessions', $this->beforeProfessions)
            ->with('updatedProfessions', $this->updatedProfessions);
    }
}
