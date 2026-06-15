@extends('layouts.app')

@section('content')
<section class="page-banner">

    <img src="{{ asset('images/image 11.png') }}" alt="Contact Banner" class="banner-image">

    <div class="banner-overlay"></div>

    <div class="container">
        <div class="banner-content">

            <h1 class="terms">Terms & Conditions</h1>

          <div class="breadcrumb">
                <a href="{{ route('index')}}">Home</a>
                <span>•</span>
                <span>Terms & Conditions</span>
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

    <div class="terms-container">

    <h2 class="term">Welcome to SR FASHIONS!</h2>

    <div class="intro">
        <p>
         By using our website and services, you agree to our policies,
          business practices, and usage guidelines. 
        </p>

        <p>
       We welcome you to SR Fashioners. If you are accessing and using the website we 
       will consider that you have agreed to the terms and conditions and are 
       also bound to it. Please be careful that you are reading the conditions before using the services.
        </p>
    </div>

    <h2 class="terms">Products & Services</h2>

    <p>
    SR Fashioners specializes in manufacturing, distribution, and wholesale supply. 
    We supply trousers, pants, and other men's bottom wear. All the information related
     to the product, its specifications and the availability can be changed but with prior notice.
    </p>

 

    <h2 class="terms">Orders</h2>

   <ul>
        <li>All orders will be subject to acceptance and availability. </li>
        <li>We have the right to deny or cancel any order at our choice.</li>
        <li>The images of the product are for reference only the product will may vary slightly.</li>
        <li>Bulk order pricing and customization requests may be subject to separate agreements.</li>
    </ul>

    <h2 class="terms">Pricing</h2>

    <ul>
        <li>All prices displayed are subject to change without notice.</li>
        <li>Taxes, shipping charges, and applicable fees may be added during the order process.</li>
        <li>Pricing errors may be corrected without prior notice.</li>
       
    </ul>

    <h2 class="terms">Payments</h2>

    <ul>
        <li>Payments must be made through approved payment methods.</li>
        <li>Orders will be processed only after payment confirmation unless otherwise agreed.</li>
    </ul>
  
    <h2 class="terms">Intellectual Property</h2>
    <p>
      All the content that is published on this website including the images, 
      the text content, the logos, designs, graphics and even the trademarks are under ownership of SR Fashioners.
       No one has the right to use it, copy it, or reproduce it without taking written permission beforehand.
    </p>

    <h2 class="terms">Liability Limitations</h2>
    <p>SR Fashioners is not responsible for any direct, indirect, incidental, or consequential damages that 
        might come up from using our website products, or services.</p>

     <h2 class="terms">Changes to Terms</h2>
    <p>We reserve the right to make changes in these Terms & Conditions at any time,  and continued use 
        of the website means you accept the updated terms too. </p>

     <h2 class="terms">Contact Us</h2>
    <p>For questions regarding these Terms & Conditions, please contact us through 
        our official communication channels.</p>

    <p class="small-text">
        Last updated: January 2026
    </p>

</div>
<style>
        .terms-container{
        max-width:1400px;
        margin:20px auto;
        padding:0 15px;
    }

      .terms h1{
        color:#ffffff;
        font-size:28px;
        font-weight:700;
        margin-bottom:10px;
    }

    .term{
        color: #b4935f !important;
        font-size:30px;
        font-weight:700;
        margin:35px 0 12px;
    }

      .terms h2{
        color:#000;
        font-size:20px;
        font-weight:700;
        margin:35px 0 12px;
    }

    p{
        margin-bottom:12px;
    }

    ul{
        margin:10px 0 15px 22px;
    }

    li{
        margin-bottom:6px;
    }

    a{
        color:#0d6efd;
        text-decoration:none;
    }

    a:hover{
        text-decoration:underline;
    }

    .intro{
        margin-bottom:25px;
    }

    .small-text{
        font-size:12px;
        color:#666;
    }  
    </style>
@endsection
