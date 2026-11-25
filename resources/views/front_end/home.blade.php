@php 
$combos = config('data.combo');
$combo_1 = $combos['combo_1'];
$combo_2 = $combos['combo_2'];
@endphp

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rượu vang nhập khẩu nguyên chai</title>
    <link rel="icon" type="image/png" href="./assets/uploads/favicon.png">
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8C1C2C',
                        secondary: '#D4AF37'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    },
                    fontFamily: {
                        'roboto-slab': ['Roboto Slab', 'serif'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Pacifico&family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        .font-inter {
            font-family: 'Inter', sans-serif;
        }

        #main-header {
            background: white;
            border-bottom: 1px solid rgba(139, 21, 56, 0.1);
        }

        @keyframes ping {

            75%,
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        .animate-ping {
            animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        #main-header.scrolled {
            background: white;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(139, 21, 56, 0.1);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .gradient-overlay {
            background: linear-gradient(135deg, rgba(139, 21, 56, 0.8) 0%, rgba(212, 175, 55, 0.6) 100%);
        }

        .wine-gradient {
            background: linear-gradient(135deg, #8C1C2C 0%, #D4AF37 100%);
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .fade-in-section {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }

        .fade-in-section.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .toast {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(100%);
            background: rgba(139, 21, 56, 0.95);
            color: white;
            padding: 1.5rem 3rem;
            border-radius: 9999px;
            z-index: 50;
            opacity: 0;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        .combo-banners {
            box-sizing: border-box;
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: clamp(0.5rem, 1.5vw, 1rem);
            max-width: 84rem;
            margin-inline: auto;
            padding-inline: clamp(0.75rem, 2.5vw, 2rem);
            padding-bottom: 0;
        }

        /* Combo stack: CTA → banner → chi tiết sát nhau trên mobile & desktop */
        .home-offer-cta-section {
            padding-top: clamp(1.25rem, 4vw, 2.5rem);
            padding-bottom: clamp(0.5rem, 2vw, 1rem);
        }

        .home-offer-cta-section .home-offer-cta-card {
            margin-bottom: 0;
            padding: clamp(1rem, 3vw, 2rem);
        }

        .home-combo-zone {
            margin-top: clamp(-0.75rem, -2.5vw, 0);
            margin-bottom: clamp(1.25rem, 3vw, 2.5rem);
        }

        @media (min-width: 1024px) {
            .home-combo-zone {
                margin-top: 0;
            }
        }

        .home-combo-zone .home-combo-details {
            padding-top: clamp(0.15rem, 1vw, 0.65rem);
            padding-bottom: clamp(1.25rem, 3vw, 2.5rem);
            padding-left: clamp(0.75rem, 2vw, 1.5rem);
            padding-right: clamp(0.75rem, 2vw, 1.5rem);
        }

        .home-combo-zone .home-combo-details-inner {
            gap: clamp(1rem, 2.5vw, 1.75rem);
        }

        .combo-banners img {
            display: block;
            width: 100%;
            height: auto;
            border-radius: clamp(0.5rem, 1.5vw, 1.25rem);
            box-shadow: 0 8px 24px rgba(65, 12, 12, 0.18);
        }

        @media (min-width: 640px) {
            #banner-title {
                font-size: 1.875rem;
                padding: 2rem;
                letter-spacing: 1.5px;
            }
        }

        @media (min-width: 768px) {
            #banner-title {
                font-size: 2.25rem;
                letter-spacing: 2px;
            }
        }

        @media (min-width: 1024px) {
            #banner-title {
                font-size: 3rem;
                padding: 2.5rem;
                letter-spacing: 2.5px;
            }
        }

        /* Home: heading scale trên mobile (section only, không áp footer) */
        @media (max-width: 639px) {
            #page-home section h1 {
                font-size: clamp(1.25rem, 5.5vw, 1.625rem) !important;
                line-height: 1.25 !important;
            }

            #page-home section h2 {
                font-size: clamp(1.125rem, 5vw, 1.5rem) !important;
                line-height: 1.3 !important;
            }

            #page-home section h3 {
                font-size: clamp(1.0625rem, 4.5vw, 1.375rem) !important;
                line-height: 1.35 !important;
            }

            #page-home section h4 {
                font-size: clamp(0.9375rem, 4vw, 1.125rem) !important;
                line-height: 1.4 !important;
            }

            #page-home section h1,
            #page-home section h2,
            #page-home section h3,
            #page-home section h4 {
                letter-spacing: 0.02em;
                word-break: break-word;
            }

            #page-home section h2 i.text-3xl,
            #page-home section h2 .text-3xl {
                font-size: 1.0625rem !important;
                line-height: 1.35 !important;
            }

            #page-home section .text-center.mb-16 {
                margin-bottom: 2rem;
            }
        }
    </style>
</head>

