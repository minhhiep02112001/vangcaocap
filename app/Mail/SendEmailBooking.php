<?php

namespace App\Mail;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
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

        $replyTo = [];
        $salesInbox = config('data.email_receiver');
        if (is_string($salesInbox) && filter_var($salesInbox, FILTER_VALIDATE_EMAIL)) {
            $replyTo[] = new Address($salesInbox, 'The Best Wine');
        }
        if (! empty($this->booking->email) && filter_var($this->booking->email, FILTER_VALIDATE_EMAIL)) {
            $replyTo[] = new Address($this->booking->email, (string) $this->booking->name);
        } 
        $subjectTag = match ($this->booking->form_type) {
            'combo_1', 'form_1' => '[COMBO 1] ',
            'combo_2', 'form_2' => '[COMBO 2] ',
            default => '',
        };

        return new Envelope(
            from: new Address(
                (string) config('mail.from.address', config('mail.mailers.smtp.username')),
                (string) config('mail.from.name', 'The Best Wine')
            ),
            replyTo: $replyTo,
            subject: "{$subjectTag}Đơn mới {$formType} — {$this->booking->name} — {$this->booking->phone}",
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
  protected function splitBookingNote(?string $note): array
    {
        if ($note === null || $note === '') {
            return ['', ''];
        }
        if (preg_match('/^(.*)\n\nGhi chú khách hàng:\s*(.*)$/s', $note, $matches)) {
            return [trim($matches[1]), trim($matches[2])];
        }

        return [$note, ''];
    }

    public function content()
    {
        $created_at = Carbon::parse($this->booking->created_at)->format('Y-m-d H:i');
        [$orderDetail, $customerNote] = $this->splitBookingNote($this->booking->note);

        $comboKey = match ($this->booking->form_type) {
            'form_1' => 'combo_1',
            'form_2' => 'combo_2',
            default => $this->booking->form_type,
        };

        if ($orderDetail === '' && in_array($comboKey, ['combo_1', 'combo_2'], true)) {
            $comboName = config("data.combo.{$comboKey}.name", $comboKey);
            $qty = (int) ($this->booking->count_combo ?? 1);
            $price = (int) config("data.combo.{$comboKey}.price", 0);
            $priceFormatted = number_format($price, 0, ',', '.') . ' VNĐ';
            $orderDetail = "{$comboName}: {$qty} combo ({$priceFormatted})";
        }

        $data  = [
            'customerName' => $this->booking->name,
            'form_type' => $this->formTypeLabel(),
            'created_at' => $created_at,
            'phone' => $this->booking->phone,
            'address' => $this->booking->address,
            'email' => $this->booking->email,
            'form' => $this->booking->form_type,
            'note' => $this->booking->note ?? '-',
            'order_detail' => $orderDetail,
            'customer_note' => $customerNote ?? '-',
            'count_combo' => $this->booking->count_combo,
        ];
        return new Content(
            view: 'emails.booking',
            text: 'emails.booking-text',
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
