@extends('layouts.front_layout.front_layout')
@section('content')
<main id="main" class="main-site left-sidebar">

    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col col-xl-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{ route('index') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </nav>
          <div class="card" style="border-radius: 1rem;">     
                <div class="card-body p-4 p-lg-5 text-black">
                  
                  <form id="deliveryAddressForm" @if(empty($address['id'])) action="{{ url('add-edit-delivery-address')}}" 
                  @else action="{{ url('add-edit-delivery-address/'.$address['id']) }}" @endif method="POST">    
                    @csrf    
  
                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">{{ $title }}</h5>

                    @if(session()->has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session()->get('success_message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php Session::forget('success_message'); ?>
                    @endif

                    @if (Session::has('err_msg'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('err_msg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                      <?php Session::forget('err_msg'); ?>
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
  
                    <label class="form-label required" for="form-name">Name</label>
                    <div class="form-outline input-group mb-4">
                      
                      <input type="text" id="name" name="name" @if(isset($address['name'])) value="{{ $address['name'] }}"
                        @else value="{{ old('name') }}" @endif class="form-control form-control-sm" placeholder="Enter Name" autofocus/>  
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>                       
                    </div>

                    <label class="form-label required" for="form-mobile">Mobile Number</label>
                    <div class="form-outline input-group mb-4">
                      
                      <input type="number" id="mobile" name="mobile" @if(isset($address['name'])) value="{{ $address['mobile'] }}"
                      @else value="{{ old('mobile') }}" @endif class="form-control form-control-sm" placeholder="Enter Mobile" />  
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>                       
                    </div>
  
                    <label class="form-label required" for="form-address">Address</label>
                    <div class="form-outline input-group mb-4">
                      
                      <input type="text" id="address" name="address" @if(isset($address['name'])) value="{{ $address['address'] }}"
                      @else value="{{ old('address') }}" @endif class="form-control form-control-sm" placeholder="Enter Address" required/>  
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>                       
                    </div>
                    
                    <label class="form-label required" for="form-city">City</label>
                    <div class="form-outline input-group mb-4">
                      
                      <input type="text" id="city" name="city" @if(isset($address['name'])) value="{{ $address['city'] }}"
                      @else value="{{ old('city') }}" @endif class="form-control form-control-sm" placeholder="Enter City" required/>  
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>                       
                    </div>

                    <label class="form-label required" for="form-state">State</label>
                    <div class="form-outline input-group mb-4">
                      
                      <input type="text" id="state" name="state" @if(isset($address['name'])) value="{{ $address['state'] }}"
                      @else value="{{ old('state') }}" @endif class="form-control form-control-sm" placeholder="Enter State" required autofocus/>  
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>                       
                    </div>

                    <label class="form-label required" for="form-country">Country</label>
                    <div class="form-outline input-group mb-4">
                      
                      {{-- <input type="text" id="country1" name="country" class="form-control form-control-sm" value="{{ $userDetails['country'] }}" placeholder="Enter Country" required/>   --}}
                      <select name="country_id" id="country_id" class="form-select" >
                        <option>Select Country</option>
                        @foreach ($countries as $country)
                          <option value="{{ $country['id'] }}" @if ($country['id']==$address['country_id']) selected
                          @elseif ($country['id']==old('country_id')) selected
                          @endif>{{ $country['country_name'] }}</option>
                        @endforeach   
                      </select>                   
                    </div>

                    <label class="form-label required" for="form-postcode">Postcode</label>
                    <div class="form-outline input-group mb-4">
                      
                      <input type="text" id="postcode" name="postcode" @if(isset($address['name'])) value="{{ $address['postcode'] }}"
                      @else value="{{ old('postcode') }}" @endif class="form-control form-control-sm" placeholder="Enter Postcode" required/>  
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>                       
                    </div>

                    {{-- <label class="form-label required" for="form-pw">Password</label>
                    <div class="form-outline input-group mb-2">                             
                      
                      <input type="password" id="password" name="password" class="form-control form-control-sm" placeholder="Enter Password" required autocomplete="current-password"/>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-lock"></span>
                        </div>
                      </div>
                    </div> --}}

                    <div class="pt-1 mb-4">
                      <button class="btn btn-dark btn-lg" type="submit" value="save" name="submit">Submit</button>
                      <button class="btn btn-dark btn-lg"><a href="{{ route('checkout') }}">Back</a></button>
                    </div>
  
                  </form>
  
                </div>                    
          </div>
        </div>
    </div>


</main>
@endsection