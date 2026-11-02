<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - The Best Wine</title>
    <link rel="icon" type="image/png" href="/assets/uploads/favicon.png">
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8C1C2C',
                        secondary: '#D4AF37'
                    },
                    fontFamily: {
                        playfair: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-20">
            <a href="/" class="flex items-center gap-3">
                <img src="/assets/uploads/logo.png" alt="The Best Wine" class="h-14 w-auto">
            </a>
            <a href="/#product"
                class="text-primary font-medium hover:text-primary/80 inline-flex items-center gap-2">
                <i class="ri-arrow-left-line"></i> Quay lại trang chủ
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="font-playfair text-3xl md:text-4xl font-bold text-gray-900 mb-2">Giỏ hàng</h1>
        <p class="text-gray-600 mb-8">Combo và giá hiển thị theo trang chủ The Best Wine.</p>

        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <div
                        class="hidden sm:grid grid-cols-12 gap-4 px-6 py-4 bg-gray-50 text-sm font-semibold text-gray-600 border-b">
                        <span class="col-span-6">Sản phẩm</span>
                        <span class="col-span-2 text-center">Đơn giá</span>
                        <span class="col-span-2 text-center">Số lượng</span>
                        <span class="col-span-2 text-right">Thành tiền</span>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        <li class="p-4 sm:p-6">
                            <div class="grid sm:grid-cols-12 gap-4 items-center">
                                <div class="sm:col-span-6 flex gap-4">
                                    <img src="/assets/uploads/ruou-vang-combo-1.jpg"
                                        alt="Combo 6 chai vang Bronzeo nhập khẩu nguyên chai"
                                        class="w-24 h-24 object-cover rounded-xl flex-shrink-0">
                                    <div>
                                        <h2 class="font-semibold text-gray-900">Combo 6 chai vang Bronzeo nhập khẩu
                                            nguyên chai</h2>
                                        <p class="text-sm text-gray-500 mt-1">395K/chai — 6 chai nhập khẩu chính hãng
                                        </p>
                                        <p class="text-sm text-gray-600 mt-2 sm:hidden">2.370.000 VNĐ × 1</p>
                                    </div>
                                </div>
                                <p class="hidden sm:block sm:col-span-2 text-center font-medium text-gray-800">
                                    2.370.000 VNĐ
                                </p>
                                <p class="hidden sm:block sm:col-span-2 text-center text-gray-700">1</p>
                                <p class="sm:col-span-2 text-right font-bold text-primary">2.370.000 VNĐ</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <aside class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-md p-6 sticky top-28">
                    <h2 class="font-playfair text-xl font-bold text-gray-900 mb-4">Tóm tắt đơn hàng</h2>
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>Tạm tính</span>
                        <span>2.370.000 VNĐ</span>
                    </div>
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>Phí vận chuyển</span>
                        <span class="text-[#0E5E22] font-medium">Miễn phí</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-900 border-t border-gray-100 pt-4 mt-4">
                        <span>Tổng cộng</span>
                        <span class="text-primary">2.370.000 VNĐ</span>
                    </div>
                    <a href="/"
                        class="mt-6 block w-full text-center bg-[#990e06] hover:bg-[#7a0b05] text-white py-3 rounded-full font-semibold text-lg">
                        Đặt hàng
                    </a>
                    <p class="text-xs text-gray-500 mt-3 text-center">Bấm đặt hàng để quay về trang chủ và hoàn tất
                        thông tin.</p>
                </div>
            </aside>
        </div>
    </main>
</body>

</html>
