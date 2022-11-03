<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use \BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Middleware\ApiAi;
use BotMan\BotMan\Middleware\Dialogflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use shipping_status;

class BotManController extends Controller
{
    /*
    public function handle()
    {
        $botman = resolve('botman');

        //$config = ['web'=>['matchingData'=>['driver'=>'web']]];

        //DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
        //$botman = BotManFactory::create($config);
        $dialogflow = ApiAi::create('ya29.a0Aa4xrXMjxE73VJlk7TlyyNS1HmyAvgzp86uWJIRdWWPxlwLeFOBXDBj6Vmy_yqA7YdmTZtTManBXI6V1uVFm1S3cgyooL0ts5DXpPu6sHWWfvOGJ5ZuC0njI5zNtYWIn9ZYF9v1Hml0-ReSTVvrbLQ81wbpwIAaCgYKATASARMSFQEjDvL9As0iL_s9ufMBn1KnnjfLdA0165')->listenForAction();

        $botman->middleware->received($dialogflow);
        //info('incoming', request()->all());
        
        $botman->exception(Exception::class, function($exception, $bot) {
            \Illuminate\Support\Facades\Log::info("Exception");
            $bot->reply('Sorry, something went wrong');
        
            if (method_exists($bot->getDriver(), 'messagesHandled'))
                $bot->getDriver()->messagesHandled();
        });
        $botman->hears('about.about', function (Botman $bot) {
            Log::info("hear");
            $extras = $bot->getMessage()->getExtras();
            $message = $extras['apiParameters']['geo-city'];
            $extras = $bot->getMessage()->getExtras();
    
            $apiReply = $extras['apiReply'];
            $apiAction = $extras['apiAction'];
            $apiIntent = $extras['apiIntent'];
            Log::info($extras);
            $bot->reply('this is my reply');
            $bot->reply('hi'.$message);
            $bot->reply($apiReply);
 
            
        })->middleware($dialogflow);
        // dialogflow will take care of match the action not the actual text

        $botman->listen();
    }*/

public function handle()
{
    
        $botman = app('botman');

        $botman->hears('{message}', function ($botman, $message) {

            // When user initiates the conversation with $message
            if ($message == 'hi' || $message == 'hello' || $message == 'hey') {
                // Check if user is login
                if (Auth::check()) {
                    $user = Auth::user()->name;
                    $botman->reply("Hello ".$user.". I'm a chatbot. I'm always here to help you with your issues.");
                    $this->option($botman);
                }else {
                    $this->askName($botman);
                    $this->option($botman);
                }    
            } else {
                $botman->reply("write 'hi' to start the conversation");
            }
        });
        $botman->listen();
    
}
    /**
     * Place your BotMan logic here.
     */
    public function askName($bot)
    {
        $bot->ask('Hello! What is your Name?', function (Answer $answer) {

            $name = $answer->getText();

            $this->say('Nice to meet you ' . $name);
        });
    }

    public function option($bot) {
        $question = Question::create('Please select a category for your question')
        ->fallback('Unable to get your question, Please select from the provided category')
        ->callbackId('create_options')
        ->addButtons([
            Button::create('Shipping Status')->value('status'),
            Button::create('My Orders')->value('orders'),
        ]);
        $bot->ask($question, function (Answer $answer) {
            // Detect if button was clicked:
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue(); // will be either 'yes' or 'no'
                $selectedText = $answer->getText(); // will be either 'Of course' or 'Hell no!'
                if ($selectedValue == "status") {
                    // display order status
                    //$this->say('clicked ');
                    //$this->bot->startConversation(new shipping_status);
                    //$order = Order::select('id','order_status')->where('user_id',Auth::user()->id)->get()->first->toArray();
                    //dd($order); die;
                    //$this->reply("Your order id".$order['id'].", the status is ".$order['order_status']);
                }
                
            }

                

        });
    }
}
