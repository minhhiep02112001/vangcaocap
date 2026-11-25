@php
    $activeNav = $activeNav ?? '';
@endphp
<header class="fixed w-full top-0 z-50 transition-all duration-300 bg-white shadow-sm" id="main-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex items-center justify-between h-[80px]">
            <div class="flex items-center">
                <a href="/">
                    <img src="/assets/uploads/logo.png" alt="The Best Wine Logo" class="h-[80px] w-auto p-1">
                </a>
            </div>
            <nav class="hidden md:flex items-center space-x-8">
                <a href="/#product"
                    class="text-primary text-xl hover:text-primary/80 transition-colors font-medium uppercase">Về
                    chúng
                    tôi</a>
                <a href="/ruou-vang"
                    class="text-primary text-xl hover:text-primary/80 transition-colors font-medium uppercase {{ $activeNav === 'ruou-vang' ? 'underline decoration-2 underline-offset-4' : '' }}">Rượu
                    vang</a>
                <a href="/#features"
                    class="text-primary text-xl hover:text-primary/80 transition-colors font-medium uppercase">Hộp
                    Quà Tết</a>
                <a href="/#contact"
                    class="text-primary text-xl hover:text-primary/80 transition-colors font-medium uppercase">Liên
                    hệ</a>
                <a href="/gio-hang"
                    class="inline-flex items-center gap-1 text-primary text-xl hover:text-primary/80 transition-colors font-medium uppercase">
                    <i class="ri-shopping-cart-2-line text-2xl"></i>
                    Giỏ hàng
                </a>
            </nav>
            <button type="button" class="md:hidden w-8 h-8 flex items-center justify-center text-primary"
                aria-label="Mở menu">
                <i class="ri-menu-line ri-lg"></i>
            </button>
        </div>
        <nav class="nav-mobile hidden flex-col space-y-4 bg-white py-4 absolute top-full left-0 w-full md:hidden border-t border-gray-100 shadow-sm">
            <a href="/#product"
                class="text-primary hover:text-primary/80 transition-colors font-medium text-center uppercase">Về
                chúng tôi</a>
            <a href="/ruou-vang"
                class="text-primary hover:text-primary/80 transition-colors font-medium text-center uppercase {{ $activeNav === 'ruou-vang' ? 'font-bold' : '' }}">Rượu
                vang</a>
            <a href="/#features"
                class="text-primary hover:text-primary/80 transition-colors font-medium text-center uppercase">Hộp
                Quà Tết</a>
            <a href="/#contact"
                class="text-primary hover:text-primary/80 transition-colors font-medium text-center uppercase">Liên
                hệ</a>
            <a href="/gio-hang"
                class="text-primary hover:text-primary/80 transition-colors font-medium text-center uppercase">Giỏ
                hàng</a>
        </nav>
    </div>
</header>