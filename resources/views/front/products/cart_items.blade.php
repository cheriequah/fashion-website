<?php use App\Models\Product; ?>

<table class="table table-bordered text-center mb-0">
    <thead class="bg-secondary text-dark">
        <tr>
            <th>Products</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Product Discount</th>
            <th>Total</th>
            {{-- <th>Remove</th> --}}
        </tr>
    </thead>
    <tbody class="align-middle">
        <?php $total_price = 0; ?>
        @foreach ($userCartItems as $cartItem)
        <?php $productPriceAttr = Product::getDiscountAttrPrice($cartItem['product_id'],$cartItem['size']); ?>
        <tr>
            <td class="align-middle"><img src="{{ asset('assets/img/product_images/small/'.$cartItem['product']['image']) }}" alt="" style="width: 100px;"></td>
            <td class="align-middle">{{ $cartItem['product']['name'] }} ({{ $cartItem['product']['code'] }})<br>
            Color: <br>
            Size: {{ $cartItem['size'] }}</td>
            <td class="align-middle">RM {{ $productPriceAttr['product_price'] }}</td>
            <td class="align-middle">
                <div class="input-group mx-auto" style="width: 125px;"> 
                    <input type="text" class="form-control form-control-sm bg-secondary text-center" value="{{ $cartItem['quantity'] }}">
                    <button class="btn btn-sm btn-primary btn-minus btnItemUpdate qtyMinus" data-cartid="{{ $cartItem['id'] }}">
                        <i class="fa fa-minus"></i>
                        </button>
                    <button class="btn btn-sm btn-primary btn-plus btnItemUpdate qtyPlus" data-cartid="{{ $cartItem['id'] }}">
                        <i class="fa fa-plus"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btnItemRemove" data-cartid="{{ $cartItem['id'] }}"><i class="fa fa-times"></i></button>
        
                </div>
            </td> 
            <td>RM {{ $productPriceAttr['discount'] }}</td>
            <td class="align-middle">RM {{ $productPriceAttr['final_price'] * $cartItem['quantity'] }}</td>
            {{-- <td class="align-middle"><button class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button></td> --}}
        </tr>
        <?php $total_price = $total_price + ($productPriceAttr['final_price'] * $cartItem['quantity']); ?>
        @endforeach
        <tr>
            <th colspan="5">Subtotal</th>
            <td>RM {{ $total_price }}</td>
        </tr>
        <tr>
            <th colspan="5">Shipping</th>
            <td>RM 0</td>
        </tr>
        <tr>
            <th colspan="5">Grand Total </th>
            <td>RM {{ $total_price - 0 }}</td>
        </tr>
    </tbody>
</table>