<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">  

        <a class="navbar-brand" href="#!">Pearl</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{url('/')}}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('/')}}">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('/shop')}}">Shop</a></li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">All Products</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                        <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                    </ul>
                </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        @auth
                           @if (Auth::user()->utype === 'A')
                                <!--Admin-->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="{{ route('admin.dashboard')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dashboard ({{Auth::user()->name}})</a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                                        <li><a class="dropdown-item" href="{{ route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                                        <form id="logout-form" method="POST" action="{{ route('logout')}}">
                                            @csrf
                                        </form>
                                    </ul>
                                </li>
                                
                           @else
                               <!--User-->
                               <li class="nav-item dropdown"> 
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">My Account ({{Auth::user()->name}})</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('user.dashboard')}}">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                                    <form id="logout-form" method="POST" action="{{ route('logout')}}">
                                        @csrf
                                    </form>
                                </ul>
                            </li>
                           @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login')}}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register')}}">Register</a>
                            </li>
                        @endif
                       
                    @endif
                    
                </ul>
            </div>
        </div>
    </div>
</nav>