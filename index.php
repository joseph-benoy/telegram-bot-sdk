<?php
    require_once("config.php");
    class start extends Telegram\Api\Command{
        public function handle(){
            $this->replyMessage("Welcome to the bot!");
        }
    }
    class ping extends Telegram\Api\Command{
        public function handle(){
            $this->replyPhoto("wallpaperflare.com_wallpaper.jpg");
        }
    }
    $bot = new \Telegram\Api\Bot('1755386616:AAFH3PIzoumgJn1nOEy-i_YV8evDUUWq0qk');
    $bot->registerCommands(['start','ping']);
    $bot->capture();
?>