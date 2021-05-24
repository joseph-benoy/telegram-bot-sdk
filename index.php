<?php
    require_once("config.php");
    class start extends Telegram\Api\Command{
        public function handle(){
            $this->replyMessage("Welcome to the bot!");
        }
    }
    class ping extends Telegram\Api\Command{
        public function handle($randomMessage=null,$commandSessionObj=null,$queryData=null){
            if($commandSessionObj==null){
                $keyboard = $this->createInlineKeyboard([[["text"=>"Click me","url"=>"https://www.google.com"],["text"=>"Hello","callback_data"=>"callback_data0"]],[["text"=>"Hello2","callback_data"=>"@@@@@@@@"]]]);
                $this->replyInlineKeyboardMessage("Welcome to the bot!",$keyboard);
                $this->setCommandSession("secondSession");
                return;
            }
            if($commandSessionObj->sessionName=="secondSession"){
                $this->replyMessage("222222222222222222");
                $keyboard = $this->createInlineKeyboard([[["text"=>"Click me","url"=>"https://www.google.com"],["text"=>"Hello","callback_data"=>"callback_data0"]],[["text"=>"second_session_hello","callback_data"=>"%%%%%%%%%%%%%%%%%"]]]);
                $this->replyInlineKeyboardMessage("Welcome to the bot!",$keyboard);
                $this->setCommandSession("thirdSession");
                return;
            }
            if($commandSessionObj->sessionName=="thirdSession"){
                $this->replyMessage("33333333333333{$commandSessionObj->sessionName} : {$queryData}");
                $this->replyMessage("ALL SESSIONS COMPLETED!");
                $this->setCommandSession("fourthSession");
                return;
            }
            if($commandSessionObj->sessionName=="fourthSession"){
                $this->replyMessage("Your maessage is".$randomMessage);
                $this->deleteCommandSession();
                $this->replyMessage("Session Over!");
                return;
            }
        }
    }
    $bot = new \Telegram\Api\Bot('1755386616:AAFH3PIzoumgJn1nOEy-i_YV8evDUUWq0qk');
    $bot->registerCommands(['start','ping']);
    $bot->capture();
?>