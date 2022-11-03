<?php use App\Models\Product; ?>

@extends('layouts.admin_layout.admin_layout')
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
        <div class="col col-12">   
            @if(session()->has('success_message'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session()->get('success_message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        {{ Session::forget('success_message') }}
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
                    <td>RM {{ $orderDetails['total'] }}</td> 
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

        <div class="col col-xl-6">    
            <table class="table table-striped table-bordered">
                <tr><th colspan="2">User Details</th></tr>
                <tr>
                    <td>Name</td>
                    <td>{{ $userDetails['name'] }}</td> 
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $userDetails['email'] }}</td> 
                </tr>     
                <tr>
                    <td>Mobile</td>
                    <td>{{ $userDetails['mobile'] }}</td> 
                </tr>       
            </table>
 
            <table class="table table-striped table-bordered">
                <tr><th colspan="2">Billing Address</th></tr>
                <tr>
                    <td>Address</td>
                    <td>{{ $userDetails['address'] }}</td> 
                </tr>
                <tr>
                    <td>City</td>
                    <td>{{ $userDetails['city'] }}</td> 
                </tr>
                <tr>
                    <td>State</td>
                    <td>{{ $userDetails['state'] }}</td> 
                </tr>
                <tr>
                    <td>Country</td>
                    <td>{{ $userDetails['country']['country_name'] }}</td> 
                </tr>
                <tr>
                    <td>Postcode</td>
                    <td>{{ $userDetails['postcode'] }}</td> 
                </tr>
            </table>

            <table class="table table-striped table-bordered">
                <tr><th colspan="2">Update order Status</th></tr>
                <tr>
                    <form action="{{ url('admin/update-order-status') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                    <td><select name="order_status" id="order_status" class="form-select" required>
                        <option value="">Select Status</option>
                        @foreach ($orderStatuses as $status)
                            <option value="{{ $status['name'] }}" 
                            @if (isset($orderDetails['order_status']) && $orderDetails['order_status']==$status['name']) selected @endif>{{ $status['name'] }}</option>
                        @endforeach
                        </select></td>
                    <td><button type="submit" class="btn btn-primary">Update</button></td> 
                    </form>
                </tr>
                <tr>
                    <td colspan="2">
                        @foreach ($orderLog as $log)
                            <strong>{{ $log['order_status'] }}</strong><br>
                            {{ date('j F, Y, g:i a',strtotime($log['created_at'])) }}<br>
                            <hr>
                        @endforeach
                    </td>
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