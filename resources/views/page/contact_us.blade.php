@extends('layouts.app')

@section('content')
<section class="page-banner">

    <img src="{{ asset('images/image 11.png') }}" alt="Contact Banner" class="banner-image">

    <div class="banner-overlay"></div>

    <div class="container">
        <div class="banner-content">

            <h1>Contact Us</h1>

            <p>
                Ask your query with our team about the product, wholesale orders,<br>
                business partnership and customer support. 
            </p>

            <div class="breadcrumb">
                <a href="{{ route('index')}}">Home</a>
                <span>•</span>
                <span>Contact Us</span>
            </div>

        </div>
    </div>

</section>

<style>
.page-banner{
    position:relative;
    height:260px;
    display:flex;
    align-items:center;
    color:#fff;
    overflow:hidden;
}

/* Banner Image */
.banner-image{
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
    object-fit:cover;
    z-index:1;
}

/* Overlay */
.banner-overlay{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.45);
    z-index:2;
}

/* Content */
.banner-content{
    position:relative;
    z-index:3;
    max-width:600px;
}

.banner-content h1{
    font-size:40px;
    font-weight:600;
    margin-bottom:10px;
}

.banner-content p{
    font-size:14px;
    line-height:1.6;
    opacity:0.9;
    margin-bottom:15px;
}

/* Breadcrumb */
.breadcrumb{
    font-size:13px;
    display:flex;
    gap:8px;
    align-items:center;
}

.breadcrumb a{
    color:#fff;
    text-decoration:none;
}

.breadcrumb span{
    opacity:0.8;
}

/* Mobile */
@media(max-width:768px){

    .page-banner{
        height:200px;
    }

    .banner-content{
        text-align:center;
        margin:0 auto;
    }

    .banner-content h1{
        font-size:28px;
    }
}
    </style>

    <!-- MAP -->
<div class="map-section">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18..."
        allowfullscreen=""
        loading="lazy">
    </iframe>
</div>

<!-- CONTACT CARD -->
<section class="contact-section">
    <div class="contact-card">

        <!-- Left Side -->
        <div class="contact-info">

            <h2>Get in touch</h2>

            <p class="desc">
               If you have any questions or need to ask us, you can contact the
                team anytime through these modes.
            </p>

            <div class="info-item">
                 <div class="icon">
        <img src="{{ asset('images/call-calling.png') }}" alt="Phone">
    </div>
                <div>
                    <small>Mobile No.</small>
                    <h4>+91 98140 3901</h4>
                </div>
            </div>

            <div class="info-item">
                <div class="icon">
        <img src="{{ asset('images/sms-tracking.png') }}" alt="Email">
    </div>
                <div>
                    <small>Email Address</small>
                    <h4>karanpreetsinghchadha@gmail.com</h4>
                </div>
            </div>

            <div class="info-item">
                <div class="icon">
        <img src="{{ asset('images/location.png') }}" alt="Location">
    </div>
                <div>
                    <small>Location</small>
                    <h4>348, Maharaja Ranjit Singh Park
                         Backside Singar Cinema
                          Ludhiana, Punjab 141008</h4>
                </div>
            </div>

            <div class="divider"></div>

            <h5>Follow with us</h5>

           <div class="socials">

    <a href="#">
        <img src="{{ asset('images/Group 1597883784.png') }}" alt="LinkedIn">
    </a>

    <a href="#">
        <img src="{{ asset('images/Group 1597883785.png') }}" alt="Instagram">
    </a>

    <a href="#">
        <img src="{{ asset('images/Group 1597884123.png') }}" alt="Facebook">
    </a>

    <a href="#">
        <img src="{{ asset('images/Group 1597884126.png') }}" alt="Twitter">
    </a>

    <a href="#">
        <img src="{{ asset('images/Group 1597884127.png') }}" alt="YouTube">
    </a>

</div>

        </div>

        <!-- Right Side -->
        <div class="contact-form">

            <h3>Request for reply </h3>

            <p>
                The user have to enter there information.
                 Our team will establish contact with you as soon as possible.
            </p>

            <div class="row">
                <div class="field">
                    <label>First name*</label>
                    <input type="text" placeholder="Enter first name">
                </div>

                <div class="field">
                    <label>Last name*</label>
                    <input type="text" placeholder="Enter last name">
                </div>
            </div>

            <div class="field">
                <label>Email Address*</label>
                <input type="email" placeholder="Enter email address">
            </div>

            <div class="field">
                <label>Phone*</label>
                <input type="text" placeholder="Enter phone number">
            </div>

            <div class="field">
                <label>Select Categories*</label>
                <select>
                    <option>Select Your Categories</option>
                </select>
            </div>

            <div class="field">
                <label>Your message</label>
                <textarea placeholder="Write you message"></textarea>
            </div>

            <button>Submit</button>

        </div>

    </div>
