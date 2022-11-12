@extends('layouts.front_layout.front_layout')
@section('content')

<div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col col-xl">
          <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-style1">
              <li class="breadcrumb-item">
                  <a href="{{ route('index') }}">Home</a>
              </li>
              <li class="breadcrumb-item active">Thanks</li>
              </ol>
          </nav>
          <hr>
          <div>
            <h3>Your Order Has Been Places Successfully</h3>
            <p>Your Order Number is {{ Session::get('order_id') }} and Total is RM {{ Session::get('total') }}</p>
            <button class="btn btn-md"><a href="{{ route('order') }}">Check My Orders</a></button>
          </div>
        </div>
    </div>
</div>
@endsection

<?php 
Session::forget('total');
Session::forget('order_id');
?>