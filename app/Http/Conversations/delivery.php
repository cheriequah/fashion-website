<?php

namespace App\Http\Conversations;

use App\Models\Order;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Auth;

// delivery stuff
class delivery extends Conversation {

    public function option($bot) {
        $question = Question::create('Please select a relevant topic')
        ->fallback('Unable to get your question, Please select from the provided category')
        ->callbackId('create_options')
        ->addButtons([
            Button::create('Track Order Status')->value('status'),
            Button::create('Shipping Fee')->value('shipping fee'),       
        ]);
        $bot->ask($question, function (Answer $answer) {
            // Detect if button was clicked:
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue(); 
                $selectedText = $answer->getText();
                if ($selectedValue == "status") {
                    
                    // display order status
                    $this->say($selectedText);

                    // Check if user logged in
                    if (Auth::check()) {
                        $orderCount = Order::where('user_id',Auth::user()->id)->count();

                        // Check if there are orders 
                        if ($orderCount > 0) {
                            // Get the latest order 
                            $order = Order::select('id','order_status')->where('user_id',Auth::user()->id)->latest()->get()->first->toArray();
                            $this->bot->typesAndWaits(1);
                            $this->say("Your order id ".$order['id'].", the status is ".$order['order_status']);
                        } else {
                            $this->bot->typesAndWaits(1);
                            $this->say("You have no orders currently.");
                        }
                    } else {
                        $this->bot->typesAndWaits(1);
                        $this->say("Please place your order and login to check your orders status.");
                    }                 
                    //$order = Order::select('id','order_status')->where('user_id',Auth::user()->id)->get()->first->toArray();
                    //dd($order); die;
                    //$this->reply("Your order id".$order['id'].", the status is ".$order['order_status']);
                } elseif ($selectedValue == "shipping fee") {
                    $this->say($selectedText);
                    $this->bot->typesAndWaits(1);
                    $this->say('Our shipping fees are RM 7 for West Malaysia, RM 8 for East Malaysia.');
                    $this->bot->typesAndWaits(1);
                    $this->say('We currently only ship to Malaysia.');
                }
                //$this->askOrders();  
            }
        });
    }

    public function askOrders() {
        $this->say("Hello");
        $order = Order::select('id','order_status')->where('user_id',Auth::user()->id)->get()->first->toArray();
        $this->say("Your order id ".$order['id'].", the status is ".$order['order_status']);
    }

    // This will be called immediately
    public function run()
    {
        $this->option($this->bot);  
        //$this->askOrders();
    }
}