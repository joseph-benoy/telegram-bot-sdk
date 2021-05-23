<?php
    namespace \Telegram\Api\Actions;
    class ReplyAction{
        protected $chatId;
        protected function __construct($filterObj){
            $this->chatId = $filterObj->chatId;
        }
        
    }
?>