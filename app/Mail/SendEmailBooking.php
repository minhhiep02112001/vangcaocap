<?php

namespace App\Mail;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/** Gửi đồng bộ qua Mail::send() — không implement ShouldQueue. */
class SendEmailBooking extends Mailable
{

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(protected Booking $booking)
    {
        //
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    protected function formTypeLabel(): string
    {
        return match ($this->booking->form_type) {
            'combo_1' => 'Combo 1',
            'combo_2' => 'Combo 2',
            'combo_cart' => 'Giỏ hàng',
            'form_1' => 'Form 1',
            'form_2' => 'Form 2',
            'form_3' => 'Form 3',
            'form_4' => 'Form hộp quà',
            default => $this->booking->form_type ?? 'Đăng ký',
        };
    }

    public function envelope()
    {
        $formType = $this->formTypeLabel();

        return new Envelope(
            subject: "Booking mới từ {$this->booking->name} - {$formType}",
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $created_at = Carbon::parse($this->booking->created_at)->format('Y-m-d H:i');
        $data  = [
            'customerName' => $this->booking->name,
            'form_type' => $this->formTypeLabel(),
            'created_at' => $created_at,
            'phone' => $this->booking->phone,
            'address' => $this->booking->address,
            'email' => $this->booking->email,
            'form' => $this->booking->form_type,
            'note' => $this->booking->note,
            'count_combo' => $this->booking->count_combo,
        ];
        return new Content(
            view: 'emails.booking',
            with: $data
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
