<?php use App\Models\Product; ?>

@extends('layouts.front_layout.front_layout')
@section('content')

<!-- Shop Detail Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('/'.$productDetails['category']['slug']) }}">{{ $productDetails['category']['name'] }}</a>
            </li>
            <li class="breadcrumb-item active">{{ $productDetails['name'] }}</li>
            </ol>
        </nav>
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
        <div class="col-lg-5 pb-5">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner border">
                    
                    <div class="carousel-item active">
                        @if (isset($productDetails['image']))
                        <?php $product_img_path = "assets/img/product_images/large/".$productDetails['image'] ?>
                        @else
                            <?php $product_img_path = ""; ?>
                        @endif 
                        @if (!empty($productDetails['image'])  && file_exists($product_img_path))
                            <img class="w-100 h-100" src="{{ asset('assets/img/product_images/large/'.$productDetails['image']) }}" alt="">
                        @else
                            <img class="w-100 h-100" src="{{ asset('assets/img/product_images/large/no_image.png') }}" alt="">
                        @endif
                    </div>
                    <!--
                    <div class="carousel-item">
                        <img class="w-100 h-100" src="" alt="Image">
                    </div>
                    <div class="carousel-item">
                        <img class="w-100 h-100" src="" alt="Image">
                    </div>-->
                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold">{{ $productDetails['name'] }}</h3>
            <div class="d-flex mb-3">
                @if ($avgStarRating > 0)
                <div class="avg-rating text-primary mb-2">
                    <?php 
                    $count = 1;
                    while ($count <= $avgStarRating) { ?>
                        <span class="star">&#9733;</span>
                    <?php $count++; } ?>                            
                </div> 
                <small class="pt-1">({{ $avgRating }})</small>
                @endif
                <small class="pt-1">({{ $ratingsCount }} Reviews)</small>
            </div>
            <?php $discountedPrice = Product::getDiscountPrice($productDetails['id']); ?>
            <div class="d-flex">
                @if ($discountedPrice>0)
                    <h4 class="getAttrPrice mb-3">RM {{ $discountedPrice }}<del class="text-muted">RM {{ $productDetails['price'] }}</del></h4>
                @else
                    <h3 class="getAttrPrice mb-4">RM {{ $productDetails['price'] }}</h3>
                @endif
            </div>
            <p class="mb-4">{{ $productDetails['description'] }}</p>
            <div class="d-flex mb-3">
                <p class="text-dark font-weight-medium mb-0">Sizes:</p>
                <form action="{{ url('add-to-cart') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                    <select name="size" id="getPrice" product-id="{{ $productDetails['id'] }}" class="chosen form-select form-select-sm" required>
                        <option value="">Select Size</option>
                        @foreach ($productDetails['attributes'] as $attribute)
                            <option value="{{ $attribute['size'] }}">{{ $attribute['size'] }}</option>
                        @endforeach         
                    </select>
                    <input name="quantity" type="number" class="form-control bg-secondary text-center" value="1" required>
                    <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart me-1"></i> Add To Cart</button>
                </form>
            </div>
            <!--
            <div class="d-flex align-items-center mb-4 pt-2">
                <div class="input-group quantity me-3" style="width: 130px;">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-minus" >
                        <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input name="quantity" type="number" class="form-control bg-secondary text-center" value="1" required>
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-plus">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart me-1"></i> Add To Cart</button>
            </div>-->
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs border-secondary mb-4">
                <a class="nav-item nav-link active" data-bs-toggle="tab" href="#tab-pane-1">Description</a>
                <a class="nav-item nav-link" data-bs-toggle="tab" href="#tab-pane-2">Information</a>
                <a class="nav-item nav-link" data-bs-toggle="tab" href="#tab-pane-3">Reviews (0)</a>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-pane-1">
                    <h4 class="mb-3">Product Description</h4>
                    <p>{{ $productDetails['description'] }}</p>
                </div>
                <div class="tab-pane fade" id="tab-pane-2">
                    <h4 class="mb-3">Additional Information</h4>
                    <table class="table table-bordered">             
                        <tbody>
                          <tr>
                            <th>Code: </th>
                            <td>{{ $productDetails['code'] }}</td>
                          </tr>
                          @if (!empty($productDetails['color']['type']))
                          <tr>
                            <th>Color: </th>
                            <td>{{ $productDetails['color']['type'] }}</td>
                           </tr>
                          @endif
                          @if (!empty($productDetails['pattern']['name']))
                          <tr>
                            <th>Pattern: </th>
                            <td>{{ $productDetails['pattern']['name'] }}</td>
                           </tr>
                          @endif
                          @if (!empty($productDetails['material']['type']))
                          <tr>
                            <th>Material Type: </th>
                            <td>{{ $productDetails['material']['type'] }}</td>
                           </tr>
                          @endif
                          @if (!empty($productDetails['sleeve']['type']))
                          <tr>
                            <th>Sleeve Type: </th>
                            <td>{{ $productDetails['sleeve']['type'] }}</td>
                           </tr>
                          @endif
                          @if (!empty($productDetails['occasion']['type']))
                          <tr>
                            <th>Suitable Occasion: </th>
                            <td>{{ $productDetails['occasion']['type'] }}</td>
                          </tr>
                          @endif   
                        </tbody>
                      </table>
                </div>
                <div class="tab-pane fade" id="tab-pane-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4">{{ $ratingsCount }} review for "{{ $productDetails['name'] }}"</h4>
                            @if (count($reviews) > 0)
                                @foreach ($reviews as $review) 
                                <div class="media mb-4">
                                    <div class="media-body">
                                        <h6>{{ $review['user']['name'] }}<small> - <i>{{ date('d-m-Y H:i:s',strtotime($review['created_at'])) }}</i></small></h6>
                                        <div class="text-primary mb-2">
                                            <?php 
                                            $count = 1;
                                            while ($count <= $review['rating']) { ?>
                                                <span class="star">&#9733;</span>
                                            <?php $count++; } ?>                            
                                        </div> 
                                        <p>{{ $review['review'] }}</p>
                                    </div>
                                </div>
                                <hr>
                                @endforeach            
                            @else
                                <p><b>There are No Reviews yet for this Product.</b></p>
                            @endif
                            
                        </div>
                        <div class="col-md-6">
                            <form method="POST" action="{{ url('/add-review') }}" name="reviewForm" id="reviewForm">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                                <h4 class="mb-4">Leave a review</h4>                        
                                <div class="my-3">
                                    <p class="mb-0 me-2">Your Rating * :</p>
                                    <div class="rate">
                                        <input type="radio" id="star5" name="rating" value="5" />
                                        <label for="star5" title="text">5 stars</label>
                                        <input type="radio" id="star4" name="rating" value="4" />
                                        <label for="star4" title="text">4 stars</label>
                                        <input type="radio" id="star3" name="rating" value="3" />
                                        <label for="star3" title="text">3 stars</label>
                                        <input type="radio" id="star2" name="rating" value="2" />
                                        <label for="star2" title="text">2 stars</label>
                                        <input type="radio" id="star1" name="rating" value="1" />
                                        <label for="star1" title="text">1 star</label>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label for="review">Your Review *</label>
                                    <textarea id="review" name="review" cols="30" rows="5" class="form-control"></textarea>
                                </div>  
                                <div class="form-group mb-0">
                                    <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->


<!-- Products Start -->
<div class="container-fluid py-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach ($relatedProducts as $relatedproduct)
                <div class="card product-item border-0">
               
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="{{ route('product-details',['id'=>$relatedproduct['id']]) }}">
                            <?php $product_img_path = "assets/img/product_images/medium/".$relatedproduct['image'] ?>
                            @if (!empty($relatedproduct['image'])  && file_exists($product_img_path))
                                <img src="{{ asset('assets/img/product_images/medium/'.$relatedproduct['image']) }}" alt="">
                            @else
                                <img src="{{ asset('assets/img/product_images/medium/no_image.png') }}" alt="">
                            @endif</a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{ $relatedproduct['name'] }}</h6>
                        <div class="d-flex justify-content-center">
                            <h6>RM {{ $relatedproduct['price'] }}</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{ route('product-details',['id'=>$relatedproduct['id']]) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary me-1"></i>View Detail</a>
                        <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary me-1"></i>Add To Cart</a>
                    </div>
                </div>
                @endforeach             
            </div>
        </div>
    </div>
</div>
<!-- Products End -->

@endsection