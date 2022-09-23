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

      <div class="row">
        <div class="col-xl">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">{{ $title }}</h5>
              <small class="text-muted float-end">Default label</small>
            </div>
            <div class="card-body">
              <form name="productForm" id="productForm" method="POST" enctype="multipart/form-data"
              @if (empty($productData->id)) 
                action="{{ url('admin/add-edit-product') }}"      
              @else
                action="{{ url('admin/add-edit-product/'.$productData->id) }}"
              @endif >
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
                
                  <div class="mb-3">
                    <label class="form-label" for="product_name">Product Name</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter Product Name" 
                    @if (!empty($productData->name))
                      value="{{ $productData->name }}"
                    @else
                      value="{{ old('product_name') }}"
                    @endif required />
                  </div>

                  <div class="mb-3">
                    <label for="product_img" class="form-label">Product Image</label>
                    <input name="product_img" id="product_img" class="form-control" type="file" />
                    @if (!empty($productData->image))
                      <div><img style="width: 120px;" src="{{ asset('assets/img/product_images/small/'.$productData->image) }}" alt="">
                      &nbsp;
                      <a class="confirmDelete" href="javascript:void(0)" record="product-image" record_id="{{ $productData->id }}"><i class="bx bx-trash me-2"></i>Delete</a>
                      </div>
                    @endif
                    <div>Recommended Image Size: 500 x 500</div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label" for="product_code">Product Code</label>
                    <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Enter Product Code" 
                    @if (!empty($productData->code))
                      value="{{ $productData->code }}"
                    @else
                      value="{{ old('product_code') }}"
                    @endif required />
                  </div>

                  <div class="mb-3">
                    <label for="color_id" class="form-label">Product Color</label>
                    <select name="color_id" id="color_id" class="form-select" >
                      <option selected>Select Product Color</option>
                      @foreach ($colors as $color)
                        <option value="{{ $color->id }}" 
                          @if (isset($productData['color_id']) && $productData['color_id']==$color['id'])) selected=""
                          @endif>{{ $color->type }}</option>
                      @endforeach   
                    </select>
                  </div>

                  <div class="mb-3"> 
                    <label for="product_description" class="form-label">Description</label>
                    <textarea name="product_description" id="product_description" class="form-control" rows="3">@if (!empty($productData->description)){{ $productData->description }}@else {{ old('product_description') }}@endif</textarea>
                  </div>

                  <div class="mb-3">
                    <label for="defaultSelect" class="form-label">Select category Level</label>
                    <select name="category_id" id="category_id" class="form-select"> 
                      @if (!empty($categoryLevels))
                        @foreach ($categoryLevels as $categoryLevel)
                          <option value="{{ $categoryLevel->id }}" @if (isset($productData['category_id']) && $productData['category_id']==$categoryLevel['id']) selected=""
                            @endif>{{ $categoryLevel->name }}</option>

                          @if (!empty($categoryLevel->subcategories))
                            @foreach ($categoryLevel->subcategories as $subcategory)
                              <option value="{{ $subcategory->id }}" @if (isset($productData['category_id']) && $productData['category_id']==$subcategory['id']) selected=""
                                @endif>&nbsp;&raquo;&nbsp;{{ $subcategory->name }}</option>
                            @endforeach
                          @endif

                        @endforeach
                      @endif
                      
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="product_price">Price</label>
                    <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Enter Price" 
                    @if (!empty($productData->price))
                      value="{{ $productData->price }}"
                    @else
                      value="{{ old('product_price') }}"
                    @endif required />
                </div>        
                
                <div class="mb-3">
                    <label class="form-label" for="product_discount">Discount</label>
                    <input type="text" class="form-control" id="product_discount" name="product_discount" placeholder="Enter Discount" 
                    @if (!empty($productData->discount))
                      value="{{ $productData->discount }}"
                    @else
                      value="{{ old('product_discount') }}"
                    @endif required />
                </div>   
                
                <div class="mb-3">
                    <label for="pattern_id" class="form-label">Product Pattern</label>
                    <select name="pattern_id" id="pattern_id" class="form-select" >
                      <option>Select Product Pattern</option>
                      @foreach ($patterns as $pattern)
                        <option value="{{ $pattern->id }}" @if (isset($productData['pattern_id']) && $productData['pattern_id']==$pattern['id'])) selected=""
                          @endif>{{ $pattern->name }}</option>
                      @endforeach                
                    </select>
                </div>

                <div class="mb-3">
                    <label for="occasion_id" class="form-label">Product Occasion</label>
                    <select name="occasion_id" id="occasion_id" class="form-select" >
                      <option selected>Select Product Occasion</option>
                      @foreach ($occasions as $occasion)
                        <option value="{{ $occasion->id }}" @if (isset($productData['occasion_id']) && $productData['occasion_id']==$occasion['id'])) selected=""
                          @endif>{{ $occasion->type }}</option>
                      @endforeach    
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="sleeve_id" class="form-label">Product Sleeve</label>
                    <select name="sleeve_id" id="sleeve_id" class="form-select" >
                      <option selected>Select Product Sleeve</option>
                      @foreach ($sleeves as $sleeve)
                        <option value="{{ $sleeve->id }}"@if (isset($productData['sleeve_id']) && $productData['sleeve_id']==$sleeve['id'])) selected=""
                          @endif>{{ $sleeve->type }}</option>
                      @endforeach    
                    </select>
                </div>

                <div class="mb-3">
                    <label for="material_id" class="form-label">Product Material</label>
                    <select name="material_id" id="material_id" class="form-select" >
                      <option selected>Select Product Material</option>
                      @foreach ($materials as $material)
                        <option value="{{ $material->id }}"@if (isset($productData['material_id']) && $productData['material_id']==$material['id'])) selected=""
                          @endif>{{ $material->type }}</option>
                      @endforeach    
                    </select>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="Yes" 
                    @if (isset($productData['is_featured']) && $productData['is_featured']=="Yes") checked=""
                    @endif/>
                    <label class="form-check-label" for="defaultCheck1"> Featured Product</label>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>

@endsection