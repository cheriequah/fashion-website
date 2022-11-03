<?php

use App\Models\Order;
use BotMan\BotMan\Messages\Conversations\Conversation;
use Illuminate\Support\Facades\Auth;

class shipping_status extends Conversation {

    public function askOrders() {
        
        dd("Test");
        //$order = Order::select('id','order_status')->where('user_id',Auth::user()->id)->get()->first->toArray();
        //dd($order); die;
        //$this->reply("Your order id".$order['id'].", the status is ".$order['order_status']);
    }

    public function run()
    {
        // This will be called immediately
        $this->askOrders();
    }
}