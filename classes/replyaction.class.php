<?php
    namespace \Telegram\Api\Action;
    class ReplyAction{
        protected $chatId;
        protected function __construct($filterObj){
            $this->chatId = $filterObj->chatId;
        }
        
    }
?>