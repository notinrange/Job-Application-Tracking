<?php

namespace App\Mail;

use App\Models\Candidate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationActionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;

    public function __construct(Candidate $candidate)
    {
        $this->candidate = $candidate;
    }

    public function build()
    {
        $subject = $this->candidate->status === 'approved'
            ? 'Congratulations! Your application is approved'
            : 'Application Update: Your application status';

        return $this->subject($subject)
                    ->view('emails.application_action');
    }
}
