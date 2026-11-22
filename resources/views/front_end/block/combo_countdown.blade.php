<section aria-labelledby="combo-countdown-title" class="text-center text-white">
    <h2 id="combo-countdown-title" class="mb-5 font-playfair text-xl font-bold leading-tight sm:mb-8 sm:text-4xl">
        THỜI HẠN ĐĂNG KÝ COMBO CỦA BẠN
    </h2>
    <div id="countdown" role="timer" aria-labelledby="combo-countdown-title"
        class="mx-auto grid w-full max-w-[24rem] grid-cols-3 gap-2 sm:gap-6">
        @foreach (['hours' => 'Giờ', 'minutes' => 'Phút', 'seconds' => 'Giây'] as $unit => $label)
            <div class="rounded-xl bg-[#1877b6] px-2 py-3 shadow-lg sm:rounded-2xl sm:py-5">
                <span id="{{ $unit }}" class="block text-2xl font-bold tabular-nums sm:text-4xl">00</span>
                <span class="block text-xs font-semibold sm:text-sm">{{ $label }}</span>
            </div>
        @endforeach
    </div>
</section>
<script>
    (() => {
        const storageKey = 'countdownEndTime';
        const duration = 24 * 60 * 60 * 1000;
        const countdown = document.getElementById('countdown');
        const hours = countdown.querySelector('#hours');
        const minutes = countdown.querySelector('#minutes');
        const seconds = countdown.querySelector('#seconds');
        let endTime = 0;

        function updateCountdown() {
            const now = Date.now();
            if (endTime <= now) {
                endTime = now + duration;
                try {
                    const savedEndTime = Date.parse(localStorage.getItem(storageKey));
                    if (savedEndTime > now) {
                        endTime = savedEndTime;
                    } else {
                        localStorage.setItem(storageKey, new Date(endTime).toISOString());
                    }
                } catch {
                    // Keep counting in memory when storage is unavailable.
                }
            }

            const remaining = Math.floor((endTime - now) / 1000);
            hours.textContent = String(Math.floor(remaining / 3600)).padStart(2, '0');
            minutes.textContent = String(Math.floor(remaining / 60) % 60).padStart(2, '0');
            seconds.textContent = String(remaining % 60).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();
</script>
