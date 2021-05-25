<?php
    require_once("config.php");
    class start extends Telegram\Api\Command{
        public function handle(){
            $this->replyMessage("Welcome to the bot!");
        }
    }
    class ping extends Telegram\Api\Command{
        public function handle($randomMessage=null,$commandSessionObj=null,$queryData=null){
            $this->replyMessage("!!!!!!!!!!!");

                $obj = new Telegram\component\InlineKeyboard();
                $obj->addRow([["text"=>"@@@@","callback_data"=>"@@@@"],["text"=>"google","url"=>"https://www.google.com"]]);
                $replyMarkup = $obj->getMarkup();
            $result = $this->sendReply("sendMessage",["chat_id"=>$this->getChatId(),"reply_markup"=>$replyMarkup,"text"=>"$$$$$$$$$$"]);
            error_log("@@@@@@@@@@ = {$result}",0);
        }
    }
    $bot = new \Telegram\Api\Bot('1755386616:AAFH3PIzoumgJn1nOEy-i_YV8evDUUWq0qk');
    $bot->registerCommands(['start','ping']);
    $bot->capture();
?>