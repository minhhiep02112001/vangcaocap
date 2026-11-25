@php
    $allCombos = config('data.combo');
    $comboCode = request()->query('combo_code');
    $cartCombos = $allCombos;

    if ($comboCode) {
        $filtered = collect($allCombos)->filter(fn ($combo) => ($combo['code'] ?? '') === $comboCode);
        if ($filtered->isNotEmpty()) {
            $cartCombos = $filtered->all();
        }
    }

    $formatPrice = function (int $amount): string {
        return number_format($amount, 0, ',', '.') . ' ' . config('data.currency', 'VNĐ');
    };

    $defaultFormType = count($cartCombos) === 1
        ? array_key_first($cartCombos)
        : 'combo_cart';
@endphp
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - The Best Wine</title>
    <link rel="icon" type="image/png" href="/assets/uploads/favicon.png">
    <meta name="csrf_token" value="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <a href="/"
                class="text-primary font-medium hover:text-primary/80 inline-flex items-center gap-2">
                <i class="ri-arrow-left-line"></i> Quay lại trang chủ
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="font-playfair text-3xl md:text-4xl font-bold text-gray-900 mb-2">Giỏ hàng</h1>
        <p class="text-gray-600 mb-8">
            @if ($comboCode && count($cartCombos) === 1)
                Combo bạn chọn từ trang chủ.
            @else
                Chọn số lượng và đặt hàng combo ưu đãi.
            @endif
        </p>

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
                    <ul class="divide-y divide-gray-100" id="cart-items">
                        @foreach ($cartCombos as $key => $combo)
                            <li class="p-4 sm:p-6 cart-row" data-combo-key="{{ $key }}"
                                data-price="{{ (int) $combo['price'] }}">
                                <div class="grid sm:grid-cols-12 gap-4 items-center">
                                    <div class="sm:col-span-6 flex gap-4">
                                        <img src="{{ asset($combo['image']) }}"
                                            alt="{{ $combo['name'] }}"
                                            class="w-24 h-24 object-cover rounded-xl flex-shrink-0">
                                        <div>
                                            <h2 class="font-semibold text-gray-900">{{ $combo['name'] }}</h2>
                                            <p class="text-sm text-gray-500 mt-1">{{ $combo['description'] ?? '' }}</p>
                                            <p class="text-sm text-gray-600 mt-2 sm:hidden line-total-mobile font-medium">
                                                {{ $formatPrice($combo['price']) }} × 1
                                            </p>
                                        </div>
                                    </div>
                                    <p class="hidden sm:block sm:col-span-2 text-center font-medium text-gray-800 unit-price">
                                        {{ $formatPrice($combo['price']) }}
                                    </p>
                                    <div class="sm:col-span-2 flex justify-center">
                                        <div
                                            class="inline-flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                            <button type="button"
                                                class="qty-minus w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100"
                                                aria-label="Giảm số lượng">
                                                <i class="ri-subtract-line text-lg"></i>
                                            </button>
                                            <input type="number"
                                                class="qty-input w-12 h-10 text-center border-x border-gray-200 text-gray-900 font-medium [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                                value="1" min="1" max="99"
                                                aria-label="Số lượng">
                                            <button type="button"
                                                class="qty-plus w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100"
                                                aria-label="Tăng số lượng">
                                                <i class="ri-add-line text-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="sm:col-span-2 text-right font-bold text-primary line-total">
                                        {{ $formatPrice($combo['price']) }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <aside class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-md p-6 sticky top-28">
                    <h2 class="font-playfair text-xl font-bold text-gray-900 mb-4">Tóm tắt đơn hàng</h2>
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>Tạm tính</span>
                        <span id="subtotal">{{ $formatPrice(collect($cartCombos)->sum('price')) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>Phí vận chuyển</span>
                        <span class="text-[#0E5E22] font-medium">Miễn phí</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-900 border-t border-gray-100 pt-4 mt-4">
                        <span>Tổng cộng</span>
                        <span class="text-primary" id="grand-total">{{ $formatPrice(collect($cartCombos)->sum('price')) }}</span>
                    </div>
                    <button type="button" id="btn-open-order"
                        class="mt-6 block w-full text-center bg-[#990e06] hover:bg-[#7a0b05] text-white py-3 rounded-full font-semibold text-lg">
                        Đặt hàng
                    </button>
                    <p class="text-xs text-gray-500 mt-3 text-center">Điền thông tin để chúng tôi liên hệ và giao hàng.</p>
                </div>
            </aside>
        </div>
    </main>

    <div id="order-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-black/50" id="order-modal-backdrop"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4 overflow-y-auto">
            <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg my-8" role="dialog"
                aria-labelledby="order-modal-title">
                <button type="button" id="order-modal-close"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
                    aria-label="Đóng">
                    <i class="ri-close-line text-2xl"></i>
                </button>
                <form id="order-form" action="{{ route('booking') }}" method="post" class="p-6 sm:p-8 text-left">
                    @csrf
                    <input type="hidden" name="form_type" id="form_type" value="{{ $defaultFormType }}">
                    <input type="hidden" name="count_combo" id="count_combo_hidden" value="1">
                    <input type="hidden" name="note" id="order_note" value="">

                    <h2 id="order-modal-title"
                        class="font-playfair text-2xl font-bold text-gray-900 mb-1 pr-8">THÔNG TIN ĐẶT HÀNG</h2>
                    <p class="text-sm text-gray-500 mb-6">Thông tin sẽ được gửi tới bộ phận chăm sóc khách hàng.</p>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên <span
                                    class="text-red-600">*</span></label>
                            <input type="text" name="name" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại <span
                                    class="text-red-600">*</span></label>
                            <input type="tel" name="phone" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ nhận hàng <span
                                    class="text-red-600">*</span></label>
                            <input type="text" name="address" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                        <div class="rounded-lg bg-gray-50 p-4 text-sm text-gray-700" id="order-summary-text"></div>
                        <button type="submit" id="order-submit"
                            class="w-full bg-[#990e06] hover:bg-[#7a0b05] text-white py-3 rounded-full font-semibold text-lg">
                            Gửi đơn hàng
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const currencySuffix = @json(' ' . config('data.currency', 'VNĐ'));

            function formatPrice(amount) {
                return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + currencySuffix;
            }

            function clampQty(n) {
                return Math.min(99, Math.max(1, parseInt(n, 10) || 1));
            }

            function getCartState() {
                const rows = document.querySelectorAll('.cart-row');
                let subtotal = 0;
                let totalQty = 0;
                const lines = [];

                rows.forEach((row) => {
                    const price = parseInt(row.dataset.price, 10);
                    const qty = clampQty(row.querySelector('.qty-input').value);
                    const name = row.querySelector('h2')?.textContent?.trim() || row.dataset.comboKey;
                    const lineTotal = price * qty;
                    subtotal += lineTotal;
                    totalQty += qty;
                    lines.push({ name, qty, lineTotal, key: row.dataset.comboKey });
                });

                return { subtotal, totalQty, lines };
            }

            function syncLineTotals() {
                document.querySelectorAll('.cart-row').forEach((row) => {
                    const price = parseInt(row.dataset.price, 10);
                    const qty = clampQty(row.querySelector('.qty-input').value);
                    row.querySelector('.qty-input').value = qty;
                    const lineTotal = price * qty;
                    const formatted = formatPrice(lineTotal);
                    const lineEl = row.querySelector('.line-total');
                    const mobileEl = row.querySelector('.line-total-mobile');
                    const unitPrice = formatPrice(price);
                    if (lineEl) lineEl.textContent = formatted;
                    if (mobileEl) mobileEl.textContent = unitPrice + ' × ' + qty;
                });

                const { subtotal } = getCartState();
                document.getElementById('subtotal').textContent = formatPrice(subtotal);
                document.getElementById('grand-total').textContent = formatPrice(subtotal);
            }

            function buildOrderNote() {
                const { lines, subtotal } = getCartState();
                const parts = lines.map((l) => l.name + ': ' + l.qty + ' combo (' + formatPrice(l.lineTotal) + ')');
                return parts.join('; ') + ' — Tổng: ' + formatPrice(subtotal);
            }

            function updateFormType() {
                const rows = document.querySelectorAll('.cart-row');
                const formTypeEl = document.getElementById('form_type');
                if (rows.length === 1) {
                    formTypeEl.value = rows[0].dataset.comboKey;
                } else {
                    formTypeEl.value = 'combo_cart';
                }
            }

            document.querySelectorAll('.cart-row').forEach((row) => {
                const input = row.querySelector('.qty-input');
                row.querySelector('.qty-minus').addEventListener('click', () => {
                    input.value = clampQty(parseInt(input.value, 10) - 1);
                    syncLineTotals();
                });
                row.querySelector('.qty-plus').addEventListener('click', () => {
                    input.value = clampQty(parseInt(input.value, 10) + 1);
                    syncLineTotals();
                });
                input.addEventListener('change', syncLineTotals);
                input.addEventListener('input', syncLineTotals);
            });

            const modal = document.getElementById('order-modal');
            const openBtn = document.getElementById('btn-open-order');
            const closeBtn = document.getElementById('order-modal-close');
            const backdrop = document.getElementById('order-modal-backdrop');

            function openModal() {
                syncLineTotals();
                updateFormType();
                const state = getCartState();
                document.getElementById('count_combo_hidden').value = state.totalQty;
                document.getElementById('order_note').value = buildOrderNote();
                document.getElementById('order-summary-text').textContent = buildOrderNote();
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }

            openBtn.addEventListener('click', openModal);
            closeBtn.addEventListener('click', closeModal);
            backdrop.addEventListener('click', closeModal);

            const form = document.getElementById('order-form');
            const csrfToken = document.querySelector('meta[name="csrf_token"]')?.getAttribute('value');

            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                syncLineTotals();
                document.getElementById('count_combo_hidden').value = getCartState().totalQty;
                document.getElementById('order_note').value = buildOrderNote();

                const submitBtn = document.getElementById('order-submit');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Đang xử lý...';
                submitBtn.disabled = true;

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        body: new FormData(form),
                    });
                    if (response.ok) {
                        await Swal.fire('Thành công!', 'Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ sớm.', 'success');
                        form.reset();
                        closeModal();
                    } else {
                        Swal.fire('Lỗi!', 'Có lỗi xảy ra, vui lòng thử lại!', 'error');
                    }
                } catch {
                    Swal.fire('Lỗi!', 'Lỗi kết nối!', 'error');
                }

                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        })();
    </script>
</body>

</html>