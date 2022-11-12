@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="javascript:void(0);">Home</a>
        </li>
        <li class="breadcrumb-item active">Products</li>
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
        <div class="card-header d-inline-flex">
            <h5>Products</h5>
            <a href="{{ url('admin/add-edit-product') }}" class="ms-auto">Add Product</a>
        </div>
        
    <!-- Basic Bootstrap Table -->
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="products" class="table">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Code</th>       
                    <th>Color</th>
                    <th>Price (RM)</th>
                    <th>Discount</th>
                    <th>Category</th>
                    <th>Pattern Type</th>
                    <th>Occasion Type</th>
                    <th>Sleeve Type</th>
                    <th>Material Type</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($products as $product)
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger"></i> <strong>{{ $product->id }}</strong></td>
                        <td>
                            <?php $product_img_path = "assets/img/product_images/small/".$product->image ?>
                            @if (!empty($product->image)  && file_exists($product_img_path))
                                <img style="width: 100px;" src="{{ asset('assets/img/product_images/small/'.$product->image) }}" alt="">
                            @else
                                <img style="width: 100px;" src="{{ asset('assets/img/product_images/small/no_image.png') }}" alt="">
                            @endif</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->color->type }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->discount }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->pattern->name }}</td>
                        <td>{{ $product->occasion->type }}</td>
                        <td>{{ $product->sleeve->type }}</td>
                        <td>{{ $product->material->type }}</td>
                        <td>{{ $product->is_featured }}</td>
                        <td>
                            @if ($product->status == 1)
                                <a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}" href="javascript:void(0)"><span class="badge bg-label-success me-1">Active</span></a>
                                
                            @else
                                <a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}" href="javascript:void(0)"><span class="badge bg-label-secondary me-1">Inactive</span></a>
                            @endif      
                        </td>
                        <td>
                            <a title="Add/Edit Attributes" href="{{ url('admin/add-attributes/'.$product->id) }}"><i class="bx bx-plus-circle me-2"></i></a>
                            <a title="Edit Product" href="{{ url('admin/add-edit-product/'.$product->id) }}"><i class="bx bx-edit-alt me-2"></i></a>
                            <a title="Delete Product" href="javascript:void(0)" class="confirmDelete" record="product" record_id="{{ $product->id }}"><i class="bx bx-trash me-2"></i></a>
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