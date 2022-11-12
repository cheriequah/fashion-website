<?php

namespace App\Http\Conversations;

use App\Models\Order;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Auth;

// delivery stuff
class recommend extends Conversation {

    public function option($bot) {
        $question = Question::create('What is your body shape?')
        ->fallback('Unable to get your question, Please select from the provided category')
        ->callbackId('create_options')
        ->addButtons([
            Button::create('Rectangle')->value('rectangle'),
            Button::create('Inverted Triangle')->value('inverted-triangle'),  
            Button::create('Hourglass')->value('hourglass'),
            Button::create('Pear')->value('pear'),
            Button::create('Apple')->value('apple'),     
        ]);
        $bot->ask($question, function (Answer $answer) {
            // Detect if button was clicked:
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue(); 
                $selectedText = $answer->getText();
                if ($selectedValue == "rectangle") {
                    $this->say($selectedText);
                    $this->bot->typesAndWaits(1);
                    $this->say('Fitted blazers with shoulder pads that add definition, details around the bust and shoulders paired with low-rise jeans or pencil skirts with belted waists can really transform a rectangle shape for your most confident dressing yet.');
                    // show suggestion cloth image
                } elseif ($selectedValue == "inverted-triangle") {
                    $this->say($selectedText);
                    $this->bot->typesAndWaits(1);
                    $this->say('Lots of styles suit this shape, which tends to be of a more athletic build. Wear clothes that accentuate your bottom, or that are bold and patterned and pair them with open necklines or strappy tops that minimise the broadness of the shoulders without reducing your natural curves and bust. Avoid shoulder pads or embellishments around the shoulders.');
                } elseif ($selectedValue == "hourglass") {
                    $this->say($selectedText);
                    $this->bot->typesAndWaits(1);
                    $this->say('Most things suit hourglass shapes, but if you really want to embrace your curves, fitted clothes that are belted around the waist will look amazing on you, creating a figure-flattering silhouette.');
                } elseif ($selectedValue == "pear") {
                    $this->say($selectedText);
                    $this->bot->typesAndWaits(1);
                    $this->say('With pear shapes, it’s all about balance. Accentuate your top half with horizontal stripes, patterns or embellishments and save dark colours and straight lines for your bottom half to balance out your body shape.');
                } elseif ($selectedValue == "apple") {
                    $this->say($selectedText);
                    $this->bot->typesAndWaits(1);
                    $this->say('Embrace those curves! Tone down your midsection and choose styles that accentuate your waist, such as belted dresses and high-waisted jeans.');
                }
            }
        });
    }

    // This will be called immediately
    public function run()
    {
        $this->option($this->bot);  
    }
}