@extends('layouts.app')

@section('content')

{{-- =====================================================
     1. HERO BANNER
     ===================================================== --}}
<section class="ab-hero">
    <img src="{{ asset('images/image 11.png') }}" alt="About Us Banner" class="ab-hero__img">
    <div class="ab-hero__overlay"></div>
    <div class="ab-hero__body">
        <h1>About Us</h1>
        <p>
           Delivering premium trousers and apparel solutions with exceptional <br>
           quality, comfort, craftsmanship, and business-focused partnerships. 
        </p>
        <nav class="ab-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('index')}}">Home</a>
            <span aria-hidden="true">•</span>
            <span>About Us</span>
        </nav>
    </div>
</section>

{{-- =====================================================
     2. ABOUT SR FASHIONS  (text left | image right)
     ===================================================== --}}
<section class="ab-about">
    
        <div class="ab-about__text">
            <h2>About SR Fashions</h2>
            <p>
               SR Fashioners is a leading trouser manufacturer and wholesale supplier based in Punjab, and 
               we stay committed to bring out quality, style, and value to apparel businesses across India.
                We cater to a big orders of men’s trousers, like formal pants and casual trousers, plus chinos, 
                cargos, that are designed based on market.
            </p>
            <p class="about-text">
              We make each piece with care and deep attention, and proper craftsmanship. We use carefully 
              selected fabrics, relaxed and comforting fits and follow finishing standards. We give attention
               on quality, sensible pricing, and on-schedule dispatch,which is what has helped us develop 
               long-lasting ties with retailers, distributors and wholesalers. 
            </p>
        </div>
    
</section>

{{-- =====================================================
     3. OUR MISSION  (image left | content right)
     ===================================================== --}}
<section class="ab-mission">
    <div class="ab-mission__image">
        <img src="{{ asset('images/image 14.png') }}" alt="Our Mission">
    </div>

    <div class="ab-mission__content">
        <h2>Our Mission</h2>

        <p>
           At SR Fashioners, our only motive is to provide trousers that are high quality. 
           We provide clothes that are comfortable, durable and perfect for modern styling. 
           We aim to help our business partners and retailers with best ranges, trend-driven 
           collections, and dependable services.We also ensure that we are holding higher level 
           of craftsmanship and ensuring the customer's comfort.
        </p>

        <div class="ab-focus">
            <strong>We focus on:</strong>
            <ul>
                <li>Premium quality fabrics</li>
                <li>Modern and versatile trouser designs</li>
                <li>Consistent product quality</li>
                <li>Comfortable fits and superior finishing</li>
                <li>Trend-driven collections</li>
                <li>Competitive wholesale pricing</li>
                <li>Timely order fulfillment</li>
                <li>Long-term business partnerships</li>
            </ul>
        </div>

        <p>
            At SR Fashions, we believe fashion is more than clothing – it is a
            reflection of confidence, grace, culture, and individuality.
        </p>

      
    </div>
</section>

{{-- =====================================================
     4. WHY CHOOSE SR FASHIONERS?
     ===================================================== --}}
<section class="ab-why">
    <div class="ab-why__inner">
        <h2>Why Choose SR Fashioners?</h2>

        <div class="ab-why__grid ab-why__grid--top">
            <div class="ab-feature">
                <h3>Extensive Product Range</h3>
                <p>We got pants ranges from casual bottoms to chinos, cargos and everyday essentials.
                   We also try to cover every type of customer.</p>
            </div>
            <div class="ab-feature">
                <h3>Trusted Quality</h3>
                <p>Every garment gets made using carefully picked fabrics, solid stitching  and strict quality checks,
                 just so it lasts a long while and performs well over time.</p>
            </div>
            <div class="ab-feature">
                <h3>Best Wholesale Prices</h3>
                <p>Our efficient manufacturing and sourcing capabilities, allow us deliver exceptional value,
                     without really compromising on quality.</p>
            </div>
        </div>

        <div class="ab-why__grid ab-why__grid--bottom">
            <div class="ab-feature">
                <h3>Collection Focused on Trend</h3>
                <p>Our team members constantly monitor the trends of the market and then bring fresh 
                    designs and styles to the market, which customers will love.</p>
            </div>
            <div class="ab-feature">
                <h3>Authentic Business Partner </h3>
                <p>Our team treats every order like it’s a top priority and we make sure the delivery is
                     timely, with clear communication transparency.
                     We help the retailer and distributor in smooth operation.</p>
            </div>
        </div>
    </div>
</section>

{{-- =====================================================
     ALL STYLES
     ===================================================== --}}
<style>

/* ── Base reset ─────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* =====================================================
   1. HERO BANNER
   ===================================================== */
.ab-hero {
    position: relative;
    height: 280px;
    display: flex;
    align-items: center;
    color: #fff;
    overflow: hidden;
}

.ab-hero__img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 1;
}

.ab-hero__overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.52);
    z-index: 2;
}

.ab-hero__body {
    position: relative;
    z-index: 3;
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
    padding: 0 40px;
}

.ab-hero__body h1 {
    font-size: clamp(28px, 4vw, 42px);
    font-weight: 700;
    margin-bottom: 10px;
    line-height: 1.15;
}

.ab-hero__body p {
    font-size: 14px;
    line-height: 1.7;
    opacity: 0.92;
    margin-bottom: 14px;
}

/* Breadcrumb */
.ab-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
}

.ab-breadcrumb a {
    color: #fff;
    text-decoration: none;
}

.ab-breadcrumb a:hover { text-decoration: underline; }

.ab-breadcrumb span { opacity: 0.85; }

@media (max-width: 768px) {
    .ab-hero { height: 220px; }
    .ab-hero__body { padding: 0 20px; text-align: left; }
}

