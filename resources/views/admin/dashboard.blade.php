@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-style1">
      <li class="breadcrumb-item">
        <a href="javascript:void(0);">Home</a>
      </li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
    <div class="row">
        <div class="col-lg-3 col-md-12 col-6 mb-4">
        <div class="card">
            <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                <img
                    src="{{ asset('assets/img/sneat_img/icons/unicons/chart-success.png') }}"
                    alt="chart success"
                    class="rounded"
                />
                </div>    
            </div>
            <a href="#"><span class="fw-semibold d-block mb-1">Categories</span></a>
            <h3 class="card-title mb-1">{{ $categoryCount }}</h3>             
            </div>
        </div>
        </div>

        <div class="col-lg-3 col-md-12 col-6 mb-4">
        <div class="card">
            <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                <img
                    src="{{ asset('assets/img/sneat_img/icons/unicons/wallet-info.png') }}"
                    alt="Credit Card"
                    class="rounded"
                />
                </div>                
            </div>
            <a href="#"><span class="fw-semibold d-block mb-1">Products</span></a>
            <h3 class="card-title text-nowrap mb-1">{{ $productCount }}</h3>
            </div>
        </div>
        </div>

        <div class="col-lg-3 col-md-12 col-6 mb-4">
        <div class="card">
            <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                <img
                    src="{{ asset('assets/img/sneat_img/icons/unicons/wallet-info.png') }}"
                    alt="Credit Card"
                    class="rounded"
                />
                </div>                
            </div>
            <a href="#"><span class="fw-semibold d-block mb-1">Total Sales</span></a>
            <h3 class="card-title text-nowrap mb-1">RM {{ $orderSales }}</h3>
            </div>
        </div>
        </div>
        

        <div class="col-lg-3 col-md-12 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img
                      src="{{ asset('assets/img/sneat_img/icons/unicons/wallet-info.png') }}"
                      alt="Credit Card"
                      class="rounded"
                    />
                  </div>                
                </div>
                <a href=""><span class="fw-semibold d-block mb-1">Orders</span></a>
                <h3 class="card-title text-nowrap mb-1">{{ $orderCount }}</h3>
              </div>
            </div>
        </div>
    </div>
    

   
  </div>
  <!-- / Content -->
@endsection
  
