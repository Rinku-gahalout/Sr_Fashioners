<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS (or your CSS) -->
     <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

@stack('styles')
</head>
<body>
    <div id="app">

        <!-- Include Header -->
        @include('partials.header')

        <!-- Main Content -->
        <main >
            @yield('content')
        </main>

        <!-- Include Footer -->
        @include('partials.footer')

    </div>
<a href="https://wa.me/919814003901"
   class="mobile-whatsapp"
   target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>

<style>
    * {
    box-sizing: border-box;
}
 
html,
body {
    width: 100%;
    overflow-x: hidden;
}
.mobile-whatsapp{
    position:fixed;
    left:15px;
    bottom:20px;
    width:60px;
    height:60px;
    background:#25D366;
    color:#fff;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    font-size:32px;
    z-index:999999;
    box-shadow:0 4px 15px rgba(0,0,0,.25);
    animation:whatsappPulse 2s infinite;
}


@keyframes whatsappPulse{
    0%{
        box-shadow:0 0 0 0 rgba(37,211,102,.7);
    }
    70%{
        box-shadow:0 0 0 15px rgba(37,211,102,0);
    }
    100%{
        box-shadow:0 0 0 0 rgba(37,211,102,0);
    }
}
    </style>

    @stack('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- owl carousel on homepage -->
<script>
$(document).ready(function () {

    function mobileCarousel() {
        if ($(window).width() < 768) {

            if (!$('.clients-wrapper').hasClass('owl-loaded')) {
                $('.clients-wrapper').owlCarousel({
                    items: 1,
                    loop: true,
                    margin: 15,
                    dots: true,
                    nav: false,
                    autoplay: true,
                    autoplayTimeout: 3000
                });
            }

        } else {

            if ($('.clients-wrapper').hasClass('owl-loaded')) {
                $('.clients-wrapper').trigger('destroy.owl.carousel');
                $('.clients-wrapper')
                    .removeClass('owl-carousel owl-loaded');
                $('.clients-wrapper .owl-stage-outer').children().unwrap();
            }
        }
    }

    mobileCarousel();
    $(window).resize(mobileCarousel);

});
</script>


<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- banner-swiper -->
<script>
var swiper = new Swiper(".mySwiper", {
    loop: true,

    speed: 1200, // 🔥 smooth transition speed

    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },

    slidesPerView: 1,
    spaceBetween: 0,

    effect: "slide", // default smooth slide (best for premium feel)

    grabCursor: true,

    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    }
});
</script>


</body>
</html>