/* =====================================================
   2. ABOUT SR FASHIONS
   ===================================================== */
.ab-about {
    position: relative;
    max-width: 1440px;
    margin: 0 auto;
    height: 707px;
    background-image: url('../images/about.png');
    background-position: center;
    background-repeat: no-repeat;
    background-size: 100% auto;
    border-radius: 0 0 80px 0;
}

.about-text {
    font-size: 20px;
    line-height: 1.8;
    margin-bottom: 15px;
    color: #212529;
    margin-top:10px!important;
}


.ab-about__text {
    max-width: 700px;
    padding: 60px;
    color: #fff;
}

.ab-about__text h2 {
    font-size: 34px;
    font-weight: 700;
    color: #d8b07a;
    margin-bottom: 20px;
    margin-top: -15px;
}

.ab-about__text p {
  font-size: 20px;
    line-height: 1.8;
    margin-bottom: 15px;
    color: #212529;
    margin-top: 60px;
}

@media (max-width: 768px) {
    .ab-about {
        min-height: 450px;
        border-radius: 0 0 40px 0;
    }

    .ab-about__overlay {
        min-height: 450px;
    }

    .ab-about__text {
        padding: 30px 20px;
    }

    .ab-about__text h2 {
        font-size: 28px;
    }

    .ab-about__text p {
        font-size: 16px;
        margin-top: 61px;

    }
}

@media (max-width: 480px) {
    .ab-about {
    position: relative;
    max-width: 1440px;
    margin: 0 auto;
    height: 0px!important;
    background-image: url(../images/about.png);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 0 0 80px 0;
 }

    .ab-about__overlay {
        min-height: 400px;
    }

    .ab-about__text h2 {
        font-size: 24px;
    }

    .ab-about__text p {
        font-size: 15px;
        line-height: 1.6;
    }
}

/* =====================================================
   3. OUR MISSION
   ===================================================== */
.ab-mission {
    display: flex;
    align-items: flex-start;
    gap: 50px;
    max-width: 1200px;
    margin: 60px auto;
    padding: 0 30px;
}

.ab-mission__image {
    flex: 0 0 38%;
    max-width: 420px;
}

.ab-mission__image img {
    width: 100%;
    height: 633px;
    display: block;
    object-fit: cover;
}

.ab-mission__content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 16px;
    padding-top: 4px;
}

.ab-mission__content h2 {
    font-size: clamp(22px, 3vw, 30px);
    font-weight: 700;
    color: #b48a4d;
    line-height: 1.1;
}

.ab-mission__content p {
    font-size: clamp(15px, 1.6vw, 18px);
    color: #333;
    line-height: 1.7;
}

.ab-focus strong {
    display: block;
    font-size: clamp(15px, 1.6vw, 18px);
    color: #333;
    font-weight: 600;
    margin-bottom: 10px;
}

.ab-focus ul {
    list-style: disc;
    padding-left: 20px;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.ab-focus li {
    font-size: clamp(14px, 1.5vw, 17px);
    color: #444;
    line-height: 1.6;
}

@media (max-width: 900px) {
    .ab-mission {
        flex-direction: column;
        gap: 30px;
        padding: 0 20px;
        margin: 40px auto;
    }

    .ab-mission__image {
        flex: none;
        max-width: 100%;
        width: 100%;
    }

    .ab-mission__image img { max-width: 420px; margin: 0 auto; }
}

@media (max-width: 480px) {
    .ab-mission { padding: 0 14px; margin: 30px auto; }
}

/* =====================================================
   4. WHY CHOOSE SR FASHIONERS?
   ===================================================== */
.ab-why {
    background: #f4f2ef;
    padding: 50px 20px 60px;
}

.ab-why__inner {
    max-width: 1100px;
    margin: 0 auto;
}

.ab-why h2 {
    text-align: center;
    font-size: clamp(22px, 3vw, 30px);
    font-weight: 700;
    color: #bc9458;
    margin-bottom: 30px;
}

/* 3-col top row */
.ab-why__grid {
    display: grid;
    gap: 20px;
}

.ab-why__grid--top {
    grid-template-columns: repeat(3, 1fr);
    margin-bottom: 20px;
}

/* 2-col bottom row — centred */
.ab-why__grid--bottom {
    grid-template-columns: repeat(2, 1fr);
    max-width: calc((100% / 3) * 2 + 20px);  /* same width as 2 columns of top row */
    margin: 0 auto;
}

/* Feature card */
.ab-feature {
    border: 1px solid #d9c2a0;
    background: transparent;
    padding: 18px 16px;
    text-align: center;
}

.ab-feature h3 {
    font-size: clamp(15px, 1.6vw, 18px);
    font-weight: 700;
    color: #2f3640;
    line-height: 1.4;
    margin-bottom: 8px;
}

.ab-feature p {
    font-size: clamp(13px, 1.3vw, 15px);
    color: #555;
    line-height: 1.6;
}

/* Responsive: tablet → 2 col for all */
@media (max-width: 900px) {
    .ab-why__grid--top {
        grid-template-columns: repeat(2, 1fr);
    }

    .ab-why__grid--bottom {
        grid-template-columns: repeat(2, 1fr);
        max-width: 100%;
    }
}

/* Mobile: single column */
@media (max-width: 560px) {
    .ab-why { padding: 36px 14px 40px; }

    .ab-why__grid--top,
    .ab-why__grid--bottom {
        grid-template-columns: 1fr;
        max-width: 420px;
        margin-left: auto;
        margin-right: auto;
    }

    .ab-why__grid--top { margin-bottom: 0; }
    .ab-why__grid--bottom { margin-top: 0; }
}

</style>

@endsection
