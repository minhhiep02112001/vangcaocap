<?php

namespace App\Http\Controllers;

use App\Mail\SendEmailBooking;
use App\Models\Redirect;
use App\Repositories\Eloquent\BookingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    protected $model_tag;
    protected $model_post;

    public function __construct(
        public BookingRepository $bookingRepository,
    ) {}

    public function dashboard(Request $request)
    {
        return view('front_end.home', []);
    }

    public function ruouVang(Request $request)
    {
        return view('front_end.ruou_vang');
    }
    
    public function gioHang(Request $request)
    { 
        return view('front_end.cart');
    }
    public function page(Request $request)
    {
        return view('front_end.page', []);
    }
    public function khuyenMai(Request $request)
    {
        return view('front_end.khuyen_mai', []);
    }
    public function quaTet(Request $request)
    {
        return view('front_end.qua_tet', []);
    }

    public function chinhSachThanhToan()
    {
        return view('front_end.chinh-sach-thanh-toan');
    }
    public function chinhSachVeGia()
    {
        return view('front_end.chinh-sach-ve-gia');
    }
    public function chinhSachBaoMat()
    {
        return view('front_end.chinh-sach-bao-mat');
    }

    public function chinhSachVanChuyenVaDoiTraHang()
    {
        return view('front_end.chinh-sach-van-chuyen-va-doi-tra-hang');
    }

    public function phuongThucTiepCanVaKhieuNai()
    {
        return view('front_end.phuong-thuc-tiep-can-va-khieu-nai');
    }

    public function dieuKienHanCheTrongViecCungCapHangHoa()
    {
        return view('front_end.dieu-kien-han-che-trong-viec-cung-cap-hang-hoa');
    }


    public function booking(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'form_type' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->validator->errors()->first(),
                'errors' => $e->errors(),
            ], 422);
        }

        $input = $validated;
        if ($request->has('count_combo')) {
            $input['count_combo'] = $request->input('count_combo');
        }
        $input['note'] = $this->resolveBookingNote($request, $input);
        
        try {
            $booking =  $this->bookingRepository->create($input);
            $redirect = null;
            if ($input['form_type'] === 'form_4') {
                $redirect = url('/uu-dai-dac-biet');
            }

            $this->sendBookingMailSync($booking);

            return response()->json([
                'status' => 'success',
                'redirect' => $redirect,
            ], 200);
        } catch (\Throwable $ex) {
            Log::error('Booking mail failed', [
                'message' => $ex->getMessage(),
                'form_type' => $request->input('form_type'),
                'mail_host' => config('mail.mailers.smtp.host'),
                'mail_port' => config('mail.mailers.smtp.port'),
                'mail_username_set' => ! empty(config('mail.mailers.smtp.username')),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => config('app.debug') ? $ex->getMessage() : 'Có lỗi khi gửi đơn.',
            ], 500);
        }
    }

    protected function composeBookingNote(string $summary, string $customerNote): string
    {
        if ($summary !== '' && $customerNote !== '') {
            return $summary . "\n\nGhi chú khách hàng: " . $customerNote;
        }
        if ($summary !== '') {
            return $summary;
        }

        return 'Ghi chú khách hàng: ' . $customerNote;
    }

    protected function resolveBookingNote(Request $request, array $input): ?string
    {
        $legacyNote = trim((string) $request->input('note', ''));
        $summary = trim((string) $request->input('order_summary', ''));
        $customerNote = trim((string) $request->input('customer_note', ''));

        if ($legacyNote !== '') {
            return $legacyNote;
        }
        if ($summary !== '' || $customerNote !== '') {
            return $this->composeBookingNote($summary, $customerNote);
        }

        $formType = (string) ($input['form_type'] ?? '');
        $comboKey = match ($formType) {
            'form_1' => 'combo_1',
            'form_2' => 'combo_2',
            default => $formType,
        };

        if (! in_array($comboKey, ['combo_1', 'combo_2'], true)) {
            return null;
        }

        $combo = config("data.combo.{$comboKey}");
        if (! is_array($combo)) {
            return null;
        }

        $qty = max(1, (int) $request->input('count_combo', 1));
        $price = number_format((int) ($combo['price'] ?? 0), 0, ',', '.');

        return ($combo['name'] ?? $comboKey) . ": {$qty} combo ({$price} VNĐ)";
    }

    protected function bookingReceiverEmail(): string
    {
        $email = trim((string) config('data.email_receiver', ''));
        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException('EMAIL_RECEIVER trong .env không hợp lệ hoặc chưa cấu hình.');
        }

        return strtolower($email);
    }

    /**
     * Gửi mail đồng bộ (không queue). Thử mailer mặc định rồi smtp_ssl cho VPS.
     */
    protected function sendBookingMailSync($booking): void
    {
        $username = config('mail.mailers.smtp.username');
        $password = config('mail.mailers.smtp.password');
        if (empty($username) || empty($password)) {
            throw new \RuntimeException(
                'Thiếu MAIL_USERNAME / MAIL_PASSWORD trên server (.env không được deploy qua FTP — cần cấu hình tay trên VPS).'
            );
        }

        $to = $this->bookingReceiverEmail();

        $mailers = array_values(array_unique([
            config('mail.default', 'smtp'),
            'smtp_ssl',
        ]));

        $lastError = null; 
        $mailable = new SendEmailBooking($booking);

        foreach ($mailers as $mailer) {
            if (! config("mail.mailers.{$mailer}")) {
                continue;
            }
            try {
                Mail::mailer($mailer)->to($to)->send($mailable);

                Log::info('Booking mail sent', [
                    'mailer' => $mailer,
                    'to' => $to,
                    'booking_id' => $booking->id,
                    'form_type' => $booking->form_type,
                    'from' => config('mail.from.address'),
                ]);

                return;
            } catch (\Throwable $e) {
                $lastError = $e;
                Log::warning('Booking mail attempt failed', [
                    'mailer' => $mailer,
                    'to' => $to,
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        throw $lastError ?? new \RuntimeException('Không gửi được email booking.');
    }

    public function redirect(Request $request)
    {
        return abort(404);
    }

    public function redirect301(Request $request, $slug)
    {
        $url = $request->url();
        $url = str_replace('http://', 'https://', $url);
        $link = Redirect::where('url_old', $url)->where('is_status', 1)->first();
        if (!empty($link)) {
            return redirect($link->url_new, 301);
        }
        return abort(404);;
    }
}
