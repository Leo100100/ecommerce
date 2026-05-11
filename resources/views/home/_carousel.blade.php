<div class="carousel" id="promoCarousel">
    <div class="carousel-track" id="carouselTrack">

        <div class="carousel-slide" style="background:#232F3E;">
            <i class="bi bi-bag-heart" style="font-size:2.5rem;"></i>
            <div class="carousel-slide-title">Novidades da semana</div>
            <div class="carousel-slide-sub">Confira os produtos mais recentes da loja</div>
        </div>

        <div class="carousel-slide" style="background:#0055aa;">
            <i class="bi bi-truck" style="font-size:2.5rem;"></i>
            <div class="carousel-slide-title">Entrega rápida</div>
            <div class="carousel-slide-sub">Seus pedidos chegam com agilidade</div>
        </div>

        <div class="carousel-slide" style="background:#1a5c3a;">
            <i class="bi bi-shield-check" style="font-size:2.5rem;"></i>
            <div class="carousel-slide-title">Compra segura</div>
            <div class="carousel-slide-sub">Seus dados e pagamentos sempre protegidos</div>
        </div>

    </div>

    <button class="carousel-btn carousel-btn-prev" id="carouselPrev">
        <i class="bi bi-chevron-left"></i>
    </button>
    <button class="carousel-btn carousel-btn-next" id="carouselNext">
        <i class="bi bi-chevron-right"></i>
    </button>

    <div class="carousel-dots" id="carouselDots">
        <button class="carousel-dot active" data-index="0"></button>
        <button class="carousel-dot" data-index="1"></button>
        <button class="carousel-dot" data-index="2"></button>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const track  = document.getElementById('carouselTrack');
    const dots   = document.querySelectorAll('.carousel-dot');
    const total  = 3;
    let current  = 0;

    function goTo(index) {
        current = (index + total) % total;
        track.style.transform = 'translateX(-' + (current * 33.333) + '%)';
        dots.forEach(function (d, i) {
            d.classList.toggle('active', i === current);
        });
    }

    document.getElementById('carouselPrev').addEventListener('click', function () { goTo(current - 1); });
    document.getElementById('carouselNext').addEventListener('click', function () { goTo(current + 1); });
    dots.forEach(function (d) {
        d.addEventListener('click', function () { goTo(parseInt(d.dataset.index)); });
    });

    setInterval(function () { goTo(current + 1); }, 4000);
})();
</script>
@endpush
