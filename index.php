<?php
    require_once("config.php");
    class start extends Telegram\Api\Command{
        public function handle(){
            $this->replyMessage("Welcome to the bot!");
        }
    }
    class ping extends Telegram\Api\Command{
        public function handle(){
            $this->replyChatAction(self::TYPING);
            
            $keyboard = $this->createInlineKeyboard([[["text"=>"Click me","url"=>"https://www.google.com"],["text"=>"Hello","callback_data"=>"callback_data0"]],[["text"=>"Hello2","callback_data"=>"callback_data1"]]]);
            $this->replyInlineKeyboardMessage("Welcome to the bot!",$keyboard);
        }
    }
    $bot = new \Telegram\Api\Bot('1755386616:AAFH3PIzoumgJn1nOEy-i_YV8evDUUWq0qk');
    $bot->registerCommands(['start','ping']);
    $bot->capture();
?>