<?php
    require_once("config.php");
    class start extends Telegram\Api\Command{
        public function handle(){
            $this->sendReply("sendPhoto",array("photo"=>new CURLFile(realpath("wallpaperflare.com_wallpaper.jpg"))));
        }
    }
    class ping extends Telegram\Api\Command{
        public function handle(){
            $this->sendReply("sendMessage",array("text"=>"Oombikko!!"));
        }
    }
    $bot = new \Telegram\Api\Bot('1755386616:AAFH3PIzoumgJn1nOEy-i_YV8evDUUWq0qk');
    $bot->registerCommands(['start','ping']);
    $bot->capture();
?>