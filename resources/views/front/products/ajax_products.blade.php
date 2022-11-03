<?php use App\Models\Product; ?>

<div class="tab-pane fade show active" id="grid">
    @foreach ($categoryProducts as $product)
    <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
        <div class="card product-product border-0 mb-4">
            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                <a href="{{ url('product/'.$product['id']) }}">
                    @if (isset($product['image']))
                        <?php $product_img_path = "assets/img/product_images/medium/".$product['image'] ?>
                    @else
                        <?php $product_img_path = ""; ?>
                    @endif 
                    @if (!empty($product['image'])  && file_exists($product_img_path))
                        <img style="width: -webkit-fill-available" src="{{ asset('assets/img/product_images/medium/'.$product['image']) }}" alt="">
                    @else
                        <img style="width: -webkit-fill-available" src="{{ asset('assets/img/product_images/medium/no_image.png') }}" alt="">
                    @endif</a>
            </div>
            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                <h6 class="text-truncate mb-3">{{ $product['name'] }}</h6>
                <div class="d-flex justify-content-center">
                    <?php $discountedPrice = Product::getDiscountPrice($product['id']); ?>
                    @if ($discountedPrice>0)
                        <h6>RM {{ $discountedPrice }}</h6><h6 class="text-muted">&nbsp;<del>RM {{ $product['price'] }}</del></h6>
                    @else
                        <h6>RM {{ $product['price'] }}</h6>
                    @endif
                </div>
                <h6>Pattern: {{ $product['pattern_id'] }}</h6>
                <h6>Occasion: {{ $product['occasion_id'] }}</h6>
                <h6>Color: {{ $product['color_id'] }}</h6>
                <h6>Sleeve: {{ $product['sleeve_id'] }}</h6>
                <h6>Material: {{ $product['material_id'] }}</h6>
            </div>
            <div class="card-footer d-flex justify-content-between bg-light border">
                <a href="{{ url('product/'.$product['id']) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
            </div>
        </div>
    </div>
    @endforeach
</div>