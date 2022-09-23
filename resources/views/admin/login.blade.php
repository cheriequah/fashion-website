<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">

  <!-- Customized Bootstrap Stylesheet -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">

</head>
<body>
  <main id="main" class="main-site left-sidebar">

    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem;">     
                <div class="card-body p-4 p-lg-5 text-black">
                  
                  <form method="POST" action="{{ route('admin.login')}}">    
                    @csrf    
                    <div class="d-flex align-items-center mb-3 pb-1">
                      <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                      <span class="h1 fw-bold mb-0">Logo</span>
                    </div>
  
                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign In Account</h5>

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
  
                    <label class="form-label required" for="form-email-login">Email address</label>
                    <div class="form-outline input-group mb-4">
                      
                      <input type="email" id="email" name="email" class="form-control form-control-lg" :value="old('email')" required autofocus/>  
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
  
                    <a class="small text-muted" href="{{ route('password.request') }}">Forgot password?</a>
                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="#!">Register here</a></p>
                    <a href="#!" class="small text-muted">Terms of use.</a>
                    <a href="#!" class="small text-muted">Privacy policy</a>
                  </form>
  
                </div>                    
          </div>
        </div>
      </div>
    </div>


</main>
</body>
</html>

