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
            <li class="breadcrumb-item active">My Orders</li>
            </ol>
        </nav>
        <div class="col col-xl">           
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Order ID</th>
                    <th>Order Products</th>
                    <th>Payment Method</th>
                    <th>Total</th>
                    <th>Created On</th>
                    <th>Details</th>
                </tr>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order['id'] }}</td>
                        <td>
                            @foreach ($order['orders_products'] as $product)
                            {{ $product['product_code'] }}<br>
                            @endforeach</td>
                        <td>{{ $order['payment_method'] }}</td>
                        <td>RM {{ $order['total'] }}</td>
                        <td>{{ date('d-m-Y',strtotime($order['created_at'])) }}</td>
                        <td><a href="{{ url('orders/'.$order['id']) }}"><i class="bx bx-detail me-2"></i></a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>


</main>
@endsection