@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="javascript:void(0);">Home</a>
        </li>
        <li class="breadcrumb-item active">Reviews</li>
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
                <table id="reviews" class="table">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>User Email</th>       
                    <th>Review</th>
                    <th>Rating</th>                   
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($reviews as $review)
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger"></i> <strong>{{ $review['id'] }}</strong></td>
                        <td>{{ $review['product']['name'] }}</td>
                        <td>{{ $review['user']['email'] }}</td>
                        <td>{{ $review['review'] }}</td> 
                        <td>{{ $review['rating'] }}</td>
                        <td>
                            @if ($review['status'] == 1)
                                <a class="updateReviewStatus" id="review-{{ $review['id'] }}" review_id="{{ $review['id'] }}" href="javascript:void(0)"><span class="badge bg-label-success me-1">Approved</span></a>
                                
                            @else
                                <a class="updateReviewStatus" id="review-{{ $review['id'] }}" review_id="{{ $review['id'] }}" href="javascript:void(0)"><span class="badge bg-label-secondary me-1">Unapproved</span></a>
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