<body id="page-home" class="font-inter">
    <!-- Header -->
    <header class="fixed w-full top-0 z-50 transition-all duration-300 bg-white shadow-sm" id="main-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="flex items-center justify-between h-[80px]">
                <div class="flex items-center">
                    <a href="/">
                        <img src="./assets/uploads/logo.png" alt="The Best Wine Logo" class="h-[80px] w-auto p-1">
                    </a>
                </div>
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="Javascript:void(0)" id="scrollBtn"
                        class="text-primary text-xl hover:text-primary/80 transition-colors font-medium uppercase">Về
                        chúng
                        tôi</a>
                    <a href="/ruou-vang"
                        class="text-primary text-xl hover:text-primary/80 transition-colors font-medium uppercase">Rượu
                        vang</a>
                    <a href="#features"
                        class="text-primary text-xl hover:text-primary/80 transition-colors font-medium uppercase">Hộp
                        Quà Tết</a>
                    <a href="#contact"
                        class="text-primary text-xl hover:text-primary/80 transition-colors font-medium uppercase">Liên
                        hệ</a>
                    <a href="/gio-hang"
                        class="inline-flex items-center gap-1 text-primary text-xl hover:text-primary/80 transition-colors font-medium uppercase">
                        <i class="ri-shopping-cart-2-line text-2xl"></i>
                        Giỏ hàng
                    </a>
                </nav>
                <button class="md:hidden w-8 h-8 flex items-center justify-center text-primary">
                    <i class="ri-menu-line ri-lg"></i>
                </button>
            </div>
            <nav class="nav-mobile hidden flex-col space-y-4 bg-white py-4 absolute top-full left-0 w-full md:hidden">
                <a href="Javascript:void(0)" id="scrollBtnMB"
                    class="text-primary hover:text-primary/80 transition-colors font-medium text-center uppercase">Về
                    chúng tôi</a>
                <a href="/ruou-vang"
                    class="text-primary hover:text-primary/80 transition-colors font-medium text-center uppercase">Rượu
                    vang</a>
                <a href="#features"
                    class="text-primary hover:text-primary/80 transition-colors font-medium text-center uppercase">Hộp
                    Quà Tết</a>
                <a href="#contact"
                    class="text-primary hover:text-primary/80 transition-colors font-medium text-center uppercase">Liên
                    hệ</a>
                <a href="/gio-hang"
                    class="text-primary hover:text-primary/80 transition-colors font-medium text-center uppercase">Giỏ
                    hàng</a>
            </nav>
        </div>
    </header>
    <!-- Wine Education Banner -->
    <section class=" flex items-center mt-[100px]">
        <div class="max-w-8xl mx-auto px-4 sm:px-8   ">
            <div class="w-full max-w-[1200px] ">
                <div class="flex flex-col md:flex-row items-center gap-10 h-full pl-[.5em] pr-[.5em]">
                    <h1 class="font-roboto-slab text-[#0E5E22] text-xl sm:text-2xl md:text-[1.7rem] lg:text-[2rem] ml-auto mr-auto text-center font-bold leading-tight m-auto p-2 sm:p-4 shadow-2xl tracking-[0.5px] sm:tracking-[1px]"
                        style="line-height: 1.35;">
                        <div class="text-center">PHÂN BIỆT RƯỢU VANG GIẢ, RƯỢU VANG ĐÓNG CHAI TRONG NƯỚC VÀ RƯỢU VANG
                            NHẬP KHẨU NGUYÊN CHAI</div>
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-cover bg-center px-3 py-2 sm:px-6 sm:py-4 lg:px-8 lg:py-6"
        style="background-image: url('{{ asset('assets/uploads/bg-event.jpg') }}');">
        <img src="{{ asset('assets/uploads/photo_banner_info_1.jpg') }}" alt="Cách đọc nhãn chai rượu vang"
            width="1024" height="903"
            class="mx-auto block h-auto w-full max-w-4xl rounded-lg shadow-2xl sm:rounded-2xl">
    </section>
    <!-- Produ
     ct Introduction -->
    <section class="py-5 relative overflow-hidden">
        <div class="absolute inset-0 bg-[#FDF7F9] transform -skew-y-6 origin-top-left"></div>
        <div class="absolute inset-0 opacity-30"
            style="background: radial-gradient(circle at 70% 30%, #8B1538 0%, transparent 50%)"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <div>
                    <div class="product-info">
                        <div class="product-info-slide active">
                            <h2 class="text-xl sm:text-2xl lg:text-5xl font-bold text-[#0E5E22] mb-4 sm:mb-6"
                                style="line-height: 1.4;">
                                <div><i class="text-xl sm:text-2xl lg:text-3xl not-italic">Bạn lo sợ...</i></div>
                                <div>
                                    <span class="text-primary ">Mua phải rượu vang</span>
                                    <span class="text-[#023ba4]"> giả, kém chất
                                        lượng???</span>
                                </div>
                            </h2>
                            <p class="  mb-2">Bạn biết rằng rượu vang là thứ đồ uống có lợi cho sức khỏe: chống ung thư,
                                tiểu đường, tim mạch...đã được kiểm chứng 8000 năm trong suốt chiều dài lịch sử nhân
                                loại.</p>

                            <p class="  mb-2">😱 Tuy nhiên, bạn cũng như nhiều người khác, bạn lo lắng vì chưa chọn được
                                loại vang phù hợp thậm chí là rượu GIẢ vì thị trường có quá nhiều loại.</p>
                            <p class="  mb-2">Tin vui, là hầu như không có rượu vang giả, mà chỉ có 2 loại đang bán tại
                                Việt Nam như sau:</p>

                            <div class="grid grid-cols-2 gap-6 mb-8">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 flex items-center justify-center bg-primary/10 rounded-full">
                                        <i class="ri-award-line text-primary ri-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm sm:text-base font-semibold text-gray-900 leading-snug">Rượu
                                            vang nhập khẩu nguyên chai</h4>
                                        <p class="text-sm text-gray-600">Đạt chuẩn quốc tế</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-12 h-12 flex items-center justify-center bg-secondary/10 rounded-full">
                                        <i class="ri-time-line text-secondary ri-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm sm:text-base font-semibold text-gray-900 leading-snug">Rượu
                                            vang đóng chai trong nước</h4>
                                        <p class="text-sm text-gray-600">Hương vị không đạt chuẩn</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="relative">
                    <div class="product-carousel overflow-hidden">
                        <div class="product-slides flex transition-transform duration-300">
                            <div class="product-slide w-full flex-shrink-0 pb-4">
                                <img src="./assets/uploads/vang-gia.png" alt="Vang Đỏ Bordeaux"
                                    class="w-full max-w-md mx-auto object-top object-cover rounded-2xl shadow-2xl">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Features Section -->
    <section class="  relative overflow-hidden">
        <div class="absolute inset-0 bg-white"></div>
        <div class="absolute inset-0"
            style="background: linear-gradient(135deg, rgba(139, 21, 56, 0.05) 0%, transparent 50%), linear-gradient(45deg, rgba(212, 175, 55, 0.05) 0%, transparent 50%)">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">

            <div class="bg-white rounded-2xl shadow-xl p-2 mb-2 relative overflow-hidden">
                <div class="flex flex-col lg:flex-row items-center justify-between">
                    <div class="text-center lg:text-left mb-8 lg:mb-0">
                        <p class="text-[20px]  mb-2">👉 Nghe thì giống nhau, nhưng sự thật lại KHÁC BIỆT một trời một
                            vực:</p>
                        <p class=" mb-2">✅ Vang nhập khẩu nguyên chai: Được sản xuất – đóng chai trực tiếp tại Pháp,
                            Ý, Chile…, vận chuyển về Việt Nam. Giữ nguyên hương vị, chuẩn chất lượng quốc tế.</p>
                        <p class="  mb-2"> ✅ ✅ Vang đóng chai tại VN: Rượu vang nhập về dạng bồn, sau đó đóng chai lại
                            ở Việt Nam → Giá rẻ hơn, nhưng hương vị, độ “nguyên bản” không còn như ban đầu vì các rủi ro
                            sau:
                        </p>
                        <p class="  mb-2">1, Quy trình đóng chai không đảm bảo chất lượng.</p>
                        <p class="  mb-2">2, Loại rượu có phẩm cấp thấp, chất lượng kém vì không được kiểm định của các
                            hiệp hội rượu vang nước sở tại.</p>
                        <p class="  mb-2">3, Hàm lượng khí SULPHITES không được kiểm soát.</p>
                        <p class="  mb-2">💥 Vậy, làm sao để phân biệt khi 2 loại đều có tem, mác nhập khẩu giống hệt
                            nhau?</p>
                        <p class="  mb-2">- Tem & nhãn mác: Vang nguyên chai thường có cấp độ rõ ràng, có chỉ dẫn địa
                            lý
                            và có trên các website của nước ngoài.</p>
                        <p class="  mb-2">- Tem phụ: có ghi rõ ràng “nhập khẩu nguyên chai”, vang đóng chai chỉ ghi
                            lách
                            luật: “rượu vang nhập khẩu”</p>
                        <p class="  mb-2">- Mức giá: Vang nhập khẩu nguyên chai thường cao hơn rõ rệt.</p>
                        <p class="  mb-2">- Các chứng từ: Hoá đơn, Packing List, chứng nhận COA, công bố sản phẩm là
                            các
                            giấy tờ bạn có thể yêu cầu bên bán. </p>
                        <p class="  mb-2">⚡️ CẢNH BÁO: Nếu bạn bỏ tiền triệu để mua vang “xịn” mà lại cầm về chai vang…
                            đóng ở VN thì đúng là mất tiền oan! Vậy nên ngoài các lưu ý trên thì hãy lựa chọn các địa
                            chỉ bán hàng uy tín: có địa chỉ, có pháp lý công ty rõ ràng:</p>
                    </div>
                </div>
            </div>



        </div>
    </section>

    <section id="ve-chung-toi" class="py-10 relative overflow-hidden">
        <div class="absolute inset-0 bg-white"></div>
        <div class="absolute inset-0"
            style="background: linear-gradient(135deg, rgba(139, 21, 56, 0.05) 0%, transparent 50%), linear-gradient(45deg, rgba(212, 175, 55, 0.05) 0%, transparent 50%)">
        </div>
        <div class="absolute top-0 right-0 w-1/2 h-1/2 opacity-20"
            style="background: radial-gradient(circle at 70% 30%, #D4AF37 0%, transparent 70%)"></div>
        <div class="absolute bottom-0 left-0 w-1/2 h-1/2 opacity-20"
            style="background: radial-gradient(circle at 30% 70%, #8B1538 0%, transparent 70%)"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-16">

                <div class="bg-white rounded-2xl shadow-xl p-2 mb-2 relative overflow-hidden">
                    <div class="flex flex-col lg:flex-row items-center justify-between">
                        <div class="text-center lg:text-left mb-8 lg:mb-0">
                            <p class=" text-xl  text-[#0E5E22]  mb-2">Tại The Best Wine, với các chuyên gia đã hơn 15
                                năm kinh nghiệm hợp tác cùng hàng trăm hầm rượu hàng đầu thế giới, chúng tôi cam kết chỉ
                                bán rượu vang nhập khẩu nguyên chai và từ những vùng làm vang danh tiếng nhất của Pháp
                                và Ý.</p>
                            <p class=" text-xl  text-[#0E5E22]  mb-2">
                                Ví dụ dưới đây là chai rượu vang Petit Gautier đến từ nhà sản xuất Le Cellier Des
                                Gourmets, một trong những nhà làm vang nổi tiếng nhất tiểu vùng St Emilion danh giá của
                                Bordeaux.</p>
                        </div>
                    </div>



                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-2 mb-2 relative overflow-hidden">
                <div class="flex flex-col lg:flex-row items-center justify-between" id="product">
                    <div class="text-center lg:text-left mb-8 lg:mb-0">
                        <h3
                            class="text-xl sm:text-2xl md:text-3xl text-center font-playfair font-bold text-[#990F07] mb-3 sm:mb-4 uppercase leading-tight">
                            ƯU ĐÃI KHI MUA 6 CHAI VANG NHẬP KHẨU CHÍNH HÃNG PETIT GAUTIER</h3>
                        <p class="text-xl text-center text-[#0E5E22] mb-2">Tổng thanh toán chỉ 2.790.000VNĐ cho Combo
                            06 chai vang Pháp nhập khẩu nguyên chai:</p>
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mt-4">
                            <div class="text-center">
                                <img src="./assets/uploads/ruou-vang-combo-1.png" alt="Bộ ly Pha Lê Bohemia 06 chiếc"
                                    class="w-full h-auto rounded-lg ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-[#990F07] py-4 text-center mb-3 rounded-lg shadow-md">
                <p class="text-2xl font-bold text-white">TỔNG GIÁ TRỊ QUÀ TẶNG 1.559.000 VND</p>
            </div>
            <a href="https://www.vivino.com/fr/le-cellier-des-gourmets-petit-gautier/w/6800488?srsltid=AYCX9vLLCCfvI8Q2QU4mh3P2_WrnchALgTckjondkpucKgUef9T5HcvM"
                target="_blank"
                class="block w-full md:w-auto bg-[#0E5E22] text-white px-8 py-4 rounded-full font-semibold text-center shadow-md">
                Truy xuất nguồn gốc rượu
            </a>
        </div>
    </section>
    <!-- Special Promotion Form -->
    {{-- <section class="py-5 bg-white relative overflow-hidden" id="special-promotion">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#FEF2F2] rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 lg:p-12 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-primary to-secondary animate-pulse">
                </div>
                <div class="grid md:grid-cols-2 gap-5 sm:gap-6 md:gap-8 items-center">
                    <div>
                        <h3
                            class="text-xl sm:text-2xl md:text-3xl font-bold text-primary mb-4 sm:mb-6 text-center md:text-left leading-tight">
                            NHẬN ƯU ĐÃI ĐẶC BIỆT
                        </h3>
                        <div class="space-y-3 sm:space-y-4 md:space-y-6">
                            <div class="bg-white p-4 sm:p-5 md:p-6 rounded-lg sm:rounded-xl">
                                <div class="flex items-center gap-2 sm:gap-4 mb-2 sm:mb-4">
                                    <i class="ri-gift-line text-primary text-2xl sm:text-3xl shrink-0"></i>
                                    <p class="text-base sm:text-lg md:text-xl font-semibold text-gray-900">Quà tặng độc
                                        quyền</p>
                                </div>
                                <ul class="space-y-2 sm:space-y-3 text-gray-600 text-sm sm:text-base">
                                    <li class="flex items-start sm:items-center gap-2">
                                        <i class="ri-check-line text-primary shrink-0 mt-0.5 sm:mt-0"></i>
                                        <span>Bộ ly Pha Lê </span>
                                    </li>
                                    <li class="flex items-start sm:items-center gap-2">
                                        <i class="ri-check-line text-primary shrink-0 mt-0.5 sm:mt-0"></i>
                                        <span>Hộp gỗ</span>
                                    </li>
                                    <li class="flex items-start sm:items-center gap-2">
                                        <i class="ri-check-line text-primary shrink-0 mt-0.5 sm:mt-0"></i>
                                        <span>Bình Decanter</span>
                                    </li>
                                    <li class="flex items-start sm:items-center gap-2">
                                        <i class="ri-check-line text-primary shrink-0 mt-0.5 sm:mt-0"></i>
                                        <span>Mở chai cao cấp</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="bg-white p-4 sm:p-5 md:p-6 rounded-lg sm:rounded-xl">
                                <div class="flex items-center gap-2 sm:gap-4 mb-2 sm:mb-4">
                                    <i class="ri-truck-line text-primary text-2xl sm:text-3xl shrink-0"></i>
                                    <p class="text-base sm:text-lg md:text-xl font-semibold text-gray-900">Dịch vụ VIP
                                    </p>
                                </div>
                                <ul class="space-y-2 sm:space-y-3 text-gray-600 text-sm sm:text-base">
                                    <li class="flex items-start sm:items-center gap-2">
                                        <i class="ri-check-line text-primary shrink-0 mt-0.5 sm:mt-0"></i>
                                        <span>Giao hàng miễn phí toàn quốc</span>
                                    </li>
                                    <li class="flex items-start sm:items-center gap-2">
                                        <i class="ri-check-line text-primary shrink-0 mt-0.5 sm:mt-0"></i>
                                        <span>Tư vấn chọn rượu chuyên nghiệp</span>
                                    </li>
                                    <li class="flex items-start sm:items-center gap-2">
                                        <i class="ri-check-line text-primary shrink-0 mt-0.5 sm:mt-0"></i>
                                        <span>Hỗ trợ 24/7</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mt-1 sm:mt-0">
                        <form action="{{ route('booking') }}" method="post"
                            data-redirect="{{ url('/uu-dai-dac-biet') }}"
                            class="bg-gradient-to-b from-red-50 to-red-100 p-4 sm:p-5 md:p-6 rounded-2xl sm:rounded-3xl shadow-lg sm:shadow-xl relative overflow-hidden">
                            <div class="absolute inset-0 opacity-10"
                                style="background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 1440 320\'%3E%3Cpath fill=\'%23800020\' fill-opacity=\'1\' d=\'M0,160L48,138.7C96,117,192,75,288,80C384,85,480,139,576,149.3C672,160,768,128,864,133.3C960,139,1056,181,1152,192C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z\'%3E%3C/path%3E%3C/svg%3E'); background-size: cover; background-repeat: repeat-y;">
                            </div>
                            @csrf
                            <input type="hidden" name="form_type" value="form_1">
                            <h4
                                class="text-lg sm:text-xl md:text-2xl font-bold text-red-900 mb-3 sm:mb-5 md:mb-6 relative z-10 uppercase text-center sm:text-left leading-snug">
                                Đăng ký nhận ưu
                                đãi</h4>
                            <div class="space-y-3 sm:space-y-4 relative z-10">
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-red-800 mb-0.5 sm:mb-1">Họ
                                        và tên <span class="text-danger">*</span></label>
                                    <input type="text" name="name" required
                                        class="w-full px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base rounded-xl sm:rounded-full border border-red-200 focus:ring-2 focus:ring-red-600 focus:border-transparent bg-white/80"
                                        placeholder="Nhập họ tên của bạn">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-red-800 mb-0.5 sm:mb-1">Số
                                        điện thoại <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" required
                                        class="w-full px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base rounded-xl sm:rounded-full border border-red-200 focus:ring-2 focus:ring-red-600 focus:border-transparent bg-white/80"
                                        placeholder="Nhập số điện thoại">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-red-800 mb-0.5 sm:mb-1">Địa
                                        chỉ nhận
                                        hàng <span class="text-danger">*</span></label>
                                    <input type="text" name="address" required
                                        class="w-full px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base rounded-xl sm:rounded-full border border-red-200 focus:ring-2 focus:ring-red-600 focus:border-transparent bg-white/80"
                                        placeholder="Nhập địa chỉ nhận hàng">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-red-800 mb-0.5 sm:mb-1">Ghi
                                        chú</label>
                                    <textarea name="note"
                                        class="w-full px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base rounded-xl sm:rounded-2xl border border-red-200 focus:ring-2 focus:ring-red-600 focus:border-transparent bg-white/80"
                                        rows="3" placeholder="Nhập ghi chú nếu có"></textarea>
                                </div>
                                <button type="submit"
                                    class="w-full uppercase bg-red-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 md:py-4 rounded-xl sm:rounded-full font-semibold text-sm sm:text-base">
                                    ĐĂNG KÝ NGAY
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- <section class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="bg-white rounded-2xl shadow-xl p-2 mb-2 relative overflow-hidden">
                <div class="flex flex-col lg:flex-row items-center justify-between">
                    <div class="text-center text-align: justify; text-[#000] lg:text-left mb-8 lg:mb-0">
                        <p class=" text-[#001dfa]  font-bold text-2xl   mb-2">TUY NHIÊN, BẠN CẦN PHẢI BIẾT ĐIỀU NÀY...
                        </p>
                        <h3 class="text-lg sm:text-2xl md:text-3xl font-bold mb-2 leading-snug">Kể cả khi bạn mua được
                            loại vang nhập khẩu nguyên chai
                            thì bạn vẫn sẽ có những vấn đề, vì với rượu vang chưa hẳn đắt tiền đã là ngon.</h3>
                        <p class="  mb-2">
                            QUAN TRỌNG nhất khi lựa chọn rượu vang là phải phù hợp với khẩu vị của bạn chứ không hẳn là
                            đắt tiền và cấp độ cao, điều này được thể hiện rõ nhất với hai yếu tố:

                        </p>
                        <p class=" text-[#001dfa]   mb-2">- Giống nho</p>
                        <p class="  text-[#001dfa]  mb-2">- Khí hậu, thổ nhưỡng của vùng trồng nho</p>
                        <p class="  mb-2">
                            Do đó khi mua rượu vang, bạn cần quan tâm những yếu tố này trên nhãn chai rượu vang rồi mới
                            là giá tiền. </p>
                        <p class="  mb-2">
                            Rượu vang L’amour được làm bởi 2 giống nho kinh điển mang phong cách chuẩn Bordeaux Blend là
                            Caberner Sauvignon và Merlot nên mang hương vị đặc trưng nhất của Pháp, cùng những phụ kiện
                            ưu đãi đi kèm trong Combo này, bạn sẽ luôn có những khoảnh khắc tận hưởng rượu vang một cách
                            trọn vẹn nhất.</p>

                    </div>
                </div>
            </div>
        </div>
    </section> --}}


    <!-- Features Section -->
    <section id="features" class="py-5 relative overflow-hidden">
        <div class="absolute inset-0 bg-white"></div>
        <div class="absolute inset-0"
            style="background: linear-gradient(135deg, rgba(139, 21, 56, 0.05) 0%, transparent 50%), linear-gradient(45deg, rgba(212, 175, 55, 0.05) 0%, transparent 50%)">
        </div>
        <div class="absolute top-0 right-0 w-1/2 h-1/2 opacity-20"
            style="background: radial-gradient(circle at 70% 30%, #D4AF37 0%, transparent 70%)"></div>
        <div class="absolute bottom-0 left-0 w-1/2 h-1/2 opacity-20"
            style="background: radial-gradient(circle at 30% 70%, #8B1538 0%, transparent 70%)"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-8 sm:mb-12 md:mb-6">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">Chi tiết bộ quà tặng.
                </h2>
                {{-- <h3 class="text-xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-2 sm:mb-4 leading-tight">Hãy đăng
                    ký <span class="text-[#0E5E22]">COMBO</span></h3>
                <h3
                    class="text-xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-[#0E5E22] mb-2 sm:mb-4 leading-tight">
                    2.370.000 VNĐ </h3>
                <h3 class="text-xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-4 sm:mb-6 leading-tight">ngay hôm
                    nay để được</h3>
                <p class="text-base sm:text-lg md:text-2xl leading-relaxed px-1">
                    <span class="text-[#CD853F]">Nhận ưu đãi</span> <span class="text-[#0E5E22]">trọn bộ 06 chai rượu
                        và quà tặng kèm</span> <span class="text-[#CD853F]">dưới đây</span>
                </p> --}}
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group hover:transform hover:scale-105 transition-all duration-300">
                    <img src="./assets/uploads/hop-ruou.jpg" alt="Hộp rượu vang"
                        class="w-full lg:h-[16rem] md:h-auto sm:h-auto object-cover rounded-xl shadow-lg mb-6">
                    <h3 class="font-playfair text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-3 sm:mb-4">Hộp 6
                        Chai Vang</h3>
                    <p class="text-gray-600 mb-4">Hộp gỗ sang trọng đựng 6 chai vang cao cấp, thiết kế tinh tế với lớp
                        đệm bảo vệ an toàn cho từng chai rượu.</p>
                    <p class="text-xl font-semibold text-primary">160.000 VNĐ</p>
                </div>
                <div class="text-center group hover:transform hover:scale-105 transition-all duration-300">
                    <img src="./assets/uploads/bo-ly.jpg" alt="Bộ ly pha lê"
                        class="w-full lg:h-[16rem] md:h-auto sm:h-auto object-cover rounded-xl shadow-lg mb-6">
                    <h3 class="font-playfair text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-3 sm:mb-4">Bộ Ly
                        Pha Lê Bohemia</h3>
                    <div class="text-gray-600 mb-4">
                        <p class="mb-2">Dung tích 600ml tốt nhất để bạn thưởng thức các loại vang đỏ</p>
                        <p>Chất liệu Pha lê Handmade sang trọng, mang lại tiếng chuông ngân dài khi chạm ly</p>
                    </div>
                    <p class="text-xl font-semibold text-primary">650.000 VNĐ</p>
                </div>
                <div class="text-center group hover:transform hover:scale-105 transition-all duration-300">
                    <img src="./assets/uploads/binh-decan.jpg" alt="Bình thở Decanter"
                        class="w-full lg:h-[16rem] md:h-auto sm:h-auto object-cover rounded-xl shadow-lg mb-6">
                    <h3 class="font-playfair text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-3 sm:mb-4">Bình
                        Thở Decanter</h3>
                    <p class="text-gray-600 mb-4">Trước khi uống 30 phút, bạn cần mở và đổ tất cả chai rượu vào bình
                        này
                        để rượu có thời gian oxy hóa tốt nhất. Điều này sẽ làm tăng hương vị cho rượu.</p>
                    <p class="text-xl font-semibold text-primary">550.000 VNĐ</p>
                </div>
                <div class="text-center group hover:transform hover:scale-105 transition-all duration-300">
                    <img src="./assets/uploads/lap-mo.jpg" alt="Mở chai cao cấp"
                        class="w-full lg:h-[16rem] md:h-auto sm:h-auto object-cover rounded-xl shadow-lg mb-6">
                    <h3 class="font-playfair text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-3 sm:mb-4">Mở
                        Chai Cao Cấp</h3>
                    <p class="text-gray-600 mb-4">Giúp cho việc mở chai dễ dàng, kể cả các chai rượu để lâu năm và có
                        nguy cơ bị mủn nút chai.</p>
                    <p class="text-xl font-semibold text-primary">199.000 VNĐ</p>
                </div>
            </div>
            <div class="text-center mt-6">
                <h3 class="text-lg sm:text-2xl md:text-3xl lg:text-4xl font-bold text-primary leading-snug px-2">TỔNG
                    GIÁ TRỊ QUÀ TẶNG 1.559.000 VNĐ</h3>
            </div>
        </div>
    </section>
    <!-- Reason to choose us -->
    <section id="reasons" class="py-5 relative overflow-hidden">
        <div class="absolute inset-0 bg-[#FFF5F5] transform -skew-y-3 origin-bottom-right"></div>
        <div class="absolute inset-0 opacity-25"
            style="background: radial-gradient(circle at 50% 50%, #8B1538 0%, transparent 70%), radial-gradient(circle at 80% 20%, #D4AF37 0%, transparent 50%)">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-5">
                <h2
                    class="font-playfair text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-4 sm:mb-6 leading-tight px-2">
                    Lý do khách hàng <span class="text-primary">chọn chúng tôi</span>
                </h2>
            </div>
            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-gray-50 p-4 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center mb-4">
                        <i class="ri-checkbox-circle-line text-primary text-4xl"></i>
                    </div>
                    <p class="text-gray-700 text-center font-medium">
                        Sản phẩm được tuyển chọn kỹ lưỡng qua 5 vòng, được bảo quản kho lạnh theo tiêu chuẩn quốc tế.
                    </p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center mb-4">
                        <i class="ri-money-dollar-circle-line text-primary text-4xl"></i>
                    </div>
                    <p class="text-gray-700 text-center font-medium">
                        Giá bán luôn tốt nhất.
                    </p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center mb-4">
                        <i class="ri-global-line text-primary text-4xl"></i>
                    </div>
                    <p class="text-gray-700 text-center font-medium">
                        Hàng nhập khẩu nguyên chai có giấy tờ nhập khẩu, xuất xứ rõ ràng, có hóa đơn đỏ VAT.
                    </p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center mb-4">
                        <i class="ri-loop-left-line text-primary text-4xl"></i>
                    </div>
                    <p class="text-gray-700 text-center font-medium">
                        Cam kết đổi trả hàng, hoàn tiền 100% nếu khách hàng không hài lòng.
                    </p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center mb-4">
                        <i class="ri-truck-line text-primary text-4xl"></i>
                    </div>
                    <p class="text-gray-700 text-center font-medium">
                        Thời gian giao hàng nhanh nhất, chỉ 30 phút trong nội thành Hà Nội và TP HCM.
                    </p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center mb-4">
                        <i class="ri-headphone-line text-primary text-4xl"></i>
                    </div>
                    <p class="text-gray-700 text-center font-medium">
                        Đội ngũ chuyên gia giàu kinh nghiệm sẵn sàng tư vấn 24/7 để mang đến khách hàng sự lựa chọn tốt
                        nhất.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="home-offer-cta-section relative overflow-hidden"
        style="background-image: url('./assets/uploads/201b5a32936c69ad19ba28013da9b877.jpg')">
        <div class="absolute inset-0 wine-gradient opacity-90"></div>
        <div class="relative z-10 max-w-6xl mx-auto text-center px-3 sm:px-6 lg:px-8">
            <h2 class="font-playfair text-2xl sm:text-4xl lg:text-6xl font-bold text-white mb-2 sm:mb-4 leading-tight">
                Ưu Đãi Đặc Biệt
            </h2>
            <p
                class="text-sm sm:text-lg md:text-xl text-gray-200 mb-3 sm:mb-5 xl:max-w-[1000px] max-w-2xl mx-auto leading-relaxed px-1">
                Đặt hàng ngay hôm nay để nhận ưu đãi cho đơn hàng đầu tiên
                và miễn phí giao hàng toàn quốc
            </p>
            <div
                class="home-offer-cta-card bg-white rounded-lg sm:rounded-xl text-center max-w-3xl mx-auto">
                <h4 class="hidden sm:block text-2xl md:text-3xl font-bold text-[#B91C1C] mb-4 md:mb-8">THÔNG TIN ĐẶT
                    HÀNG</h4>
                {{--
                    <div class="space-y-4 sm:space-y-6 md:space-y-8">
                    <form action="{{ route('booking') }}" method="post"
                        data-redirect="{{ url('/uu-dai-dac-biet') }}"
                        class="bg-gradient-to-b from-red-50 to-red-100 p-4 sm:p-5 md:p-6 rounded-lg sm:rounded-xl mt-0 sm:mt-4 md:mt-8 text-left relative overflow-hidden">
                        @csrf
                        <input type="hidden" name="form_type" value="form_2">
                        <div class="absolute inset-0 opacity-10"
                            style="background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 1440 320\'%3E%3Cpath fill=\'%23800020\' fill-opacity=\'1\' d=\'M0,160L48,138.7C96,117,192,75,288,80C384,85,480,139,576,149.3C672,160,768,128,864,133.3C960,139,1056,181,1152,192C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z\'%3E%3C/path%3E%3C/svg%3E'); background-size: cover; background-repeat: repeat-y;">
                        </div>
                        <div class="absolute inset-0 opacity-5"
                            style="background: radial-gradient(circle at 50% 50%, #D4AF37 0%, transparent 70%), radial-gradient(circle at 80% 20%, #D4AF37 0%, transparent 50%);">
                        </div>
                          <h4
                            class="text-lg sm:text-xl md:text-2xl font-bold text-red-900 mb-3 sm:mb-5 md:mb-6 relative z-10">
                            THÔNG TIN ĐẶT HÀNG</h4>
                         <div class="space-y-3 sm:space-y-4 relative z-10">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-red-800 mb-0.5 sm:mb-1">Họ và
                                    Tên <span class="text-danger">*</span></label>
                                <input type="text" name="name" required
                                    class="w-full px-3 py-2 sm:px-4 text-sm sm:text-base rounded-md border border-red-200 focus:ring-2 focus:ring-red-600 focus:border-transparent bg-white/80"
                                    placeholder="">
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-red-800 mb-0.5 sm:mb-1">Số Điện
                                    Thoại <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" required
                                    class="w-full px-3 py-2 sm:px-4 text-sm sm:text-base rounded-md border border-red-200 focus:ring-2 focus:ring-red-600 focus:border-transparent bg-white/80"
                                    placeholder="">
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-red-800 mb-0.5 sm:mb-1">Địa Chỉ
                                    Nhận Hàng <span class="text-danger">*</span></label>
                                <input type="text" name="address" required
                                    class="w-full px-3 py-2 sm:px-4 text-sm sm:text-base rounded-md border border-red-200 focus:ring-2 focus:ring-red-600 focus:border-transparent bg-white/80"
                                    placeholder="">
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-red-800 mb-0.5 sm:mb-1">Số
                                    Lượng combo <span class="text-danger">*</span></label>
                                <input type="number" name="count_combo" required min="1"
                                    class="w-full px-3 py-2 sm:px-4 text-sm sm:text-base rounded-md border border-red-200 focus:ring-2 focus:ring-red-600 focus:border-transparent bg-white/80"
                                    placeholder="">
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-red-800 mb-0.5 sm:mb-1">Ghi
                                    chú</label>
                                <textarea name="note"
                                    class="w-full px-3 py-2 sm:px-4 text-sm sm:text-base rounded-md border border-red-200 focus:ring-2 focus:ring-green-600 focus:border-transparent bg-white/80"
                                    rows="3" placeholder=""></textarea>
                            </div>
                            <button type="button"
                                class="w-full bg-[#990e06] text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-md font-semibold text-sm sm:text-base">
                                ĐĂNG KÝ
                            </button>

                        </div>
                    </form> --}}
                <div class="mt-1 sm:mt-2   text-center">
                    <a href="./gio-hang?combo_code={{ $combo_1['code'] }}"
                        class="block bg-[#990e06] text-white px-3 sm:px-6 py-2 md:py-4 rounded-md font-medium text-xs sm:text-sm md:text-base uppercase leading-snug">
                        ĐĂNG KÝ NHẬN ƯU ĐÃI 6 CHAI PETIT GAUTIER
                    </a>
                </div>
                <div class="mt-2 sm:mt-3 text-center">
                    <a href="./uu-dai-dac-biet"
                        class="block bg-[#990e06] text-white px-3 sm:px-6 py-2 md:py-4 rounded-md font-medium text-xs sm:text-sm md:text-base uppercase leading-snug">
                        Nhận Ưu Đãi Khác
                    </a>
                </div>
                {{-- </div> --}}
            </div>
        </div>
    </section>

    <section class="home-combo-zone relative overflow-hidden">
        <div class="combo-banners">
            {{-- <img src="{{ asset('assets/images/banner_combo.jpg') }}" width="1280" height="574" loading="lazy"
                alt="Siêu Combo 2025: 12 chai vang Le Cerrate, hộp túi, tủ rượu, ly pha lê, decanter và mở chai. Tổng giá trị 16.200.000 VNĐ."> --}}
            <img src="{{ asset('assets/images/banner_combo_1.jpg') }}" width="1366" height="845" loading="lazy"
                alt="Siêu Combo 2026: Trả 1 được 8 với rượu vang Elettra. Tổng giá trị 18.000.000 VNĐ.">
        </div>
        {{-- <div class="max-w-6xl mx-auto mt-10">
            <a href="/khuyen-mai" target="_blank"
                class="block w-full md:w-auto bg-[#0E5E22] text-white px-8 py-4 rounded-full font-semibold text-center shadow-md">
                Bấm vào đây để nhận Ưu đãi Combo tặng tủ bảo quản rượu vang
            </a>
        </div> --}}

        <div class="home-combo-details bg-gradient-to-br from-[#8b0000]/10 to-secondary/10">
            <div class="home-combo-details-inner mx-auto flex max-w-6xl flex-col">
                <section class="rounded-2xl bg-[#990e06] p-4 shadow-xl sm:rounded-3xl sm:p-8"
                    aria-labelledby="home-combo-offer-title">
                    <h2 id="home-combo-offer-title"
                        class="mb-3 text-center font-playfair text-2xl font-bold leading-tight text-white sm:mb-5 sm:text-4xl">
                        Và đây là 8 ưu đãi bạn nhận được khi mua Combo này:
                    </h2>
                    <ol
                        class="list-inside list-decimal space-y-2.5 text-sm leading-relaxed text-gray-800 sm:text-base
                        [&>li]:rounded-xl [&>li]:bg-gray-50 [&>li]:p-3 [&>li]:shadow-sm sm:[&>li]:p-4">
                        <li>Bạn nhận được 12 chai rượu vang Elettra Primitivo</li>
                        <li>Tặng kèm 12 bộ hộp túi Elettra</li>
                        <li>Tặng kèm 01 tủ bảo quản rượu vang 24 chai</li>
                        <li>Tặng kèm 01 bộ ly Pha Lê Bohemia 06 chiếc</li>
                        <li>Tặng kèm 01 Decanter Pha Lê Bohemia</li>
                        <li>Tặng kèm 01 mở chai cao cấp</li>
                        <li>Tặng kèm 06 chai vang Pháp Petit Gautier</li>
                        <li>Tặng kèm 01 buổi trải nghiệm thử 6 loại rượu vang và nghệ thuật thưởng thức trên bàn tiệc,
                            cùng chuyên gia rượu vang hơn 15 năm kinh nghiệm của The Best Wine.</li>
                    </ol>
                    <div
                        class="mt-6 rounded-xl bg-gradient-to-r from-[#8b0000]/30 to-secondary/10 p-3 text-center sm:mt-9 sm:rounded-2xl sm:p-7">
                        <div class="rounded-xl bg-gray-50 p-4 text-gray-800 shadow-md sm:p-6">
                            <p class="text-lg font-bold sm:text-2xl">
                                Tổng giá trị quà tặng: <span class="whitespace-nowrap">9.860.000 VNĐ</span>
                            </p>
                            <p class="mt-3 text-sm leading-relaxed sm:text-lg">
                                Như vậy, với Combo này bạn đã có tất cả các ưu đãi tốt nhất của chúng tôi với chỉ một
                                lần
                                thanh toán
                                <strong class="text-lg font-bold sm:text-2xl whitespace-nowrap text-[#8b0000]">18.000.000 VNĐ</strong> duy nhất.
                            </p>
                        </div>
                        <a href="./gio-hang?combo_code={{ $combo_2['code'] }}"
                            class="mt-4 inline-block rounded-full bg-[#8b0000] px-6 py-3 text-sm font-bold text-white transition-colors hover:bg-red-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white sm:px-10 sm:py-4 sm:text-base">
                            ĐĂNG KÝ Siêu Combo Trả 1 Được 8
                        </a>
                    </div>
                </section>

                <div class="space-y-6 rounded-2xl bg-[#990e06] p-4 shadow-xl sm:space-y-8 sm:rounded-3xl sm:p-8">
                    <section aria-labelledby="home-combo-audience-title">
                        <h2 id="home-combo-audience-title"
                            class="mb-4 text-center font-playfair text-xl font-bold text-white sm:text-3xl">Sản phẩm
                            này dành cho ai:</h2>
                        <ul
                            class="list-inside list-disc space-y-2.5 text-sm leading-relaxed text-gray-800 sm:text-base
                            [&>li]:rounded-xl [&>li]:bg-gray-50 [&>li]:p-3 [&>li]:shadow-sm sm:[&>li]:p-4">
                            <li>Các doanh nhân muốn có một sản phẩm đẳng cấp và nâng tầm giao tiếp trên bàn tiệc.</li>
                            <li>Quý khách hàng hay phải tiếp khách mà cần uống rượu một cách văn minh, có lợi cho sức
                                khỏe.</li>
                        </ul>
                    </section>
                    <section aria-labelledby="home-combo-notes-title">
                        <h2 id="home-combo-notes-title"
                            class="mb-4 text-center font-playfair text-xl font-bold text-white sm:text-3xl">Những lưu ý
                            khi bạn mua hàng của The Best Wine:</h2>
                        <ul class="list-inside list-disc text-sm leading-relaxed text-gray-800 sm:text-base">
                            <li class="rounded-xl bg-gray-50 p-3 shadow-sm sm:p-4">
                                Điều tuyệt vời là chúng tôi sẵn sàng đổi trả sản phẩm nếu quý khách không hài lòng khi
                                sử dụng.
                            </li>
                        </ul>
                    </section>
                    @include('front_end.block.combo_countdown')
                </div>
            </div>
        </div>

    </section>

    <!-- Warnning -->
    <section class="py-10 relative overflow-hidden">
        <div class="absolute inset-0 bg-[#FFF5F5] transform -skew-y-3 origin-bottom-right"></div>
        <div class="absolute inset-0 opacity-25"
            style="background: radial-gradient(circle at 50% 50%, #8B1538 0%, transparent 70%), radial-gradient(circle at 80% 20%, #D4AF37 0%, transparent 50%)">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-12">
                <h2
                    class="font-playfair text-xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4 sm:mb-6 leading-tight px-2">
                    Chương Trình <span class="text-primary">Marketing Không Lợi Nhuận</span>
                </h2>
            </div>
            <div class="bg-white rounded-xl p-8 shadow-lg max-w-4xl mx-auto">
                <p class="text-xl text-gray-700 leading-relaxed text-center">
                    "Đây là chương trình <span class="text-2xl text-[#8B1538] font-semibold">Marketing không lợi
                        nhuận</span>, xin nhắc lại đây là chương trình <span
                        class="text-2xl text-[#8B1538] font-semibold">Marketing không lợi nhuận</span> vì chúng tôi
                    muốn
                    truyền bá một thứ đồ uống văn minh của nhân loại, hoàn toàn có lợi cho sức
                    khỏe và được coi là món quà của Thượng Đế, chúng tôi muốn nhiều người nhất có thể sử dụng những sản
                    phẩm rượu vang nhập khẩu nguyên chai, chính hãng tránh gây nhầm lẫn với các sản phẩm kém chất
                    lượng."
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('front_end.layout.footer')

    @include('front_end.block.share_social')

    <!-- Thêm CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fullCta = document.getElementById('cta-full');
            const toggleBtn = document.getElementById('cta-toggle');
            const closeBtn = document.getElementById('cta-close');

            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                fullCta.classList.add('hidden');
                toggleBtn.classList.remove('hidden');
            });

            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                fullCta.classList.remove('hidden');
                toggleBtn.classList.add('hidden');
            });
        });
    </script>
    <div class="toast" id="toast">Cảm ơn bạn đã đăng ký Combo 1 của chúng tôi! Bạn được nhận thêm một combo 2
    </div>
    <script id="mobile-menu">
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('button[class*="md:hidden"]');
            const nav = document.querySelector('.nav-mobile');
            const header = document.getElementById('main-header');
            if (menuButton && nav) {
                menuButton.addEventListener('click', function() {
                    nav.classList.toggle('hidden');
                    nav.classList.toggle('flex');
                    const icon = menuButton.querySelector('i');
                    icon.classList.toggle('ri-menu-line');
                    icon.classList.toggle('ri-close-line');
                    // Ensure header updates its style when menu is toggled
                    if (nav.classList.contains('flex')) {
                        header.classList.add('scrolled');
                    } else {
                        if (window.scrollY <= 50) {
                            header.classList.remove('scrolled');
                        }
                    }
                });
            }
        });
    </script>
    <script id="smooth-scroll">
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href^="#"], button.scroll-to-form');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href') || '#special-promotion';
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        // Close mobile menu if open
                        const nav = document.querySelector('.nav-mobile');
                        const menuButton = document.querySelector('button[class*="md:hidden"]');
                        if (nav && !nav.classList.contains('hidden')) {
                            nav.classList.add('hidden');
                            nav.classList.remove('flex');
                            const icon = menuButton.querySelector('i');
                            icon.classList.remove('ri-close-line');
                            icon.classList.add('ri-menu-line');
                            const header = document.getElementById('main-header');
                            if (window.scrollY <= 50) {
                                header.classList.remove('scrolled');
                            }
                        }
                    }
                });
            });
        });
    </script>
    <script id="scroll-animations">
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('section');
            const header = document.getElementById('main-header');
            sections.forEach(section => {
                section.classList.add('fade-in-section');
            });
            let lastScrollTop = 0;

            function updateHeaderStyle() {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }
            window.addEventListener('scroll', updateHeaderStyle);
            updateHeaderStyle();

            function checkScroll() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    const windowHeight = window.innerHeight;
                    if (scrollTop > sectionTop - windowHeight + sectionHeight / 4) {
                        section.classList.add('is-visible');
                    }
                });
                lastScrollTop = scrollTop;
            }
            window.addEventListener('scroll', checkScroll);
            checkScroll();
        });
    </script>
    <script id="form-handling">
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            const csrf_token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            // const toast = document.getElementById('toast');
            forms.forEach(form => {
                if (!form.action || !form.action.includes('/booking')) {
                    return;
                }
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    let status = false;
                    let redirectTo = form.getAttribute('data-redirect');

                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;
                    submitButton.textContent = 'Đang xử lý...';
                    submitButton.disabled = true;
                    const formData = new FormData(form);

                    try {
                        const response = await fetch(form.action, {
                            method: form.method,
                            headers: {
                                'X-CSRF-TOKEN': csrf_token,
                                'Accept': 'application/json',
                            },
                            body: formData
                        });
                        const result = await response.json().catch(() => ({}));
                        if (response.ok && result.status === 'success') {
                            Swal.fire('Thành công!',
                                'Cảm ơn bạn đã đăng ký. Chúng tôi sẽ liên hệ sớm.', 'success');
                            form.reset();
                            status = true;
                            if (result.redirect) {
                                redirectTo = result.redirect;
                            }
                        } else {
                            Swal.fire('Lỗi!', result.message || 'Có lỗi xảy ra, vui lòng thử lại!', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Lỗi!', 'Lỗi kết nối!', 'error');
                    }
                    setTimeout(() => {
                        submitButton.textContent = originalText;
                        submitButton.disabled = false;
                        if (status && redirectTo) {
                            window.location.href = redirectTo;
                        }
                    }, 3000);
                    return;
                });
            });
        });
    </script>
    <script id="product-carousel">
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.querySelector('.product-carousel');
            const slides = document.querySelector('.product-slides');
            const prevBtn = carousel.querySelector('.prev');
            const nextBtn = carousel.querySelector('.next');
            const dots = document.querySelectorAll('.carousel-dot');
            const infoSlides = document.querySelectorAll('.product-info-slide');
            let currentSlide = 0;
            const totalSlides = 1;

            function updateSlide(index) {
                slides.style.transform = `translateX(-${index * 100}%)`;
                dots.forEach((dot, i) => {
                    dot.classList.toggle('bg-primary', i === index);
                    dot.classList.toggle('bg-primary/30', i !== index);
                });
                infoSlides.forEach((slide, i) => {
                    slide.classList.toggle('hidden', i !== index);
                    slide.classList.toggle('active', i === index);
                });
                currentSlide = index;
            }


            updateSlide(0);
        });
    </script>
    <script>
        document.getElementById("scrollBtn").addEventListener("click", function() {
            const element = document.getElementById("ve-chung-toi");
            const headerOffset = 80; // chiều cao header
            const elementPosition = element.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: "smooth"
            });
        });
        document.getElementById("scrollBtnMB").addEventListener("click", function() {
            const element = document.getElementById("ve-chung-toi");
            const headerOffset = 80; // chiều cao header
            const elementPosition = element.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: "smooth"
            });
        });
    </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"version":"2024.11.0","token":"192c87cdce3a4ada85917427f34033cd","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}'
        crossorigin="anonymous"></script>
    @include('front_end.block.age_verification_popup')
</body>

</html>