</section>

<style>
    /* MAP */
.map-section{
    position: relative;
}

.map-section iframe{
    width:100%;
    height:450px;
    border:0;
    display:block;
}

/* MAIN CARD */
.contact-section{
    max-width:1100px;
    margin:-120px auto 60px;
    position:relative;
    z-index:10;
}

.contact-card{
    background:#fff;
    display:flex;
    box-shadow:0 2px 15px rgba(0,0,0,.08);
}

.contact-info{
    width: 38%;
    background: #18293B;
    color: #fff;
    padding: 40px 35px;
    height: 578px;
    margin-top: 32px;
    margin-left: 20px;
    margin-bottom: 20px;
}

.contact-info h2{
    font-size:48px;
    font-weight:700;

}

.desc{
    font-size:14px;
    line-height:1.8;
    color:#d4dbe3;

}

.info-item{
    background:#2B3E52;
    padding:8px;
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:12px;
}

.icon{
    width:38px;
    height:38px;
 
    display:flex;
    align-items:center;
    justify-content:center;
}

.info-item small{
    color:#d0d6dd;
    font-size:12px;
}

.info-item h4{
    margin-top:4px;
    font-size:17px;
    font-weight:500;
}

.divider{
    height:1px;
    background:rgba(255,255,255,.15);
    margin:30px 0;
}

.contact-info h5{
  
    font-size:16px;
}

.socials{
    display:flex;
    gap:22px;
}

.socials a{
    color:#fff;
    text-decoration:none;
}

.contact-form{
    width:62%;
    padding:25px 40px;
}

.contact-form h3{
    font-size:32px;
    font-weight:600;
    color:#1e1e1e;
}

.contact-form p{
    color:#6f6f6f;
    margin-bottom:25px;
}

.row{
    display:flex;
    gap:25px;
}

.row .field{
    flex:1;
    margin-bottom:20px;
}

.field label{
    display:block;
    margin-bottom:8px;
    font-size:13px;
    font-weight:600;
}

.field input,
.field select,
.field textarea{
    width:100%;
    border:none;
    border-bottom:1px solid #d9d9d9;
    padding:10px 0;
    outline:none;
    background:none;
}

.field textarea{
    height:80px;
    resize:none;
}

button{
    width:100%;
    height:55px;
    border:none;
    background:#C59A57;
    color:#fff;
    font-size:18px;
    font-weight:600;
    cursor:pointer;
}

@media (max-width:768px){

    .contact-section{
        margin:30px 15px;
    }

    .contact-card{
        flex-direction:column;
    }

    .contact-info,
    .contact-form{
        width:100%;
        margin:0;
        height:auto;
    }
}
</style>

<section class="newsletter">
    <div class="newsletter-content">
        <h2>New arrivals sent to your inbox.</h2>

        <p>
          Get notified via email about special deals, new looks, and the trendy arrivals. 
        </p>

        <form class="newsletter-form">
            <input
                type="email"
                placeholder="Add your email here"
            >

            <button type="submit">
                Subscribe
            </button>
        </form>
    </div>
</section>

<style>
.newsletter{
    background:#e3dbcc;
    padding:60px 20px;
}

.newsletter-content{
    max-width:700px;
    margin:auto;
    text-align:center;
}

.newsletter-content h2{
    color:#1f2e42;
    font-size:42px;
    font-weight:700;
    line-height:1.2;
    margin-bottom:10px;
}

.newsletter-content p{
    color:#4f5560;
    font-size:14px;
    margin-bottom:30px;
}

.newsletter-form{
    display:flex;
    justify-content:center;
    align-items:center;
    max-width:500px;
    margin:auto;
}

.newsletter-form input{
    flex:1;
    height:54px;
    border:none;
    outline:none;
    background:#fff;
    padding:15px;
    font-size:14px;
    color:#555;
}

.newsletter-form button{
    height:54px;
    border:none;
    background:#c69c5b;
    color:#fff;
    padding:0 35px;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.newsletter-form button:hover{
    background:#b88a48;
}

@media (max-width:768px){

    .newsletter{
        padding:50px 20px;
    }

    .newsletter-content h2{
        font-size:32px;
    }
}

@media (max-width:576px){

    .newsletter{
        padding:40px 15px;
    }

    .newsletter-content h2{
        font-size:26px;
    }

    .newsletter-content p{
        font-size:13px;
        line-height:1.6;
    }

    .newsletter-form{
        flex-direction:column;
        gap:12px;
    }

    .newsletter-form input,
    .newsletter-form button{
        width:100%;
    }

    .newsletter-form button{
        height:50px;
    }
}
    </style>

@endsection