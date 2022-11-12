@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="javascript:void(0);">Home</a>
        </li>
        <li class="breadcrumb-item active">Catogories</li>
        </ol>
    </nav>


    <!-- Success Message after adding category successful -->
    <div class="card">
        @if(session()->has('success_message'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session()->get('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card-header d-inline-flex">
            <h5>Categories</h5>
            <a href="{{ url('admin/add-edit-category') }}" class="ms-auto">Add Category</a>
        </div>
        
    <!-- Basic Bootstrap Table -->
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="categories" class="table">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Parent Category</th>       
                    <th>Slug</th>
                    <th>Discount</th>
                    <th>Status</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($categories as $category)
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $category->id }}</strong></td>
                        <td>
                            <?php $product_img_path = "assets/img/category_images/small/".$category->image ?>
                            @if (!empty($category->image)  && file_exists($product_img_path))
                                <img style="width: 100px;" src="{{ asset('assets/img/category_images/small/'.$category->image) }}" alt="">
                            @else
                                <img style="width: 100px;" src="{{ asset('assets/img/category_images/small/no_image.png') }}" alt="">
                            @endif</td>
                        <td>{{ $category->name }}</td>
                        <td> 
                            @if (!isset($category->parentcategory->name))
                            <?php echo $parent_category = "Root"; ?>
                        @else
                            <?php echo $parent_category = $category->parentcategory->name; ?>
                        @endif
                        </td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->discount }}</td>
                        <td>
                            @if ($category->status == 1)
                                <a class="updateCategoryStatus" id="category-{{ $category->id }}" category_id="{{ $category->id }}" href="javascript:void(0)"><span class="badge bg-label-success me-1">Active</span></a>
                                
                            @else
                                <a class="updateCategoryStatus" id="category-{{ $category->id }}" category_id="{{ $category->id }}" href="javascript:void(0)"><span class="badge bg-label-secondary me-1">Inactive</span></a>
                            @endif
                            
                        </td>
                        <td>
                            <a href="{{ url('admin/add-edit-category/'.$category->id) }}"><i class="bx bx-edit-alt me-2"></i></a>
                            <a href="javascript:void(0)" class="confirmDelete" record="category" record_id="{{ $category->id }}" <?php /*href="{{ url('admin/delete-category/'.$category->id) }}"*/?>><i class="bx bx-trash me-2"></i></a>
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