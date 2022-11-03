<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <tr>
        <td>Dear {{ $name }}</td>
    </tr>
    <tr>
        <td>Thank you for shopping with us. Your order details are as below:-</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Order Id: {{ $order_id }}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <table style="background-color: #e1e1e1" cellpadding="5" cellspacing="5">
        <tr style="background-color: #a6a6a6">
            <th>Product Name</th>
            <th>Code</th>
            <th>Size</th>
            <th>Color</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        @foreach ($orderDetails['orders_products'] as $order)
        <tr>
            <td>{{ $order['product_name'] }}</td>
            <td>{{ $order['product_code'] }}</td>
            <td>{{ $order['product_size'] }}</td>
            <td>{{ $order['product_color'] }}</td>
            <td>{{ $order['product_qty'] }}</td>
            <td>RM {{ $order['product_price'] }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="5" style="text-align: right;">Shipping Fee:</td>
            <td>RM {{ $orderDetails['shipping_fee'] }}</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right;">Total:</td>
            <td>RM {{ $orderDetails['total'] }}</td>
        </tr>  
    </table>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Delivery Address</th>
        </tr>
        <tr>
            <td>{{ $orderDetails['name'] }}</td>
        </tr>
        <tr>
            <td>{{ $orderDetails['mobile'] }}</td>
        </tr>
        <tr>
            <td>{{ $orderDetails['address'] }}, {{ $orderDetails['city'] }}, {{ $orderDetails['postcode'] }}, {{ $orderDetails['state'] }}, {{ $orderDetails['country'] }}</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
    </table>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>For any enquiries, you may contact us at info@pearlwonder.com</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Thanks & Regards,</td>
    </tr>
    <tr>
        <td>Pearl Wonder Website</td>
    </tr>
</body>
</html>

