<?php

namespace App\Mail;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public LeaveRequest $leave){}

    public function envelope(): Envelope
    {
        $subject = $this->leave->status == 'Approved'
            ? 'Leave Request Approved ✅'
            : 'Leave Request Rejected ❌';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.leave-status');
    }
}