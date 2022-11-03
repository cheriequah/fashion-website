<?php 
use App\Models\Product;
use App\Models\Color;

$colors = Color::getColors();
?>

@extends('layouts.front_layout.front_layout')
@section('content')
   
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Shopping Cart</p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Cart Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg table-responsive mb-5">
            
            @if(session()->has('success_message'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session()->get('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session()->has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session()->get('error_message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (!empty($userCartItems))
                <div id="AjaxCartItems">
                    @include('front.products.cart_items')
                </div>
                <button class="btn btn-block btn-primary my-3 py-3"><a class="text-white" href="{{ route('checkout') }}">Proceed To Checkout</a></button>
            @else
                <h3 class="d-flex justify-content-center">No Items in Cart</h3>
            @endif
            
        </div>
       
    </div>
</div>
<!-- Cart End -->

@endsection