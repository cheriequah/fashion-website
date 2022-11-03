@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
          <li class="breadcrumb-item">
            <a href="javascript:void(0);">Home</a>
          </li>
          <li class="breadcrumb-item active">Categories</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-xl">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">{{ $title }}</h5>
            </div>
            <div class="card-body">
              <form name="categoryForm" id="categoryForm" method="POST" 
              @if (empty($categoryData->id)) 
                action="{{ url('admin/add-edit-category') }}"      
              @else
                action="{{ url('admin/add-edit-category/'.$categoryData->id) }}"
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
                    <label class="form-label" for="category_name">Category Name</label>
                    <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter Category Name" 
                    @if (!empty($categoryData->name))
                      value="{{ $categoryData->name }}"
                    @else
                      value="{{ old('category_name') }}"
                    @endif required />
                  </div>

                  <div class="mb-3">
                    <label for="defaultSelect" class="form-label">Select category Level</label>
                    <select name="parent_id" id="parent_id" class="form-select">
                      <option value="" @if (isset($categoryData['parent_id']) && $categoryData['parent_id']==NULL) selected="" @endif>Main Category</option>
                      @if (!empty($categoryLevels))
                        @foreach ($categoryLevels as $categoryLevel)
                          <option value="{{ $categoryLevel->id }}" @if (isset($categoryData['parent_id']) && $categoryData['parent_id']==$categoryLevel['id']) selected=""
                            @endif>{{ $categoryLevel->name }}</option>

                          @if (!empty($categoryLevel->subcategories))
                            @foreach ($categoryLevel->subcategories as $subcategory)
                              <option value="{{ $subcategory->id }}">&nbsp;&raquo;&nbsp;{{ $subcategory->name }}</option>
                            @endforeach
                          @endif

                        @endforeach
                      @endif
                      
                    </select>
                </div>

                
                <div class="mb-3">
                    <label class="form-label" for="category_slug">Slug</label>
                    <input type="text" class="form-control" name="category_slug" id="category_slug" placeholder="Enter Slug" 
                    @if (!empty($categoryData->slug))
                    value="{{ $categoryData->slug }}"
                  @else
                    value="{{ old('category_slug') }}"
                  @endif required />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="category_discount">Discount</label>
                    <input type="text" class="form-control" id="category_discount" name="category_discount" placeholder="Enter Discount" 
                    @if (!empty($categoryData->discount))
                      value="{{ $categoryData->discount }}"
                    @else
                      value="{{ old('category_discount') }}"
                    @endif required />
                </div>                

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>

@endsection