<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SEDI</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png" rel="app') }}le-touch-icon">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,400,500,600,700" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/temposdusmus-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('fonts/fontawesome.min.css') }}">
  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex align-items-center">
      <a href="{{ url('/') }}" class="logo me-auto"><img src="{{ asset('assets/img/sedi_logo.png') }}" alt="" class="img-fluid"></a>
      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#services">Features</a></li>
          <li><a class="nav-link scrollto " href="#applications">Applications</a></li>
          <li><a class="nav-link scrollto" href="#contact-us" data-toggle="modal" data-target="#myModal">Contact Us</a></li>
          @guest
          {{-- <li><a class="nav-link" href="{{ route('login') }}">Login</a></li> --}}
          @endguest
          @auth
          {{-- <li><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li> --}}
          @endauth
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
    </div>
  </header>
  <section id="hero" class="clearfix">
    <!-- <div class="container d-flex h-100"> -->
        <div>
        <img src="{{ asset('assets/img/logo3.png') }}" height="100" width="115" class="center" style="margin-top: -20px;" />  
</div>
<div>
        <img src="{{ asset('assets/img/sedi_plus.png') }}" height="100" width="315" class="center" style="margin-top: -10px;" />
      </div>
        <header class="section-header">
          <h5 style="text-align: center; margin-top: 10px;">
          Pharmaceutical Inventory Management System<br>
          @guest
          <a href="{{ route('login') }}" style="text-decoration: none;"><button style="margin-top: 10px; background-color: #F25420; color: #FFFFFF;" type="button" class="btn btn-warning">LOGIN</button></a>
          @endguest
          @auth
          <a href="{{ route('dashboard') }}" style="text-decoration: none;"><button style="margin-top: 10px; background-color: #F25420; color: #FFFFFF;" type="button" class="btn btn-warning">Dashboard</button></a>
          @endauth
          </h5>
          <div class="intro-info">
        </div>
        </header>
        <div class="row justify-content-center align-self-center" data-aos="fade-up">
        <div class="col-lg-6 intro-img order-lg-last order-first" data-aos="zoom-out" data-aos-delay="200">
        </div>
    </div>
    </div>
  </section>
  <main id="main">
    <!-- ======= About Section ======= -->
    <section id="about" class="about" style="margin-top: -160px;">
      <div class="container" data-aos="fade-up">
        <div class="row feature-item mt-5 pt-5">
          <div class="col-lg-3 wow fadeInUp order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
            <img style="margin-left: 120px;" src="{{ asset('assets/img/mobile_phone.png') }}" height="10" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 wow fadeInUp pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-right" data-aos-delay="150">
          <h4><b style="color: #F25420;">About Us</b></h4>
            <p style="text-align: justify">
            Take control of the pharmaceutical inventory with SEDI+ ! With
            this solution, you can monitor inventory, track changes, and
            eliminate inefficiencies to better control business costs. For
            Pharmacies on the go, SEDI+ helps gain visibility and
            understanding of real-time
            costs
            </p>
            <h4><b style="color: #F25420;">What is BG Pharmacy</b></h4>
            <p><b>SEDI+ is a fully integrated solution composed of</b></p>
            <p style="text-align: justify">
            (1) an android-based inventory application designed to
            empower pharmaceutical
            personnel to place sales and inventory of handled items by
            simply using their smart
            phones which send an almost real-time reports to the BG
            Pharmacy Dashboard.
            </p>
            <p style="text-align: justify">
            (2) a web-based monitoring dashboard for the Pharmaceutical
            Admins for an almost
            real-time sales and inventory management &amp; monitoring.
            Tracking product levels,
            orders and sales have never been this easy!
            </p>
          <img src="{{ asset('assets/img/line.png') }}" style="width: 1100px; height: 5px;" />

          </div>
        </div>
      </div>
     
    </section>
    <section id="services" class="services section-bg">
      <div class="container" data-aos="fade-up">
      <h3 style="color: #F25420">Features</h3>
        <div class="row g-5">
          <div class="col-md-6 col-lg-4 wow bounceInUp" data-aos="zoom-in" data-aos-delay="100">
            <div class="box">
              <div class="icon"><img src="{{ asset('assets/img/manage.png') }}" style="width: 60px; height: 60px; margin-top: -20px;" /></div>
              <h4 class="title"><a href="">MANAGE</a></h4>
            <p style="margin-left: -69px;"><i class="bi bi-dot"></i>Manage and track inventory</p>
            <p style="margin-left: -69px; margin-top: -32px;"><i class="bi bi-dot"></i>Manage and track inventory</p>
            <p style="margin-left: -69px; margin-top: -32px;"><i class="bi bi-dot"></i>Manage expense categories</p>
            <p style="margin-left: -119px; margin-top: -32px;"><i class="bi bi-dot"></i>Manage product cost</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="box">
            <div class="icon"><img src="{{ asset('assets/img/analyze.png') }}" style="width: 60px; height: 60px; margin-top: -20px;" /></div>
              <h4 class="title"><a href="">ANALYZE</a></h4>
            <p style="margin-left: -199px;"><i class="bi bi-dot"></i> Purchases</p>
            <p style="margin-left: -124px; margin-top: -32px;"><i class="bi bi-dot"></i> Cost of product sold</p>
            <p style="margin-left: -72px; margin-top: -32px;"><i class="bi bi-dot"></i>Manage expense categories</p>
            <p style="margin-left: -123px; margin-top: -32px;"><i class="bi bi-dot"></i>Manage product cost</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="box">
            <div class="icon"><img src="{{ asset('assets/img/optimize.png') }}" style="width: 60px; height: 60px; margin-top: -20px;" /></div>
              <h4 class="title"><a href="">OPTIMIZE</a></h4>
            <p style="margin-left: -12px;"><i class="bi bi-dot"></i>Increase sales and inventory visibility</p>
            <p style="margin-left: -46px; margin-top: -32px;"><i class="bi bi-dot"></i>Increase manpower productivity</p>
            <p style="margin-left: -20px; margin-top: -32px;"><i class="bi bi-dot"></i>Improve business performance and strengthen financials</p>
            <p style="margin-left: -68px; margin-top: -32px;"><i class="bi bi-dot"></i>Proactively reduce inventory</p>
            <p style="margin-left: -12px; margin-top: -32px;">variances and waste</p>
            <p style="margin-left: -81px; margin-top: -32px;"><i class="bi bi-dot"></i>Elimanate manual process</p>
            </div>
          </div>
      </div>
      </div>
    </section>
    <!-- ======= Application Section ======= -->
    <br />
    <br />
    <section id="applications" class="why-us">
      <div class="container-fluid" data-aos="fade-up">
    <section id="features" class="features">
      <div style="margin-top: -178px;" class="container" data-aos="fade-up">
        <div  class="row feature-item mt-5 pt-5">
            <h4>Application</h4>
