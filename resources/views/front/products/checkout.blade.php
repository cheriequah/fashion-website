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
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Checkout</p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<form name="checkoutForm" id="checkoutForm" action="{{ url('/checkout') }}" method="POST">
    @csrf
<!-- Cart Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg table-responsive mb-5">
            @if(session()->has('success_message'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session()->get('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php Session::forget('success_message'); ?>
            </div>
            @endif
            @if(session()->has('err_msg'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session()->get('err_msg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?php Session::forget('err_msg'); ?>
                </div>
            @endif
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>Products</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Category/ Product Discount</th>
                        <th>Total</th>
                        {{-- <th>Remove</th> --}}
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <?php $total_price = 0; ?>
                    @foreach ($userCartItems as $cartItem)
                    <?php $productPriceAttr = Product::getDiscountAttrPrice($cartItem['product_id'],$cartItem['size']); ?>
                    <tr>
                        <td class="align-middle"><img src="{{ asset('assets/img/product_images/small/'.$cartItem['product']['image']) }}" alt="" style="width: 50px;"></td>
                        <td class="align-middle">{{ $cartItem['product']['name'] }} ({{ $cartItem['product']['code'] }})<br>
                        Color: <br>
                        Size: {{ $cartItem['size'] }}</td>
                        <td class="align-middle">RM {{ $productPriceAttr['product_price'] }}</td>
                        <td class="align-middle">
                            {{ $cartItem['quantity'] }}
                        </td> 
                        <td>RM {{ $productPriceAttr['discount'] }}</td>
                        <td class="align-middle">RM {{ $productPriceAttr['final_price'] * $cartItem['quantity'] }}</td>
                        {{-- <td class="align-middle"><button class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button></td> --}}
                    </tr>
                    <?php $total_price = $total_price + ($productPriceAttr['final_price'] * $cartItem['quantity']); ?>
                    @endforeach
                    <tr>
                        <th colspan="5">Subtotal</th>
                        <td>RM {{ $total_price }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">Discount</th>
                        <td>RM 0</td>
                    </tr>
                    <tr>
                        <th colspan="5">Shipping</th>
                        <td>RM 0</td>
                    </tr>
                    <tr>
                        <th colspan="5">Grand Total (RM {{ $total_price }}-0)</th>
                        <td>RM {{ $total_price - 0 }}</td>
                        <?php Session::put('total', $total_price); ?>
                        
                    </tr>
                </tbody>
            </table>
        
        </div>
       
    </div>
</div>
<!-- Cart End -->

<!-- Checkout Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tr><td><strong>Addresses</strong> | <a href="{{ url('add-edit-delivery-address') }}">Add</a></td></tr>
                @foreach ($deliveryAddresses as $address) 
                <tr>
                    <td>
                        <div class="form-check">
                            <input
                              name="address_id"
                              class="form-check-input"
                              type="radio"
                              value="{{ $address['id'] }}"
                              id="address_{{ $address['id'] }}"
                            />
                            <label class="form-check-label" for="defaultRadio2"> {{ $address['name'] }}, {{ $address['address'] }}, {{ $address['city'] }}, {{ $address['postcode'] }},{{ $address['state'] }}, {{ $address['country']['country_name'] }} <span class="float-lg-end">({{ $address['mobile'] }})</span></label>
                          </div>
                    </td>
                    <td><a href="{{ url('add-edit-delivery-address/'.$address['id']) }}"><i class="bx bx-edit-alt me-2"></i></a> | <a href="{{ url('remove-delivery-address/'.$address['id']) }}" class="addressRemove"><i class="bx bx-trash me-2"></i></a></td>
                    
                </tr>
                @endforeach
            </table>
            
        </div>
                
        
        <div class="col-lg-4">     
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Payment</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment_method" value="paypal" id="paypal">
                            <label class="custom-control-label" for="paypal">Paypal</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment_method" value="COD" id="cod">
                            <label class="custom-control-label" for="directcheck">Cash On Delivery</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<!-- Checkout End -->
@endsection