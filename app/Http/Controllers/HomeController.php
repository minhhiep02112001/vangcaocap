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
        if ($request->has('note')) {
            $input['note'] = $request->input('note');
        }
        if ($request->has('count_combo')) {
            $input['count_combo'] = $request->input('count_combo');
        }
        try {
            $booking =  $this->bookingRepository->create($input);
            $redirect = null;
            $receiverEmail = match ($input['form_type']) {
                'combo_1', 'form_1' => config('data.email_receiver_1'),
                'combo_2', 'combo_cart', 'form_2' => config('data.email_receiver_2'),
                'form_3' => config('data.email_receiver_2'),
                'form_4' => config('data.email_receiver_1'),
                default => config('data.email_receiver_1'),
            };

            if ($input['form_type'] === 'form_4') {
                $redirect = url('/uu-dai-dac-biet');
            }

            $this->sendBookingMailSync($booking, $receiverEmail);

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

    /**
     * Danh sách inbox nhận booking (tránh gửi đúng SMTP nhưng xem nhầm hộp thư).
     */
    protected function resolveBookingMailRecipients(string $primary): array
    {
        $candidates = [
            $primary,
            config('data.email_receiver_1'),
            config('data.email_receiver_2'),
            config('mail.from.address'),
            config('mail.mailers.smtp.username'),
        ];

        $valid = [];
        foreach ($candidates as $email) {
            $email = is_string($email) ? trim($email) : '';
            if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $valid[] = strtolower($email);
            }
        }

        return array_values(array_unique($valid));
    }

    /**
     * Gửi mail đồng bộ (không queue). Thử mailer mặc định rồi smtp_ssl cho VPS.
     */
    protected function sendBookingMailSync($booking, string $receiverEmail): void
    {
        $username = config('mail.mailers.smtp.username');
        $password = config('mail.mailers.smtp.password');
        if (empty($username) || empty($password)) {
            throw new \RuntimeException(
                'Thiếu MAIL_USERNAME / MAIL_PASSWORD trên server (.env không được deploy qua FTP — cần cấu hình tay trên VPS).'
            );
        }

        $recipients = $this->resolveBookingMailRecipients($receiverEmail);
        if ($recipients === []) {
            throw new \RuntimeException('Không có email nhận booking hợp lệ.');
        }

        $mailers = array_values(array_unique([
            config('mail.default', 'smtp'),
            'smtp_ssl',
        ]));

        $lastError = null;
        foreach ($mailers as $mailer) {
            if (! config("mail.mailers.{$mailer}")) {
                continue;
            }
            try {
                Mail::mailer($mailer)
                    ->to($recipients)
                    ->send(new SendEmailBooking($booking));
                Log::info('Booking mail sent', [
                    'mailer' => $mailer,
                    'recipients' => $recipients,
                    'booking_id' => $booking->id,
                    'from' => config('mail.from.address'),
                ]);

                return;
            } catch (\Throwable $e) {
                $lastError = $e;
                Log::warning('Booking mail attempt failed', [
                    'mailer' => $mailer,
                    'recipients' => $recipients,
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
