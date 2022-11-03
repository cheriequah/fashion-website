<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrdersLog;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
// reference the Dompdf namespace
use Dompdf\Dompdf;

class OrderController extends Controller
{
    public function orders() {
        Session::put('page','orders');
        $orders = Order::with('orders_products')->orderBy('id','Desc')->get()->toArray();
        return view('admin.orders.orders')->with(compact('orders'));
    }

    public function orderDetails($id) {
        $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        $userDetails = User::with('country')->where('id',$orderDetails['user_id'])->first()->toArray();
        $orderStatuses = OrderStatus::where('status',1)->get()->toArray();
        $orderLog = OrdersLog::where('order_id',$id)->get()->toArray();
        //dd($orderDetails);
        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails','orderStatuses','orderLog'));
    }

    public function updateOrderStatus(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            // Update Order Status
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
            Session::put('success_message','Order Status has been Updated Successfully!');

            $deliveryDetails = Order::select('name','email')->where('id',$data['order_id'])->first()->toArray();
            $orderDetails = Order::with('orders_products')->where('id',$data['order_id'])->first()->toArray();
            //$message = "Dear customer, your order #".$data['order_id']." status has been updated to 
            // Send Order Status Update Email
            //echo "<pre>"; print_r($deliveryDetails); die;
            $email = $deliveryDetails['email'];
            
            $messageEmail = [
                'email' => $email,
                'name' => $deliveryDetails['name'],
                'order_id' => $data['order_id'],
                'order_status' => $data['order_status'],
                'orderDetails' => $orderDetails
            ];
            Mail::send('emails.order_status',$messageEmail,function($message) use($email) {
                $message->to($email)->subject('Order Status Update - Pearl Wonder Website');
            });

            // Update Order Log
            $log = new OrdersLog;
            $log->order_id = $data['order_id'];
            $log->order_status = $data['order_status'];
            $log->save();

            return redirect()->back();
        }
    }

    // parse order id in function
    public function viewOrderInvoice($id) {
        $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        $userDetails = User::with('country')->where('id',$orderDetails['user_id'])->first()->toArray();
        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));
    }

    public function printPDFInvoice($id) {
        $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        $userDetails = User::with('country')->where('id',$orderDetails['user_id'])->first()->toArray();

        $output = '<!DOCTYPE html>
        <html lang="en">
          <head>
            <meta charset="utf-8">
            <title>Example 1</title>
            <style>
              .clearfix:after {
          content: "";
          display: table;
          clear: both;
        }
        
        a {
          color: #5D6975;
          text-decoration: underline;
        }
        
        body {
          position: relative;
          width: 21cm;  
          height: 29.7cm; 
          margin: 0 auto; 
          color: #001028;
          background: #FFFFFF; 
          font-family: Arial, sans-serif; 
          font-size: 12px; 
          font-family: Arial;
        }
        
        header {
          padding: 10px 0;
          margin-bottom: 30px;
        }

        h1 {
          border-top: 1px solid  #5D6975;
          border-bottom: 1px solid  #5D6975;
          color: #5D6975;
          font-size: 2.4em;
          line-height: 1.4em;
          font-weight: normal;
          text-align: center;
          margin: 0 0 20px 0;
          background: url(dimension.png);
        }
        
        #project {
          float: left;
        }
        
        #project span {
          color: #5D6975;
          text-align: right;
          width: 52px;
          margin-right: 10px;
          display: inline-block;
          font-size: 0.8em;
        }
        
        #company {
          float: right;
          text-align: right;
        }
        
        #project div,
        #company div {
          white-space: nowrap;        
        }
        
        table {
          width: 100%;
          border-collapse: collapse;
          border-spacing: 0;
          margin-bottom: 20px;
        }
        
        table tr:nth-child(2n-1) td {
          background: #F5F5F5;
        }
        
        table th,
        table td {
          text-align: center;
        }
        
        table th {
          padding: 5px 20px;
          color: #5D6975;
          border-bottom: 1px solid #C1CED9;
          white-space: nowrap;        
          font-weight: normal;
        }
        
        table .service,
        table .desc {
          text-align: left;
        }
        
        table td {
          padding: 20px;
          text-align: right;
        }
        
        table td.service,
        table td.desc {
          vertical-align: top;
        }
        
        table td.unit,
        table td.qty,
        table td.total {
          font-size: 1.2em;
        }
        
        table td.grand {
          border-top: 1px solid #5D6975;;
        }
        
        #notices .notice {
          color: #5D6975;
          font-size: 1.2em;
        }
        
        footer {
          color: #5D6975;
          width: 100%;
          height: 30px;
          position: absolute;
          bottom: 0;
          border-top: 1px solid #C1CED9;
          padding: 8px 0;
          text-align: center;
        }
              </style>
          </head>
          <body>
            <header class="clearfix">
              <h1>ORDER INVOICE for Order #'.$orderDetails['id'].'</h1>
              <div id="company" class="clearfix">
                <div>Pearl Wonder</div>
                <div>455 Foggy Heights,<br /> AZ 85004, US</div>
                <div>(602) 519-0450</div>
                <div><a href="mailto:enquiry@pearlwonder.com">enquiry@pearlwonder.com</a></div>
              </div>
              <div id="project">
                <div><span>TO: </span>'.$orderDetails['name'].'</div>
                <div><span>ADDRESS: </span>'.$orderDetails['address'].','.$orderDetails['city'].','.$orderDetails['state'].','.$orderDetails['postcode'].','.$orderDetails['country'].'</div>  
                <div><span>EMAIL: </span> <a href="mailto:'.$orderDetails['email'].'">'.$orderDetails['email'].'</a></div>
                <div><span>PAYMENT METHOD: </span>'.$orderDetails['payment_method'].'</div>
                <div><span>DATE: </span> '.date('d-m-Y',strtotime($orderDetails['created_at'])).'</div>
              </div>
            </header>
            <main>
              <table>
                <thead>
                  <tr>
                    <th>Product Code</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>';
                  $sub_total = 0;
                  foreach($orderDetails['orders_products'] as $product) {
                  $output .= '<tr>
                    <td class="service">'.$product['product_code'].'</td>
                    <td class="desc">'.$product['product_size'].'</td>
                    <td class="unit">'.$product['product_color'].'</td>
                    <td class="qty">RM '.$product['product_price'].'</td>
                    <td class="qty">'.$product['product_qty'].'</td>
                    <td class="total">RM '.$product['product_price']*$product['product_qty'].'</td>
                  </tr>';
                  $sub_total = $sub_total + ($product['product_price']*$product['product_qty']);
                  }
                  $output .= '<tr>
                    <td colspan="5">SUBTOTAL</td>
                    <td class="total">RM '.$sub_total.'</td>
                  </tr>';
                  $output .= '<tr>
                    <td colspan="5" class="grand total">GRAND TOTAL</td>
                    <td class="grand total">RM '.$orderDetails['total'].'</td>
                  </tr>';
                  $output .= '</tbody>
              </table>
              <div id="notices">
                <div>NOTICE:</div>
                <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
              </div>
            </main>
            <footer>
              Invoice was created on a computer and is valid without the signature and seal.
            </footer>
          </body>
        </html>';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($output);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();  

        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));
    }
}
