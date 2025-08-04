<?php

namespace App\Mail;

use App\Models\booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingStatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $oldStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(booking $booking, $oldStatus)
    {
        $this->booking = $booking;
        $this->oldStatus = $oldStatus;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusText = ucfirst(str_replace('_', ' ', $this->booking->status));
        return new Envelope(
            subject: 'Booking Status Updated - ' . $statusText,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-status-update',
            with: [
                'booking' => $this->booking,
                'oldStatus' => $this->oldStatus,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
} 