</div>
<div class="row">
<div class="col-md-6">
<h5><img src="{{ asset('assets/img/check.png') }}" style="width: 50px; height: 50px;" /> EASY TO USE</h5>
  User-friendly mobile sales and inventory application 
  which allows the pharma personnel to send almost real-time reports and 
  updates to BGv pharmacy dashboards admin which eases the job both ends.
</div>
<div class="col-md-6">
<h5><img src="{{ asset('assets/img/organize.png') }}" style="width: 50px; height: 50px;" /> ORGANIZE</h5>
  The BG pharmacy applicaiton has two ends. One is controller by the pharma admin (BG Pharmacy Dashboard)
  and the second one is designed for the pharma personnel (BG Pharmacy Mobile App).
  The Pharma Admin's dashboard application empowers them to add, remove or edit items in their
  inventory which will be the basis of the content of the BG pharmacy application used by the pharma 
  personnel. This makes the work easier and keeps the sales and inventory reports tidy.
</div>
</div>
<br />
<div class="row">
<div class="col-md-6">
<h5><img src="{{ asset('assets/img/driven.png') }}" style="width: 50px; height: 50px;" /> EFFICIENCY DRIVEN</h5>
  The primary focus of BG Pharmacy is to increase the productivity of the business in all strands.
  From the monitoring of stocks, statistics, planning the move, logistics to manpower inventory and do time
  to time stock operation without any hassle.
</div>
<div class="col-md-6">
<h5><img src="{{ asset('assets/img/personnel.png') }}" style="width: 50px; height: 50px;" /> FOR THE PHARMA PERSONNEL</h5>
  The application allows the pharmacy personnel to digitally perform the DTR without manually writing it on the logbook.
  They might also be able to record their sales as well as report their current stocks and inventory which will then
  be studied by the pharma Admin to plan out the next move.
</div>
<div class="col-md-6">
<h5><img src="{{ asset('assets/img/net.png') }}" style="width: 50px; height: 50px;" /> NO INTERNET, NO PROBLEM</h5>
  In sending data information from the pharma personnel to the BG Pharmacy dashboard admin is not a problem.
  If there is no internet connection. information can be sent as long as their is a mobile signal as it is
  programmed to pass on data in a manner of how text messages are transmitted.
</div>
<div class="col-md-6">
<h5><img src="{{ asset('assets/img/admin.png') }}" style="width: 50px; height: 50px;" /> FOR THE PHARMA</h5>
  The web-based application dashboard is equipped with features that allows the pharma dashboard admins to 
  manipulate, customize, and adjust the salesb and inventory system according to their business needs.
  This also allows them to view the movement of the products as well as it's market behavior.
      </div>
    </div>
  </div>
</section>

</main>
  <footer id="footer" class="section-bg">
    <div class="footer-top">
    <div class="container">
      <div class="copyright">
       2022 &copy; Copyright, <strong>SEDI</strong> Pharmaceutical Management Inventory System
      </div>
      <div class="credits">
        Powered by <a href="" style="color: #F25420;">CCS Group Philippines Inc.</a>
      </div>
  </footer>
  <!-- End  Footer -->

  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">     
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="color: #F25420; text-align: center;">You may reach us through the following</h4>
          <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('assets/img/close.png') }}" style="width: 40px; height: 40px;" /></button>
        </div>
        <!-- Modal body -->
        <div class="modal-body" style="text-align: center;">
          <div class="row">
            <div class="col-md-12">
            <img src="{{ asset('assets/img/email.png') }}" style="width: 40px; height: 40px;" /> sedipluspharma@gmail.com
          </div>
          <div class="col-md-12">
          <img src="{{ asset('assets/img/mobile.png') }}" style="width: 40px; height: 40px; margin-left: -46px; margin-top: 10px;"  /> Globe: 0917-000-0001<br>
          <p style="margin-top: -20px;">Smart: 0918-000-0001</p>
        </div>
        </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <br />
          <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
        </div>
      </div>
    </div>
  </div>
</div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <!-- Vendor JS Files -->
  <!-- The Modal -->
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="{{ asset('js/bootstrap-bundle.min.js') }}"></script>
  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
<style>
    .center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  /* width: 50%; */
}
</style>
</html>