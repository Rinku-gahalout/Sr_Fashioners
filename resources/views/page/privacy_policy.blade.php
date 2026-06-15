@extends('layouts.app')

@section('content')
<section class="page-banner">

    <img src="{{ asset('images/image 11.png') }}" alt="Contact Banner" class="banner-image">

    <div class="banner-overlay"></div>

    <div class="container">
        <div class="banner-content">

            <h1>Privacy Policy</h1>

           <div class="breadcrumb">
                <a href="{{ route('index')}}">Home</a>
                <span>•</span>
                <span>Privacy Policy</span>
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
            We prioritize your privacy. Here you will get
             to know how we collect the information and how we handle it.
        </p>

        <p>
            SR Fashioners knows that privacy is important, 
            and we never perform or intend to perform wrongful acts
             with the customer information. We value the personal information
              of the customer and are committed to protecting the information.
               Here we have explained how we collect, use, and safeguard the information.
        </p>
    </div>

    <h2 class="terms">Information We Collect</h2>

    <p>
       We may collect the following information:
    </p>

    <ul>
    <li>Name</li>
    <li>Phone number</li>
    <li>Email address</li>
    <li>Business information</li>
    <li>Shipping and billing details</li>
    <li>Any information submitted through contact or inquiry forms</li>
</ul>

    <h2 class="terms">How We Use Your Information</h2>

    <p>
  The information collected may be used to:
    </p>

     <ul>
    <li>Process inquiries and orders</li>
    <li>Provide customer support</li>
    <li>Improve our products and services</li>
    <li>Share important updates and business communications</li>
    <li>Maintain business records and compliance requirements</li>
    
</ul>

    <h2 class="terms">Information Security</h2>
    <p>
      We provide appropriate security at our website to protect each and 
      every information added on the website from any kind of unauthorized
       access, disclosure, and misuse. 
    </p>

    <h2 class="terms">Sharing of Information </h2>

    <p>
       We don't sell, rent, or trade the information of the customer
        or any third party. This information will only be shared to the trusted service provider only in cases 
       where the transfer is necessary to fulfill any business operations and compliance of legal requirements. 
    </p>

      <h2 class="terms">Cookies</h2>

    <p>
   We take the help of cookies and similar technologies to improve the user experience,
    analyze the website's traffic and enhance the functionality of the website.
    </p>

   

    <h2 class="terms">Third-Party Links</h2>

    <p>
    You can find the links to external websites on our website.
     We are not responsible for the privacy practices or content of third-party websites.
    </p>

   <h2 class="terms">Your Rights</h2>
    <p>The consumers have the right to access the details and personal information, to modify or correct it,
         or to delete the personal information. You have to contact the team directly.</p>

      <h2 class="terms">Modification of Policy</h2>
    <p>SR Fashioners has the right to update the regulations given in the privacy policy at any time.
         Any changes in the privacy policy will be effective after they are posted on the page.</p>

      <h2 class="terms">Contact Us</h2>
    <p>If you have confusion and questions related to the privacy policy of this site, or you want to know more about 
        how the information is taken care of then you can contact the official 
        site, email id, or the customer support.</p>

         <p class="small-text">
        Last updated:  2026
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