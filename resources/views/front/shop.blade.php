{{--
use App\Models\Category;
use App\Models\Color;
use App\Models\Material;
use App\Models\Occasion;
use App\Models\Pattern;
use App\Models\Sleeve;
$categories = Category::getCategories();
$colors = Color::getColors();
$materials = Material::getMaterials();
$occasions = Occasion::getOccasions();
$patterns = Pattern::getPatterns();
$sleeves = Sleeve::getSleeves();
//echo "<pre>"; print_r($colors); die;
--}}

@extends('layouts.front_layout.front_layout')
@section('content')

<!-- Page Header Start -->
<main>
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Our Shop</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="url('/')">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shop</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            @include('layouts.front_layout.front_sidepanel')
            <!-- Shop Sidebar End -->

            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">  
                        <div class="container">          
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-style1">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0);">Home</a>
                                </li>
                                <li class="breadcrumb-item active"><?php echo $categoryDetails['breadcrumbs'] ?></li>
                                </ol>
                            </nav>            
                            <div class="wrap-shop-control">

                                <h1 class="shop-title d-inline-block">Digital & Electronics</h1>
        
                                <div class="d-flex align-items-center justify-content-between float-end">
        
                                  <form name="sort-products" id="sort-products">
                                    <input type="hidden" id="slug" name="slug" value="{{ $slug }}">
                                    <div class="sort-item orderby">
                                        <select name="orderby" id="orderby" class="form-select form-select-sm">
                                            <option value="">Default sorting</option>
                                            <option value="sort_latest" @if (isset($_GET['orderby']) && $_GET['orderby']=="sort_latest") selected=""                    
                                            @endif>Sort by Latest</option>
                                            <option value="sort_a_z" @if (isset($_GET['orderby']) && $_GET['orderby']=="sort_a_z") selected=""                    
                                            @endif>Sort by A-Z</option>
                                            <option value="sort_z_a" @if (isset($_GET['orderby']) && $_GET['orderby']=="sort_z_a") selected=""                    
                                            @endif>Sort by Z-A</option>
                                            <option value="price_lowest" @if (isset($_GET['orderby']) && $_GET['orderby']=="price_lowest") selected=""                    
                                            @endif>Sort by Price: Low to High</option>
                                            <option value="price_highest" @if (isset($_GET['orderby']) && $_GET['orderby']=="price_highest") selected=""                    
                                            @endif>Sort by Price: High to Low</option>
                                        </select>
                                    </div>                                   
                                </form>
        
                                    <div class="sort-item product-per-page">
                                        <select name="items-per-page" class="form-select form-select-sm">
                                            <option value="12">12 per page</option>
                                            <option value="15">15 per page</option>
                                            <option value="18">18 per page</option>
                                            <option value="21">21 per page</option>
                                            <option value="24">24 per page</option>
                                            <option value="27">27 per page</option>
                                            <option value="30">30 per page</option>
                                        </select>
                                    </div>
                                
                                 

                                   {{-- <div class="change-display-mode">
                                        <ul class="nav nav-tabs" id="myTab">
                                            <li class="nav-item">
                                                <a href="#grid" class="nav-link active" data-bs-toggle="tab"><i class="fa fa-th"></i>Grid</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#list" class="nav-link" data-bs-toggle="tab"><i class="fa fa-th-list"></i>List</a>
                                            </li>
                                        </ul>
                                    </div>--}}
                                    
                                </div>
        
                            </div><!--end wrap shop control-->
                        </div>
                    </div>
                  
                    <div class="col-12 tab-content filter_products">
                        @include('front.products.ajax_products')
                        {{--<div class="tab-pane fade show" id="list">
                            <h4 class="mt-2">Home tab content</h4>
                            <p>Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui. Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth.</p>
                        </div>--}}
                    </div>

                    <div class="wrap-pagniation-info">
                        <!--if isset and not empty the value of orderby, append into pagination link-->
                        
                        @if (isset($_GET['orderby']) && !empty($_GET['orderby']))
                            {{ $categoryProducts->appends(['orderby' => $_GET['orderby']])->links() }}   
                        @else
                            {{ $categoryProducts->links() }}
                            <?php print_r($_GET); ?>
                            <!--{{ $categoryProducts->appends(['orderby' => 'vote'])->links() }}   -->
                        @endif
                        
                           
                        {{--<ul class="pagination justify-content-center mb-3">
                            <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                            </li>
                        </ul>--}}
                      
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
</main>
<!-- Shop End -->




@endsection