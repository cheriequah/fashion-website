<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Pearl Fashion</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- chatbot -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ url('assets/vendor/fonts/boxicons.css') }}" />
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Customized Bootstrap Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet"
            href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">

</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-4 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">PEARL</span>Wonder</h1>
                </a>
            </div>
            
            <!--Render search livewire component-->


            <div class="col-lg-4 col-6 text-right">
                <a href="{{ route('cart') }}" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge totalCartItems">{{ totalCartItems() }}</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    @include('layouts.front_layout.front_header')
    <!-- Navbar End -->

    @yield('content')

    <!-- Footer Start -->
    @include('layouts.front_layout.front_footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- Validation -->
    <script>
        var botmanWidget = {
        aboutText: 'Write Something',
        introMessage: "✋ Hi! Welcome to Pearl Wonder!"
        };
      </script>
    
      <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!--Dropdown needed bootstrap only-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    
    
    <script src="{{ asset('assets/js/jquery.flexslider.js') }}"></script>
	{{--<script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>--}}
	<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.sticky.js') }}"></script>
	<script src="{{ asset('assets/js/functions.js') }}"></script>
    
    <!-- input counter -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('assets/js/sneat_js/front_script.js') }}"></script>

</body>
</html>