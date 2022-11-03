@extends('layouts.front_layout.front_layout')
@section('content')
<main id="main" class="main-site left-sidebar">

    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Login & Register</li>
            </ol>
          </nav>
          @if(session()->has('success_message'))
              <div class="alert alert-success alert-dismissible fade show">
                  {{ session()->get('success_message') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          @endif
          @if (Session::has('err_msg'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ Session::get('err_msg') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
          @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
          @endif
        </div>
        <div class="col col-xl-6">
          
          <div class="card" style="border-radius: 1rem;">     
                <div class="card-body p-4 p-lg-5 text-black">
                  
                  <form id="registerForm" method="POST" action="{{ route('user.register')}}">    
                    @csrf    
  
                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign Up Account</h5>

                    <label class="form-label required" for="form-name-register">Name</label>
                    <div class="form-outline input-group mb-4">
                      
                      <input type="text" id="name" name="name" class="form-control form-control-lg" value="{{ old('name') }}" placeholder="Enter Name" required autofocus/>  
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-user"></span>
                        </div>
                      </div>                       
                    </div>

                    <label class="form-label required" for="form-mobile-register">Mobile Number</label>
                    <div class="form-outline input-group mb-4">
                      
                      <input type="number" id="mobile" name="mobile" class="form-control form-control-lg" value="{{ old('mobile') }}" placeholder="Enter Mobile" required/>  
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-mobile"></span>
                        </div>
                      </div>                       
                    </div>

                    <label class="form-label required" for="form-email-register">Email address</label>
                    <div class="form-outline input-group mb-4">
                      
                      <input type="email" id="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" placeholder="Enter Email" required/>  
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>                       
                    </div>
  
                    <label class="form-label required" for="form-pw-register">Password</label>
                    <div class="form-outline input-group mb-2">                             
                      
                      <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Enter Password" required autocomplete="current-password"/>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-lock"></span>
                        </div>
                      </div>
                    </div>
  
                    <div class="form-check d-flex justify-content-start mb-4">
                      <input class="form-check-input" type="checkbox" value="" id="remember_me" name="remember"/>
                      <label class="form-check-label" for="remember_me"> Remember password </label>
                    </div>

                    <div class="pt-1 mb-4">
                      <button class="btn btn-dark btn-lg" type="submit" value="register" name="submit">Register</button>
                    </div>
  
                    <a class="small text-muted" href="">Forgot password?</a>
                    <a href="#!" class="small text-muted">Terms of use.</a>
                    <a href="#!" class="small text-muted">Privacy policy</a>
                  </form>
  
                </div>                    
          </div>
        </div>

        <div class="col col-xl-6">
            <div class="card" style="border-radius: 1rem;">     
                  <div class="card-body p-4 p-lg-5 text-black">
                    
                    <form id="loginForm" method="POST" action="{{ route('user.login')}}">    
                      @csrf    
    
                      <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign In Account</h5>
                  
                      <label class="form-label required" for="form-email-login">Email address</label>
                      <div class="form-outline input-group mb-4">
                        
                        <input type="email" id="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" required autofocus/>  
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                          </div>
                        </div>                       
                      </div>
    
                      <label class="form-label required" for="form-pw-login">Password</label>
                      <div class="form-outline input-group mb-2">                             
                        
                        <input type="password" id="password" name="password" class="form-control form-control-lg" required autocomplete="current-password"/>
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                          </div>
                        </div>
                      </div>
    
                      <div class="form-check d-flex justify-content-start mb-4">
                        <input class="form-check-input" type="checkbox" value="" id="remember_me" name="remember"/>
                        <label class="form-check-label" for="remember_me"> Remember password </label>
                      </div>
  
                      <div class="pt-1 mb-4">
                        <button class="btn btn-dark btn-lg" type="submit" value="login" name="submit">Login</button>
                      </div>
    
                      <a class="small text-muted" href="">Forgot password?</a>
                      <a href="#!" class="small text-muted">Terms of use.</a>
                      <a href="#!" class="small text-muted">Privacy policy</a>
                    </form>
    
                  </div>                    
            </div>
          </div>
      </div>
    </div>


</main>
@endsection