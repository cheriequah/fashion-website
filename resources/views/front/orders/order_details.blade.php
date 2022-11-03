<?php use App\Models\Product; ?>

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
            <li class="breadcrumb-item">
                <a href="{{ route('order') }}">My Orders</a>
            </li>
            <li class="breadcrumb-item active">Order Details #{{ $orderDetails['id'] }}</li>
            </ol>
        </nav>
        <div class="col col-xl-6">    
            <table class="table table-striped table-bordered">
                <tr><th colspan="2">Order Details</th></tr>
                <tr>
                    <td>Order Date</td>
                    <td>{{ date('d-m-Y',strtotime($orderDetails['created_at'])) }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>{{ $orderDetails['order_status'] }}</td> 
                </tr>
                <tr>
                    <td>Total</td>
                    <td>{{ $orderDetails['total'] }}</td> 
                </tr>
                <tr>
                    <td>Shipping Fee</td>
                    <td>RM {{ $orderDetails['shipping_fee'] }}</td> 
                </tr>
                <tr>
                    <td>Payment Method</td>
                    <td>{{ $orderDetails['payment_method'] }}</td> 
                </tr>
         
            </table>
        </div>
        <div class="col col-xl-6">    
            <table class="table table-striped table-bordered">
                <tr><th colspan="2">Delivery Address</th></tr>
                <tr>
                    <td>Name</td>
                    <td>{{ $orderDetails['name'] }}</td> 
                </tr>
                <tr>
                    <td>Mobile</td>
                    <td>{{ $orderDetails['mobile'] }}</td> 
                </tr>
                <tr>
                    <td>Address</td>
                    <td>{{ $orderDetails['address'] }}</td> 
                </tr>
                <tr>
                    <td>City</td>
                    <td>{{ $orderDetails['city'] }}</td> 
                </tr>
                <tr>
                    <td>State</td>
                    <td>{{ $orderDetails['state'] }}</td> 
                </tr>
                <tr>
                    <td>Country</td>
                    <td>{{ $orderDetails['country'] }}</td> 
                </tr>
                <tr>
                    <td>Postcode</td>
                    <td>{{ $orderDetails['postcode'] }}</td> 
                </tr>
            </table>
        </div>
        <div class="col col-xl">    
            <table class="table table-striped table-bordered">
                <tr><th colspan="6">Products</th></tr>
                <tr>
                    <th>Image</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Qty</th>
                </tr>
                @foreach ($orderDetails['orders_products'] as $product)
                    <tr>
                        <td><?php $productImage = Product::getProductImage($product['product_id']) ?>
                        <a target="_blank" href="{{ url('product/'.$product['product_id']) }}"><img style="width: 100px;" src="{{ asset('assets/img/product_images/small/'.$productImage) }}" alt=""></a></td>
                        <td>{{ $product['product_code'] }}</td>
                        <td>{{ $product['product_name'] }}</td> 
                        <td>{{ $product['product_size'] }}</td>
                        <td>{{ $product['product_color'] }}</td>
                        <td>{{ $product['product_qty'] }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>


</main>
@endsection