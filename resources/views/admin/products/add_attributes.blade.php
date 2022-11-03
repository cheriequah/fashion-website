@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
          <li class="breadcrumb-item">
            <a href="javascript:void(0);">Home</a>
          </li>
          <li class="breadcrumb-item active">Product Attributes</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $title }}</h5>         
                </div>
                <div class="card-body">
                <form name="attributesForm" id="attributesForm" method="POST" action="{{ url('admin/add-attributes/'.$productData->id) }}">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="product_name">Product Name: {{ $productData->name }}</label> 
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="product_code">Product Code: {{ $productData->code }}</label>
                            </div>

                            <div class="mb-3">
                                <label for="color_id" class="form-label">Product Color: {{ $productData->color->type }}</label>                   
                            </div>

                            <div class="mb-3">
                                <label for="color_id" class="form-label">Product Price: RM {{ $productData->price }}</label>                   
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <img style="width: 120px;" src="{{ asset('assets/img/product_images/small/'.$productData->image) }}" alt="">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="field_wrapper">
                                <div class="attributes-field">
                                    <input type="text" id="size" name="size[]" value="" placeholder="Size" required />
                                    <input type="text" id="sku" name="sku[]" value="" placeholder="SKU" required />
                                    <input type="number" id="price" name="price[]" value="" placeholder="Price" required />
                                    <input type="number" id="stock" name="stock[]" value="" placeholder="Stock" required />
                                    <a href="javascript:void(0);" class="add_button" title="Add field"><i class="bx bx-plus-circle ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                </div>
            </div>

        
            <form name="editAttributeForm" id="editAttributeForm" method="POST" action="{{ url('admin/edit-attributes/'.$productData->id) }}">
            @csrf
                <div class="card mb-4">
                    <!--Display Attributes-->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Product Attributes</h5>         
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table id="products" class="table">
                            <thead>
                                <tr>
                                <th>ID</th>
                                <th>Size</th>
                                <th>SKU</th>
                                <th>Price (RM)</th>       
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($productData->attributes as $attribute)
                                <input style="display: none;" type="text" name="attribute_id[]" value="{{ $attribute->id }}">
                                <tr>
                                    <td><i class="fab fa-angular fa-lg text-danger"></i> <strong>{{ $attribute->id }}</strong></td>
                                    <td>{{ $attribute->size }}</td>
                                    <td>{{ $attribute->sku }}</td>
                                    <td>
                                        <input type="number" name="price[]" value="{{ $attribute->price }}" required >
                                    </td>
                                    <td>
                                        <input type="number" name="stock[]" value="{{ $attribute->stock }}" required > 
                                    </td>
                                    <td>
                                        @if ($attribute->status == 1)
                                            <a class="updateAttributeStatus" id="attribute-{{ $attribute->id }}" attribute_id="{{ $attribute->id }}" href="javascript:void(0)"><span class="badge bg-label-success me-1">Active</span></a>
                                            
                                        @else
                                            <a class="updateAttributeStatus" id="attribute-{{ $attribute->id }}" attribute_id="{{ $attribute->id }}" href="javascript:void(0)"><span class="badge bg-label-secondary me-1">Inactive</span></a>
                                        @endif
                                        
                                    </td>
                                    <td>
                                        <a title="Delete Attribute" href="javascript:void(0)" class="confirmDelete" record="attribute" record_id="{{ $attribute->id }}"><i class="bx bx-trash me-2"></i></a>
                                    </td>
                                </tr>
                                @endforeach 
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>     
    </div>
</div>

@endsection