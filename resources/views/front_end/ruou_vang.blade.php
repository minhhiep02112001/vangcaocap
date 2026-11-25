@php
    $category = config('data.config_product.categories.ruou_vang');
    $products = $category['products'] ?? [];
    $perPage = config('data.config_product.per_page', 10);
    $total = count($products);
    $banner = $category['banner'] ?? [];
    $priceFilters = $category['price_filters'] ?? [];
    $currency = config('data.currency', 'VNĐ');
    $formatPrice = function (int $amount) use ($currency): string {
        return number_format($amount, 0, ',', '.') . ' ' . $currency;
    };
@endphp
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category['title'] ?? 'Rượu Vang' }} - The Best Wine</title>
    <meta name="description" content="{{ $category['intro'] ?? '' }}">
    <link rel="icon" type="image/png" href="/assets/uploads/favicon.png">
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8C1C2C',
                        secondary: '#D4AF37',
                        brandGreen: '#0E5E22',
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
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        #main-header.scrolled {
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
        }

        .product-card:hover {
            box-shadow: 0 12px 40px rgba(140, 28, 44, 0.12);
        }

        .price-filter-active {
            color: #8C1C2C;
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 4px;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    @include('front_end.layout.home_main_header', ['activeNav' => 'ruou-vang'])

    <main class="pt-[80px]">
        {{-- Banner --}}
        <section class="relative overflow-hidden min-h-[140px] sm:min-h-[200px] md:min-h-[260px]">
            <img src="{{ asset($banner['image'] ?? '/assets/images/banner_combo_1.jpg') }}" alt=""
                class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-[#8B0000]/85 via-[#B91C1C]/70 to-[#8B0000]/50"></div>
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 md:py-16">
                <p class="text-amber-200 text-sm sm:text-base font-semibold tracking-widest uppercase mb-2">
                    {{ $banner['title'] ?? 'The Best Wine' }}
                </p>
                <p class="text-white/90 text-xs sm:text-sm md:text-base max-w-2xl leading-relaxed">
                    {{ $banner['subtitle'] ?? '' }}
                </p>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
            <header class="mb-6 sm:mb-8">
                <h1 class="font-playfair text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    {{ $category['title'] ?? 'Rượu Vang' }}
                </h1>
                <p class="text-sm sm:text-base text-gray-600 leading-relaxed max-w-3xl">
                    {{ $category['intro'] ?? '' }}
                </p>
            </header>

            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 pb-4 border-b border-gray-200">
                <p class="text-sm text-gray-600" id="result-summary">
                    Hiển thị kết quả 1–{{ min($perPage, $total) }} trong số <span id="result-total">{{ $total }}</span>
                </p>
                <div class="flex items-center gap-2 sm:gap-3">
                    <span class="text-sm text-gray-500 hidden sm:inline">Sắp xếp:</span>
                    <select id="product-sort"
                        class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-800 focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        <option value="default">Thứ tự mặc định</option>
                        <option value="price_asc">Giá: thấp đến cao</option>
                        <option value="price_desc">Giá: cao đến thấp</option>
                        <option value="name_asc">Tên: A → Z</option>
                    </select>
                </div>
            </div>

            <p class="text-sm font-semibold text-brandGreen mb-3">Khoảng giá:</p>
            <div class="flex flex-wrap gap-x-4 gap-y-2 mb-6 sm:mb-8 text-sm text-gray-600" id="price-filters">
                @foreach ($priceFilters as $filter)
                    <button type="button"
                        data-filter-key="{{ $filter['key'] }}"
                        data-min="{{ $filter['min'] ?? 0 }}"
                        data-max="{{ $filter['max'] ?? '' }}"
                        class="price-filter hover:text-primary transition-colors {{ $filter['key'] === 'all' ? 'price-filter-active' : '' }}">
                        {{ $filter['label'] }}
                    </button>
                @endforeach
            </div>

            <ul class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5" id="product-grid">
                @foreach ($products as $index => $product)
                    @if ($index >= $perPage)
                        @break
                    @endif
                    <li class="product-card bg-white rounded-xl border border-gray-100 overflow-hidden transition-shadow duration-300"
                        data-price="{{ (int) $product['price'] }}"
                        data-name="{{ $product['name'] }}"
                        data-order="{{ $index }}">
                        <div class="flex flex-row h-full min-h-[168px] sm:min-h-[192px] md:min-h-[210px]">
                            <a href="/gio-hang"
                                class="relative w-[46%] sm:w-[48%] md:w-[50%] min-w-[120px] sm:min-w-[140px] flex-shrink-0 bg-gray-50 block">
                                <img src="{{ asset($product['image']) }}"
                                    alt="{{ $product['name'] }}"
                                    class="absolute inset-0 w-full h-full object-contain p-1 sm:p-1.5">
                                @foreach ($product['badges'] ?? [] as $badge)
                                    <span
                                        class="absolute top-1.5 left-1.5 text-[10px] font-bold uppercase px-1.5 py-0.5 rounded {{ strtoupper($badge) === 'HOT' ? 'bg-red-600 text-white' : 'bg-amber-500 text-white' }}">
                                        {{ $badge }}
                                    </span>
                                @endforeach
                            </a>
                            <div class="flex-1 p-3 sm:p-4 flex flex-col border-l border-gray-100">
                                <a href="/gio-hang"
                                    class="font-semibold text-gray-900 text-sm sm:text-base leading-snug line-clamp-2 hover:text-primary mb-2">
                                    {{ $product['name'] }}
                                </a>
                                <ul class="space-y-1 text-xs sm:text-[13px] text-gray-600 flex-1">
                                    <li class="flex items-start gap-2">
                                        <i class="ri-plant-line text-brandGreen shrink-0 mt-0.5" aria-hidden="true"></i>
                                        <span class="line-clamp-1">{{ $product['grape'] }}</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="ri-goblet-line text-brandGreen shrink-0 mt-0.5" aria-hidden="true"></i>
                                        <span>{{ $product['type'] }}</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="ri-award-line text-brandGreen shrink-0 mt-0.5" aria-hidden="true"></i>
                                        <span>{{ $product['brand'] }}</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="ri-global-line text-brandGreen shrink-0 mt-0.5" aria-hidden="true"></i>
                                        <span>{{ $product['origin'] }}</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="ri-percent-line text-brandGreen shrink-0 mt-0.5" aria-hidden="true"></i>
                                        <span>{{ $product['abv'] }}</span>
                                    </li>
                                </ul>
                                <p class="mt-2 text-base sm:text-lg font-bold text-primary">
                                    {{ $formatPrice((int) $product['price']) }}
                                </p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <p id="product-empty" class="hidden text-center text-gray-500 py-12">
                Không có sản phẩm trong khoảng giá đã chọn.
            </p>
        </div>
    </main>

    @include('front_end.layout.footer')
    @include('front_end.block.share_social')
    @include('front_end.block.age_verification_popup')

    <script>
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
                });
            }
            window.addEventListener('scroll', function() {
                if (!header) return;
                header.classList.toggle('scrolled', window.scrollY > 50);
            });

            const grid = document.getElementById('product-grid');
            const items = Array.from(grid.querySelectorAll('.product-card'));
            const emptyEl = document.getElementById('product-empty');
            const resultSummary = document.getElementById('result-summary');
            const sortSelect = document.getElementById('product-sort');
            let activeFilter = document.querySelector('.price-filter-active');

            function matchesPrice(card, min, max) {
                const price = parseInt(card.dataset.price, 10);
                if (min && price < min) return false;
                if (max !== '' && max != null && price > parseInt(max, 10)) return false;
                return true;
            }

            function updateSummary(visible) {
                const count = visible.length;
                if (count === 0) {
                    resultSummary.textContent = 'Hiển thị 0 kết quả';
                    emptyEl.classList.remove('hidden');
                    grid.classList.add('hidden');
                } else {
                    resultSummary.textContent = 'Hiển thị kết quả 1–' + count + ' trong số ' + count;
                    emptyEl.classList.add('hidden');
                    grid.classList.remove('hidden');
                }
            }

            function applyFiltersAndSort() {
                const min = activeFilter ? parseInt(activeFilter.dataset.min || '0', 10) : 0;
                const max = activeFilter?.dataset.max ?? '';
                const sort = sortSelect.value;
                let visible = items.filter(function(card) {
                    return matchesPrice(card, min, max);
                });
                if (sort === 'price_asc') {
                    visible.sort((a, b) => parseInt(a.dataset.price) - parseInt(b.dataset.price));
                } else if (sort === 'price_desc') {
                    visible.sort((a, b) => parseInt(b.dataset.price) - parseInt(a.dataset.price));
                } else if (sort === 'name_asc') {
                    visible.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name, 'vi'));
                } else {
                    visible.sort((a, b) => parseInt(a.dataset.order) - parseInt(b.dataset.order));
                }
                items.forEach((el) => el.classList.add('hidden'));
                visible.forEach((el) => {
                    el.classList.remove('hidden');
                    grid.appendChild(el);
                });
                updateSummary(visible);
            }

            document.querySelectorAll('.price-filter').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.price-filter').forEach((b) => b.classList.remove('price-filter-active'));
                    btn.classList.add('price-filter-active');
                    activeFilter = btn;
                    applyFiltersAndSort();
                });
            });
            sortSelect.addEventListener('change', applyFiltersAndSort);
        });
    </script>
</body>

</html>