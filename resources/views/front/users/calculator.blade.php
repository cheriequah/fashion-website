@extends('layouts.front_layout.front_layout')
@section('content')
<main id="main" class="main-site left-sidebar">

    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Women Size Calculator (Tops, Bottoms)</li>
            </ol>
        </nav>
        <div class="col col-xl-6">    
          <div class="card" style="border-radius: 1rem;">     
                <div class="card-body p-4 p-lg-5 text-black">
                  
                  <form id="accountForm" method="POST" action="{{ route('calculator')}}">    
                    @csrf    
  
                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Women Size Calculator</h5>

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

                    <label class="form-label required" for="form-bust">Bust</label>
                    <div class="form-outline input-group mb-4">
                      <input type="number" id="bust" name="bust" class="form-control form-control-sm" value="{{ old('bust') }}" placeholder="Enter Bust" />                                          
                    </div>

                    <label class="form-label required" for="form-waist">Waist</label>
                    <div class="form-outline input-group mb-4">                     
                      <input type="number" id="waist" name="waist" class="form-control form-control-sm" value="" placeholder="Enter Waist" />                                          
                    </div>

                    <label class="form-label required" for="form-hip">Hip</label>
                      <div class="form-outline input-group mb-4">                     
                        <input type="number" id="hip" name="hip" class="form-control form-control-sm" value="" placeholder="Enter Hip" />                     
                      </div>
                    
                    <div class="mb-4">
                        <label for="size-calculated">@if (!empty($sizeCalculatedTops['size']))
                            Size For Tops: {{ $sizeCalculatedTops['size'] }} @endif</label>
                        <label for="note-size">@if (!empty($sizeCalculatedTops['note']))
                            Note For Tops: {{ $sizeCalculatedTops['note'] }} @endif</label>

                        <label for="size-calculated">@if (!empty($sizeCalculatedBottoms['size']))
                          Size For Bottoms: {{ $sizeCalculatedBottoms['size'] }} @endif</label>
                        <label for="note-size">@if (!empty($sizeCalculatedBottoms['note']))
                            Note For Bottoms: {{ $sizeCalculatedBottoms['note'] }} @endif</label>
                    </div>

                    <div class="pt-1 mb-4">
                      <button class="btn btn-dark btn-lg" type="submit" value="calculate" name="submit">Calculate</button>
                    </div>
  
                  </form>
  
                </div>                    
          </div>
        </div>
      
    </div>


</main>
@endsection