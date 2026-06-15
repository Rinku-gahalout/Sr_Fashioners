@extends('layouts.app')

@section('content')
<section class="page-banner">

    <img src="{{ asset('images/image 11.png') }}" alt="Contact Banner" class="banner-image">

    <div class="banner-overlay"></div>

    <div class="container">
        <div class="banner-content">

            <h1 class="terms">B2B Refund & Cancellation Policy</h1>

          <div class="breadcrumb">
                <a href="{{ route('index')}}">Home</a>
                <span>•</span>
                <span>B2B Refund & Cancellation Policy</span>
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

    <h2 class="term">B2B Refund & Cancellation Policy</h2>

<h2 class="terms">Order Cancellation</h2>

    <p>
    The customer can cancel the order before production and dispatch start. After processing the order,
     the completion of manufacturing, or shipping, the cancellation request are not being accepted
    </p>

 

    <h2 class="terms">Damaged Products</h2>

  <p>If you have received the product but it is damaged or in defective condition,
     then you must file the complaint for it in specified time period with 
    supporting proofs. The team will replace the items with the same product.</p>

    <h2 class="terms">Missing Products</h2>

   <p>If you receive the order but it is fewer in number, then the customer can file
     a report about missing items. Just provide the order receipts and other required documents, 
    and the team will contact you. They will provide a refund or provide the missing items as per the needs.</p>

    <h2 class="terms">Refund Eligibility</h2>

  <p>Refunds are provided only for verified missing items or cases where a replacement
     cannot be arranged. Approved refunds will be processed through 
    the original payment method within a reasonable timeframe.</p>
  
    <h2 class="terms">What is the refund policy?</h2>
    <p>
We have explained the regulations of refunds in this policy. Here we have provided 
the conditions under which a refund, replacement, or exchange is available. So the consumers can
 understand the regulations very clearly and know when they are eligible for a refund.
    </p>

    <h2 class="terms">Eligibility for refunds</h2>
<ul>
    <li>Order cancellation terms</li>
    <li>Damaged or defective products</li>
    <li>Missing items in shipments</li>
    <li>Time limits for reporting issues</li>
    <li>Refund processing methods and timelines</li>
    <li>Situations where refunds are not allowed<br>Example:</li>
    <li>The customers will get refund for the verified missing products.</li>
    <li>If you have received a product that is damaged the company will exchange it or replace it.</li>
    <li>The orders cannot be canceled after completion of production and dispatch. </li>
    <li>The request for refund must be submitted within the specified period after delivery. </li>
    <li>If you have a custom-made order or order that is bulk-manufactured, it is non-refundable unless the items are defective. </li>
</ul>
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