<?php
    namespace Telegram\Api;
    abstract class Command extends \Telegram\Api\Actions\ReplyActions{
        protected $updateObj;
        protected $apiToken;
        public function __construct($apiToken,$updateObj){
            $this->updateObj = $updateObj;
            $this->apiToken = $apiToken;
        }
        abstract public function handle();
        public function getChatId():string{
            return $this->updateObj->message->chat->id;
        }
        public function getText(){
            return $this->updateObj->message->text;
        }
        public function getUsername(){
            return $this->updateObj->from->username;
        }
        public function getFullname(){
            return  $this->updateObj->from->first_name." ".$this->updateObj->from->last_name;
        }
    }
?>