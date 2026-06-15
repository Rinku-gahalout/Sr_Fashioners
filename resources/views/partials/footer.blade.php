<footer class="fashion-footer">
    <div class="footer-container">

        <div class="footer-top">

            <!-- Logo -->
<div class="footer-logo">
    <a href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Fashioners">
    </a>
</div>
            <!-- Menu -->
            <div class="footer-menu">
                <a href="{{ route('about.us')}}">About</a>
                <a href="{{ route('contact.us')}}">Contact Us</a>
                <a href="#">Blogs</a>
            </div>

            <!-- Contact Info -->
            <div class="footer-contact">

                <div class="contact-item">
                    <i class="fa-solid fa-phone"></i>
                    <span>+91 9810403901</span>
                </div>

                <div class="contact-item">
                    <i class="fa-regular fa-envelope"></i>
                    <span>kargentreasinchoadha@gmail.com</span>
                </div>

                <div class="contact-item address">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>
                        348, Maharaja Ranjit Singh Park<br>
                        Backside Singar Cinema<br>
                        Ludhiana, Punjab 141008
                    </span>
                </div>

            </div>

        </div>

        <div class="footer-divider"></div>

        <div class="footer-bottom">
            <div>© 2026 All Rights Reserved.</div>

            <div class="footer-links">
                <a href="{{ route('privacy.policy')}}">Privacy Policy</a>
                <a href="{{ route('term.condition')}}">Terms & Condition</a>
                <a href="{{ route('refund.policy')}}">Refund Policy</a>
            </div>
        </div>

    </div>
</footer>

<style>
.footer-container{
        max-width: 1200px;
        margin: 40px auto;
    }

.fashion-footer {
    background: #f4f4f4;
    padding: 30px 0 15px;
    font-family: 'Poppins', sans-serif;
}

.footer-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.footer-logo img {
    width: 212px;
}

.footer-menu {
    display: flex;
    gap: 35px;
    margin-top: 35px;
}

.footer-menu a {
    color: #333;
    text-decoration: none;
    font-size: 20px;
    font-weight: 400;
}

.footer-contact {
    max-width: 280px;
}

.contact-item {
    display: flex;
    gap: 10px;
    margin-bottom: 12px;
    font-size: 20px;
    color: #444;
    line-height: 1.6;
}

.contact-item i {
    color: #b08a4a;
    margin-top: 3px;
}

.address {
    align-items: flex-start;
}

.footer-divider {
    border-top: 1px solid #cfcfcf;
    margin: 25px 0 12px;
}

.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 18px;
    color: #666;
}

.footer-links {
    display: flex;
    gap: 30px;
}

.footer-links a {
    color: #666;
    text-decoration: none;
}

@media (max-width: 768px) {

    .fashion-footer{
        padding: 20px;
    }

    .footer-container{
        margin: 0;
        padding: 0 12px;
    }

    .footer-top{
        display: block;
    }

    /* Logo */
    .footer-logo{
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 2px solid #d9d9d9;
        padding-bottom: 18px;
    }

    .footer-logo img{
        width: 130px;
    }

    /* Quick Links */
    .footer-menu{
        display: block;
        margin: 0;
        text-align: left;
        padding-bottom: 18px;
        border-bottom: 2px solid #d9d9d9;
    }

    .footer-menu::before{
        content: "Quick Links";
        display: block;
        font-size: 22px;
        font-weight: 600;
        color: #111;
        margin-bottom: 15px;
    }

    .footer-menu a{
        display: block;
        font-size: 18px;
        color: #444;
        margin-bottom: 12px;
    }

    /* Contact */
    .footer-contact{
        max-width: 100%;
        margin-top: 18px;
        padding-bottom: 18px;
        border-bottom: 2px solid #d9d9d9;
    }

    .footer-contact::before{
        content: "Contact Us";
        display: block;
        font-size: 22px;
        font-weight: 600;
        color: #111;
        margin-bottom: 15px;
    }

    .contact-item{
        font-size: 18px;
        margin-bottom: 12px;
        line-height: 1.5;
    }

    .contact-item i{
        width: 18px;
        margin-top: 2px;
    }

    .footer-divider{
        display: none;
    }

    /* Bottom */
    .footer-bottom{
        display: block;
        text-align: center;
        padding-top: 15px;
    }

    .footer-bottom > div:first-child{
        font-size: 16px;
        color: #666;
        margin-bottom: 12px;
    }

    .footer-links{
        display: flex;
        justify-content: space-between;
        gap: 0;
    }

    .footer-links a{
        font-size: 16px;
        color: #666;
    }
}
    </style>