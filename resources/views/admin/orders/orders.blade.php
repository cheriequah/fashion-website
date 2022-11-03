@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="javascript:void(0);">Home</a>
        </li>
        <li class="breadcrumb-item active">Orders</li>
        </ol>
    </nav>


    <!-- Success Message after adding product successful -->
    <div class="card">
        @if(session()->has('success_message'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session()->get('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
    <!-- Basic Bootstrap Table -->
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="orders" class="table">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Order Date</th>
                    <th>Customer Name</th>       
                    <th>Customer Email</th>
                    <th>Products</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment Method</th>                 
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($orders as $order)
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger"></i> <strong>{{ $order['id'] }}</strong></td>
                        <td>{{ date('d-m-Y',strtotime($order['created_at'])) }}</td>
                        <td>{{ $order['name'] }}</td>
                        <td>{{ $order['email'] }}</td>
                        <td>
                            @foreach ($order['orders_products'] as $product)
                                {{ $product['product_code'] }} ({{ $product['product_qty'] }})<br>
                            @endforeach
                        </td>
                        <td>{{ $order['total'] }}</td>
                        <td>{{ $order['order_status'] }}</td>
                        <td>{{ $order['payment_method'] }}</td>  
                        <td>
                            <a title="View Order Details" href="{{ url('admin/orders/'.$order['id']) }}"><i class="bx bx-detail me-2"></i></a> 
                            @if ($order['order_status'] == "Delivered")
                            <a title="View Order Invoice" target="_blank" href="{{ url('admin/orders/'.$order['id']) }}"><i class="bx bx-receipt me-2"></i></a>   
                            <a title="Print PDF Invoice" target="_blank" href="{{ url('admin/print-pdf-invoice/'.$order['id']) }}"><i class="bx bxs-file-pdf me-2"></i></a>   
                            
                            @endif                 
                        </td>
                    </tr>
                    @endforeach 
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--/ Basic Bootstrap Table -->

@endsection