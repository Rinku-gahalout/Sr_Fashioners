<header class="top-header">
    <div class="container">
        <div class="header-wrapper">

          <!-- Logo -->
           <div class="logo-area">

             <!-- Mobile Toggle -->
            <button class="mobile-toggle" id="mobileToggle">
                <i class="fas fa-bars"></i>
            </button>

    <!-- Desktop Logo -->
<a href="{{ url('/') }}">
    <!-- Desktop Logo -->
    <img src="{{ asset('images/logo.png') }}"
         alt="Fashioners"
         class="desktop-logo">

    <!-- Mobile Logo -->
    <img src="{{ asset('images/SR final logo for mobile view.png') }}"
         alt="Fashioners"
         class="mobile-logo">
</a>

</div>
 <!-- Right Side -->
            <div class="header-icons">

                <a href="https://wa.me/919814003901" class="whatsapp-btn">
                    <i class="fab fa-whatsapp"></i>
                    +91 9814003901
                </a>

              <div class="search-wrapper">
    <input type="text" class="search-input" placeholder="Search...">

    <a href="#" id="searchToggle">
        <i class="fas fa-search"></i>
    </a>

    <a href="{{ route('user.sign.in')}}"><i class="far fa-user"></i></a>
<a href="#"><i class="far fa-heart"></i></a>
<a href="#"><i class="fas fa-shopping-cart"></i></a>
</div>


            </div>

        </div>
    </div>
</header>
<div class="overlay" id="overlay"></div>
<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">

    <!-- Top Bar -->
    <div class="menu-header">
        <img src="{{ asset('images/SR final logo for mobile view.png') }}" alt="Logo">

        <button class="close-menu" id="closeMenu">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Menu Links -->
    <ul class="menu-links">
        <li><a href="#">Home</a></li>
        <li><a href="#">Shop</a></li>
        <li><a href="#">Collection</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Contact</a></li>
    </ul>


</div>

<style>
.top-header{
    background:#efefef;
    padding:20px 0;
    position:sticky;
    top:0;
    z-index:900;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

.header-wrapper{
    position:relative;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* Desktop Logo */
.desktop-logo{
    width:140px;
}

/* Mobile Logo Hidden */
.mobile-logo{
    display:none;
}

/* Mobile Toggle */
.mobile-toggle{
    position:absolute;
    left:0;
    top:50%;
    transform:translateY(-50%);
    border:none;
    background:none;
    font-size:24px;
    color:#222;
    cursor:pointer;
    display:none;
}

.header-icons{
    position:absolute;
    right:0;
    top:0;
    text-align:center;
}

.whatsapp-btn{
    background:#53b654;
    color:#fff;
    padding:10px 20px;
    border-radius:25px;
    text-decoration:none;
    font-size:13px;
    display:inline-flex;
    align-items:center;
    gap:8px;
}

.icon-row{
    margin-top:18px;
    display:flex;
    justify-content:center;
    gap:18px;
}

.icon-row a{
    color:#222;
    font-size:16px;
}

/* Mobile Menu */
/* MENU WRAPPER */
.mobile-menu{
    position:fixed;
    top:0;
    left:-320px;
    width:300px;
    height:100%;
    background:#f5f5f5;
    z-index:9999;
    transition:0.35s ease-in-out;
    box-shadow:10px 0 30px rgba(0,0,0,0.12);
    display:flex;
    flex-direction:column;
}

/* ACTIVE STATE */
.mobile-menu.active{
    left:0;
}

/* HEADER */
.menu-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px;
    border-bottom:1px solid #583b07;
}

.menu-header img{
    height:35px;
}

.close-menu{
    background:none;
    border:none;
    font-size:20px;
    cursor:pointer;
    color:#222;
}

/* LINKS */
.menu-links{
    list-style:none;
    padding:20px;
    margin:0;
    flex:1;
}

.menu-links li{
    margin-bottom:18px;
}

.menu-links li a{
    text-decoration:none;
    font-size:16px;
    color:#222;
    font-weight:500;
    display:block;
    padding:10px 12px;
    border-radius:8px;
    transition:0.25s;
}

.menu-links li a:hover{
    background:#ffffff;
    color:#c8a05a;
    transform:translateX(5px);
}

.search-wrapper{
    position:relative;
    display:flex;
    align-items:center;
    gap: 23px;
    font-size: 23px;
    margin-top: 20px;
}

.search-input{
    width:0;
    opacity:0;
    border:none;
    outline:none;
    padding:10px 0;
    transition:all 0.4s ease;
    background:#fff;
    border-radius:25px;
    position:absolute;
    right:35px;
    top:50%;
    transform:translateY(-50%);
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

.search-wrapper.active .search-input{
    width:220px;
    opacity:1;
    padding:10px 15px;
    right: 127px;
}

.search-wrapper a{
    position:relative;
    z-index:2;
    color: #c8a05a;
}


@media (max-width:768px){

    .header-wrapper{
        display:flex;
        justify-content:space-between;
        align-items:center;
        position:relative;
    }

    /* Left Side */
    .mobile-toggle{
        display:block;
        position:static;
        transform:none;
        font-size:22px;
        margin-right:10px;
    }

    .logo-area{
        display:flex;
        align-items:center;
    }

    .desktop-logo{
        display:none;
    }

    .mobile-logo{
        display:block;
        width:45px;
    }

    .search-wrapper{
    position:relative;
    display:flex;
    align-items:center;
    gap: 23px;
    font-size: 23px;
    margin-top: 0px;
}

    /* Toggle + Logo Group */
    .logo-area{
        position:absolute;
        left:0;
        display:flex;
        align-items:center;
        gap:12px;
    }

    /* Right Icons */
    .header-icons{
        position:static;
        margin-left:auto;
    }

    .whatsapp-btn{
        display:none;
    }

    .icon-row{
        margin-top:0;
        gap:14px;
    }

    .icon-row a{
        font-size:18px;
    }

    .close-menu{
    position:absolute;
    top:15px;
    right:15px;
    background:none;
    border:none;
    font-size:22px;
    color:#222;
    cursor:pointer;
}
}
    </style>
<!-- toggle -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const menu = document.getElementById("mobileMenu");
    const toggle = document.getElementById("mobileToggle");
    const closeBtn = document.getElementById("closeMenu");
    const overlay = document.getElementById("overlay");

    function openMenu() {
        menu.classList.add("active");
        if (overlay) overlay.classList.add("active");
    }

    function closeMenu() {
        menu.classList.remove("active");
        if (overlay) overlay.classList.remove("active");
    }

    if (toggle) {
        toggle.addEventListener("click", function (e) {
            e.stopPropagation();
            openMenu();
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            closeMenu();
        });
    }

    if (overlay) {
        overlay.addEventListener("click", function () {
            closeMenu();
        });
    }

    // click outside menu (extra safety)
    document.addEventListener("click", function (e) {
        if (menu && !menu.contains(e.target) && e.target !== toggle) {
            closeMenu();
        }
    });

});
</script>

<!-- search-panel -->
 <script>
const searchToggle = document.getElementById('searchToggle');
const searchWrapper = document.querySelector('.search-wrapper');

searchToggle.addEventListener('click', function(e){
    e.preventDefault();
    searchWrapper.classList.toggle('active');
});

// Close when clicking outside
document.addEventListener('click', function(e){
    if(!searchWrapper.contains(e.target)){
        searchWrapper.classList.remove('active');
    }
});
</script>