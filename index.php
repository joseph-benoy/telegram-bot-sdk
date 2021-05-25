<?php
    require_once("config.php");
    class start extends Telegram\Api\Command{
        public function handle(){
            $this->replyMessage("Welcome to the bot!");
        }
    }
    class ping extends Telegram\Api\Command{
        public function handle($randomMessage=null,$commandSessionObj=null,$queryData=null){

            $obj = new Telegram\component\ReplyKeyboard();
            $obj->addRow([["text"=>"@@@@","callback_data"=>"@@@@"],["text"=>"google","callback_data"=>"######"]]);
            $result = $this->replyMessage("HHHHH",$obj->getMarkup());
        
        
        
        
        
        
        
            error_log("@@@@@@@@@@ = {$result}",0);
        }
    }
    $bot = new \Telegram\Api\Bot('1755386616:AAFH3PIzoumgJn1nOEy-i_YV8evDUUWq0qk');
    $bot->registerCommands(['start','ping']);
    $bot->capture();
?>