<?php
    require_once("config.php");
    class start extends Telegram\Api\Command{
        public function handle(){
            $this->replyMessage("Welcome to the bot!");
        }
    }
    class ping extends Telegram\Api\Command{
        public function handle($commandSessionObj=null,$queryData=null){
            if($commandSessionObj==null&&$queryData==null){
                $this->replyChatAction(self::TYPING);
                $keyboard = $this->createInlineKeyboard([[["text"=>"Click me","url"=>"https://www.google.com"],["text"=>"Hello","callback_data"=>"callback_data0"]],[["text"=>"Hello2","callback_data"=>"@@@@@@@@"]]]);
                $this->replyInlineKeyboardMessage("Welcome to the bot!",$keyboard);
                $this->setCommandSession("secondSession");
                return true;
            }
            if($commandSessionObj->sessionName=="secondSession"){
                $this->replyMessage("{$commandSessionObj->sessionName} : {$queryData}");
                $keyboard = $this->createInlineKeyboard([[["text"=>"Click me","url"=>"https://www.google.com"],["text"=>"Hello","callback_data"=>"callback_data0"]],[["text"=>"%%%%","callback_data"=>"%%%%%%%%%%%%%"]]]);
                $this->replyInlineKeyboardMessage("Welcome to the bot!",$keyboard);
                $this->setCommandSession("thirdSession");
                return true;
            }
            if($commandSessionObj->sessionName=="thirdSession"){
                $this->replyMessage("{$commandSessionObj->sessionName} : {$queryData}");
                $this->replyMessage("ALL SESSIONS COMPLETED!");
                $this->deleteCommandSession();
            }
        }
    }
    $bot = new \Telegram\Api\Bot('1755386616:AAFH3PIzoumgJn1nOEy-i_YV8evDUUWq0qk');
    $bot->registerCommands(['start','ping']);
    $bot->capture();
?>