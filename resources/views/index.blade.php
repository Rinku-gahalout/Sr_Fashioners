@extends('layouts.app')

@section('content')
    <section class="hero-banner swiper mySwiper">

        <div class="swiper-wrapper">

            <!-- Slide 1 -->
            <div class="swiper-slide">
                <img src="{{ asset('images/banner.png') }}" class="banner-image">

                <div class="hero-overlay"></div>

                <div class="hero-content">
                    <h1>The Fall Collection</h1>
                    <p>
                        Fashion plays an important role in people's lives.
                        The way people dress expresses individuality and personality.
                    </p>
                    <a href="#" class="explore-btn">Explore</a>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide">
                <img src="{{ asset('images/banner.png') }}" class="banner-image">

                <div class="hero-overlay"></div>

                <div class="hero-content">
                    <h1>New Arrivals</h1>
                    <p>Discover the latest trends in modern fashion collection.</p>
                    <a href="#" class="explore-btn">Explore</a>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="swiper-slide">
                <img src="{{ asset('images/banner.png') }}" class="banner-image">

                <div class="hero-overlay"></div>

                <div class="hero-content">
                    <h1>Winter Collection</h1>
                    <p>Premium styles designed for comfort and elegance.</p>
                    <a href="#" class="explore-btn">Explore</a>
                </div>
            </div>

        </div>

        <!-- Dots -->
        <div class="swiper-pagination"></div>

    </section>

    <style>
        .hero-banner {
            position: relative;
            width: 100%;
            height: 550px !important;
            overflow: hidden;
        }

        .banner-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.30);
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            text-align: center;
            color: #fff;
            width: 80%;
            max-width: 800px;
        }

        .hero-content h1 {
            font-size: 64px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-content p {
            font-size: 15px;
            line-height: 1.8;
            margin-bottom: 25px;
        }

        .explore-btn {
            display: inline-block;
            background: #c8a05a;
            color: #fff;
            padding: 12px 50px;
            text-decoration: none;
            font-weight: 600;
        }

        .slider-dots {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
        }

        .slider-dots span {
            width: 6px;
            height: 6px;
            background: white;
            border-radius: 50%;
            display: inline-block;
            margin: 0 4px;
            opacity: 0.5;
        }

        .slider-dots .active {
            background: #c8a05a;
            opacity: 1;
        }

        .swiper-slide {
            position: relative;
        }

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-wrapper {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        /* dots */
        .swiper-pagination-bullet {
            background: #fff !important;
            opacity: 0.5;
        }

        .swiper-pagination-bullet-active {
            background: #c8a05a !important;
            opacity: 1;
        }

        @media (max-width: 768px) {

            .hero-banner {
                height: 450px;
            }

            .hero-overlay {
                background: rgba(0, 0, 0, 0.35);
            }

            .hero-content {
                width: 85%;
                max-width: 600px;
                padding: 0 20px;
            }

            .hero-content h1 {
                font-size: 48px;
                line-height: 1.15;
                margin-bottom: 16px;
            }

            .hero-content p {
                font-size: 14px;
                line-height: 1.7;
                max-width: 520px;
                margin: 0 auto 20px;
            }

            .explore-btn {
                padding: 12px 36px;
                font-size: 14px;
            }

            .slider-dots {
                bottom: 18px;
            }

            .slider-dots span {
                width: 8px;
                height: 8px;
                margin: 0 5px;
            }
        }
    </style>

    <div class="cloth-banner">
   
 
    <div class="countdown">
 
    <div class="event-title">Annual sale event</div>
    <div class="count">
        <div class="time-box">
            <div class="number">7</div>
            <div class="label">Days</div>
        </div>
 
        <div class="time-box">
            <div class="number">13</div>
            <div class="label">Hours</div>
        </div>
 
        <div class="time-box">
            <div class="number">27</div>
            <div class="label">Minutes</div>
        </div>
 
        <div class="time-box">
            <div class="number">14</div>
            <div class="label">Seconds</div>
        </div>
</div>
        <button class="notify-btn">Get notified</button>
    </div>
 
   </div>
 
<style>
.cloth-banner{
    background:#182739;
    border:1px solid #3b4a5b;
    color:#fff;
    height:70px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 20px;
   }
 
.event-title{
    font-size:16px;
    font-weight:500;
    white-space:nowrap;
}
 
.countdown{
    display:flex;
    align-items:center;
    flex:1;
    justify-content:center;
    gap: 69px;
}
 
.count {
    display: flex;
    align-items: center;
    justify-content: center;
}
 
.time-box{
    text-align:center;
    min-width:70px;
    position:relative;
}
 
.time-box:not(:last-child)::after{
    content:"";
    position:absolute;
    right:0;
    top:50%;
    transform:translateY(-50%);
    width:1px;
    height:36px;
    background:rgba(255,255,255,0.2);
}
 
.number{
    font-size:18px;
    font-weight:700;
    line-height:1;
    margin-bottom:4px;
}
 
.label{
    font-size:11px;
    color:#c7d0db;
}
 
.notify-btn{
    background:#c7903d;
    color:#fff;
    border:none;
    padding:10px 18px;
    cursor:pointer;
    font-size:13px;
    border-radius:2px;
    transition:0.3s;
}
 
.notify-btn:hover{
    background:#b27f34;
}
 
@media (max-width: 768px) {
 
    .banner{
        height: auto;
        padding: 15px;
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
 
    .cloth-banner {
    background: #182739;
    border: 1px solid #3b4a5b;
    color: #fff;
    height:auto;
    display: grid;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px;
    justify-content: center;
    gap: 10px;
}
 
   .event-title{
    font-size: 26px !important;
    font-weight: 500;
    white-space: nowrap;
    margin-bottom: 10px;
    text-align:center;
    }
 
    .countdown{
        display: block;
        width: 100%;
        justify-content: space-between;
        gap: 60px;
    }
 
    .time-box{
        flex: 1;
        min-width: auto;
    }
 
    .time-box:not(:last-child)::after{
        height: 30px;
        right: 10px;
 
    }
 
    .number{
        font-size: 16px;
    }
 
    .label{
        font-size: 10px;
    }
 
    .notify-btn{
        width: 303px;
        margin-top: 10px;
        padding: 12px;
    }
}
    </style>

    <section class="cotton-pants">
        <div class="section-header">
            <h2>Cotton Pants</h2>

            <a href="{{ route('list', ['category' => 'cotton']) }}" class="view-all">
                View All
                <span>→</span>
            </a>
        </div>

        <div class="gallery-grid">
            @foreach ($cottonProducts as $index => $product)
                <div class="grid-item {{ $index == 0 ? 'large' : '' }}">
                    <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}">
                </div>
            @endforeach
        </div>
    </section>

    <style>
        .cotton-pants {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 28px;
            color: #b38b59;
            font-weight: 600;
        }

        .view-all {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #222;
            font-size: 14px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            grid-template-rows: 250px 250px;
            gap: 12px;
            background: #efe9df;
            padding: 12px;
        }

        .large {
            grid-row: span 2;
        }

        .grid-item {
            position: relative;
            overflow: hidden;
            background: #ddd;
        }

        .grid-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;

            transition: transform 0.6s ease;
        }

        /* Zoom Effect */
        .grid-item:hover img {
            transform: scale(1.12);
        }

        .grid-item::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0);
            transition: 0.4s;
        }

        .grid-item:hover::after {
            background: rgba(0, 0, 0, 0.08);
        }

        .grid-item:hover img {
            transform: scale(1.15);
        }

        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: auto;
            }

            .large {
                grid-column: span 2;
                grid-row: span 1;
                height: 350px;
            }

            .grid-item {
                height: 180px;
            }
        }
    </style>

    <section class="travel-series">
        <div class="heading">
            <h2>Travel Series Pants</h2>

            <a href="{{ route('list', ['category' => $travelProducts->first()?->category?->slug]) }}" class="view-all">
                View All
                <span>→</span>
            </a>
        </div>

        <div class="travel-grid">
            @foreach ($travelProducts as $product)
                <div class="card">
                    <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}">
                </div>
            @endforeach
        </div>
    </section>

    <style>
        .travel-series {
            max-width: 1200px;
            margin: auto;
            padding: 40px 20px;
        }

        .heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .heading h2 {
            font-size: 28px;
            color: #b28c57;
            font-weight: 600;
        }

        .view-all {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #222;
            font-size: 14px;
        }

        .travel-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        /* Top images */

        .card {
            height: 340px;
            overflow: hidden;
            background: #eee;
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .7s ease;
        }

        .card:hover img {
            transform: scale(1.12);
        }

        /* Bottom banners */

        .banner {
            grid-column: span 2;
            height: 180px;
            overflow: hidden;
            background: #eee;
        }

        .banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .7s ease;
        }

        .banner:hover img {
            transform: scale(1.12);
        }

        .card,
        .banner {
            overflow: hidden;
        }

        .card img,
        .banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .card:hover img,
        .banner:hover img {
            transform: scale(1.12);
        }

        /* Tablet & Mobile (768px and below) */
        @media (max-width:768px) {

            .travel-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .card {
                height: 260px;
            }

            .banner {
                grid-column: span 2;
                height: 150px;
            }

            .heading h2 {
                font-size: 22px;
            }
        }
    </style>

    <section class="formal-pants">
        <div class="section-header">
            <h2>Formal Pants</h2>

            <a href="{{ route('list', ['category' => $formalProducts->first()?->category?->slug]) }}" class="view-all">
                View All
                <span>→</span>
            </a>
        </div>

        <div class="formal-grid">
            @foreach ($formalProducts as $product)
                <div class="item">
                    <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}">
                </div>
            @endforeach
        </div>
    </section>

    <style>
        .formal-pants {
            max-width: 1200px;
            margin: auto;
            padding: 40px 20px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            color: #b68b57;
            font-size: 28px;
            font-weight: 600;
        }

        .view-all {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* GRID */

        .formal-grid {
            background: #efe9df;
            padding: 12px;

            display: grid;
            grid-template-columns: 1fr 2.4fr 1fr;
            grid-template-rows: 200px 200px;
            gap: 12px;
        }

        .center {
            grid-column: 2;
            grid-row: 1 / span 2;
        }

        .left-top {
            grid-column: 1;
            grid-row: 1;
        }

        .left-bottom {
            grid-column: 1;
            grid-row: 2;
        }

        .right-top {
            grid-column: 3;
            grid-row: 1;
        }

        .right-bottom {
            grid-column: 3;
            grid-row: 2;
        }

        /* IMAGE EFFECT */

        .item {
            overflow: hidden;
            position: relative;
        }

        .item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;

            transition: transform .7s ease;
        }

        .item:hover img {
            transform: scale(1.12);
        }

        /* Optional luxury overlay */

        .item::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0);
            transition: .4s;
        }

        .item:hover::after {
            background: rgba(0, 0, 0, .05);
        }

        @media (max-width: 768px) {

            .formal-pants {
                padding: 30px 16px;
            }

            .section-header h2 {
                font-size: 24px;
            }

            .formal-grid {
                grid-template-columns: 1fr 1fr;
                grid-template-areas:

                    "left-top left-bottom"
                    "center center"
                    "right-top right-bottom";
                gap: 10px;
            }

            .center {
                grid-area: center;
                height: 188px;
            }

            /* Remaining images */
            .left-top {
                grid-area: left-top;
                height: 180px;
            }

            .left-bottom {
                grid-area: left-bottom;
                height: 180px;
            }

            .right-top {
                grid-area: right-top;
                height: 180px;
            }

            .right-bottom {
                grid-area: right-bottom;
                height: 180px;
            }

            .item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }
    </style>

    <section class="shorts-section">
        <div class="section-header">
            <h2>Shorts/Nickers</h2>
            <a href="{{ route('list', ['category' => $shortsProducts->first()?->category?->slug]) }}" class="view-all">
                View All
                <span>→</span>
            </a>
        </div>

        <div class="products-grid">
            @foreach ($shortsProducts as $product)
                <div class="product-card">
                    <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}">
                </div>
            @endforeach
        </div>
    </section>

    <style>
        .shorts-section {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 26px;
            font-weight: 600;
            color: #b48a5a;
        }

        .view-all {
            text-decoration: none;
            color: #333;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .view-all span {
            font-size: 20px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .product-card {
            background: #f5f5f5;
            aspect-ratio: 1/1;
            overflow: hidden;
        }

        .product-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .product-card {
            background: #f4f4f4;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .product-card img {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover {
            transform: translateY(-3px);
        }

        .product-card:hover img {
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .shorts-section {
                padding: 0 12px;
                margin: 24px auto;
            }

            .section-header {
                margin-bottom: 14px;
            }

            .section-header h2 {
                font-size: 18px;
            }

            .view-all {
                font-size: 13px;
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
        }
    </style>

    <section class="denim-section">
        <div class="section-header">
            <h2>Denim - Only Special Black</h2>
            <a href="{{ route('list', ['category' => $denimProducts->first()?->category?->slug]) }}">
                View All →
            </a>
        </div>

        <div class="denim-grid">
            @foreach ($denimProducts as $product)
                <div class="item">
                    <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}">
                </div>
            @endforeach
        </div>
    </section>

    <style>
        .denim-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            background: #fff;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-header h2 {
            font-size: 28px;
            font-weight: 600;
            color: #a88345;
            margin: 0;
        }

        .section-header a {
            color: #222;
            text-decoration: none;
            font-size: 16px;
        }

        .denim-grid {
            display: grid;
            grid-template-columns: 1.8fr 1fr 1fr;
            grid-template-rows: 260px 260px;
            gap: 20px;
        }

        .item {
            overflow: hidden;
            background: #f4f4f4;
        }

        .item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Top large image */
        .large-left {
            grid-column: 1 / 3;
            grid-row: 1;
        }

        /* Right column top */
        .top-right {
            grid-column: 3;
            grid-row: 1;
        }

        /* Right column bottom */
        .middle-right {
            grid-column: 3;
            grid-row: 2;
        }

        /* Bottom left small */
        .bottom-left {
            grid-column: 1;
            grid-row: 2;
        }

        /* Bottom center small */
        .bottom-center {
            grid-column: 2;
            grid-row: 2;
        }

        /* Large bottom-right image */
        .bottom-right {
            grid-column: 3;
            grid-row: 2;
        }

        /* Tablet */
        @media (max-width: 768px) {
            .denim-section {
                padding: 30px 15px;
            }

            .section-header h2 {
                font-size: 22px;
            }

            .section-header a {
                font-size: 14px;
            }

            .denim-grid {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: auto;
                gap: 15px;
            }

            /* Large image full width */
            .large-left {
                grid-column: 1 / -1;
                grid-row: auto;
                height: 320px;
            }

            /* Remaining images */
            .top-right,
            .middle-right,
            .bottom-left,
            .bottom-center,
            .bottom-right {
                grid-column: auto;
                grid-row: auto;
                height: 220px;
            }

            .item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }
    </style>


    <section class="clients-section">
        <div class="container">
            <h2 class="section-title">Our Clients</h2>

            <div class="clients-wrapper owl-carousel">
                <div class="client-item">
                    <img src="{{ asset('images/Group 74.png') }}" alt="Client 1">
                </div>

                <div class="client-item">
                    <img src="{{ asset('images/Group 1597885125.png') }}" alt="Client 2">
                </div>

                <div class="client-item">
                    <img src="{{ asset('images/Group 74.png') }}" alt="Client 3">
                </div>
            </div>
        </div>
    </section>

    <style>
        .clients-section {
            padding: 50px 0;
            background: #f7f7f7;
            text-align: center;
        }

        .section-title {
            color: #b08a4a;
            font-size: 38px;
            font-weight: 600;
            margin-bottom: 40px;
        }

        /* Desktop Layout */
        .clients-wrapper {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .client-item {
            border: 1px solid #d7b17a;
            background: #c8a05a5c;
            height: 155px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .client-item img {
            max-width: 100%;
            max-height: 90px;
            object-fit: contain;
        }

        /* Desktop width */
        @media (min-width: 768px) {
            .client-item {
                flex: 1;
                max-width: 360px;
            }
        }

        /* Mobile */
        @media (max-width: 767px) {
            .clients-wrapper {
                display: block;
            }

            .client-item {
                margin: 0 10px;
            }

            .section-title {
                font-size: 28px;
                margin-bottom: 25px;
            }
        }
    </style>

    <section class="newsletter">
        <div class="newsletter-content">
            <h2>Special offers and free giveaways?</h2>

            <p>
                Tap your email down below and get new notifications
                about Fashion
            </p>

            <form class="newsletter-form">
                <input type="email" placeholder="Add your email here">

                <button type="submit">
                    Subscribe
                </button>
            </form>
        </div>
    </section>

    <style>
        .newsletter {
            background: #e3dbcc;
            padding: 60px 20px;
        }

        .newsletter-content {
            max-width: 700px;
            margin: auto;
            text-align: center;
        }

        .newsletter-content h2 {
            color: #1f2e42;
            font-size: 42px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 10px;
        }

        .newsletter-content p {
            color: #4f5560;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .newsletter-form {
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 500px;
            margin: auto;
        }

        .newsletter-form input {
            flex: 1;
            height: 54px;
            border: none;
            outline: none;
            background: #fff;
            padding: 15px;
            font-size: 14px;
            color: #555;
        }

        .newsletter-form button {
            height: 54px;
            border: none;
            background: #c69c5b;
            color: #fff;
            padding: 0 35px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        .newsletter-form button:hover {
            background: #b88a48;
        }

        @media (max-width:768px) {

            .newsletter {
                padding: 50px 20px;
            }

            .newsletter-content h2 {
                font-size: 32px;
            }
        }

        @media (max-width:576px) {

            .newsletter {
                padding: 40px 15px;
            }

            .newsletter-content h2 {
                font-size: 26px;
            }

            .newsletter-content p {
                font-size: 13px;
                line-height: 1.6;
            }

            .newsletter-form {
                flex-direction: column;
                gap: 12px;
            }

            .newsletter-form input,
            .newsletter-form button {
                width: 100%;
            }

            .newsletter-form button {
                height: 50px;
            }
        }
    </style>
@endsection
