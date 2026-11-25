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

            // Gửi SMTP ngay trong request (không queue, không cần queue:work)
            Mail::mailer(config('mail.default', 'smtp'))
                ->to($receiverEmail)
                ->send(new SendEmailBooking($booking));

            return response()->json([
                'status' => 'success',
                'redirect' => $redirect,
            ], 200);
        } catch (\Throwable $ex) {
            Log::error('Booking mail failed', [
                'message' => $ex->getMessage(),
                'form_type' => $request->input('form_type'),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => config('app.debug') ? $ex->getMessage() : 'Có lỗi khi gửi đơn.',
            ], 500);
        }
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
