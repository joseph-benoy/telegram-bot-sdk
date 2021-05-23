<?php
    namespace Telegram;
/**
 * [Base class for the bot sdk]
 */
    class Bot{
        protected $apiToken;
        protected $classArray=[];
        /**
         * Pass api token. Optionally can pass the command class array
         * @param mixed $token api token
         * @param mixed $classArray=null command class array
         */
        public function __construct($token,$classArray=null){
            $this->apiToken = $token;
            if($classArray!=null){
                foreach($classArray as $class){
                    array_push($this->classArray,$class);
                }
            }
        }
        /**
         * capture the update object sent to webhook
         * @return void
         */
        public function capture():void{
            $updateObj = file_get_contents("php://input");
            $filterObj = filterUpdate($updateObj);
            if(property_exists($filterObj,'queryData')){
                //execute as callback_query
            }
            elseif(property_exists($filterObj,'commandName')){
                //execute as registered command
            }
            else{
                //execute as random input
            }
        }
        /**
         * filter the update object and return filter object to identify the type
         * @param mixed $updateObj
         * 
         * @return stdClass
         */
        public function filterUpdate($updateObj):stdClass{
            if(property_exists($updateObj,'callback_query')){
                $filterObj = new stdClass;
                $filterObj->chatId = $updateObj->callback_query->from->id;
                $filterObj->queryData = $updateObj->callback_query->data;
                return $filterObj;
            }
            elseif($cmd = getCommandName($updateObj)!=null){
                $filterObj = new stdClass;
                $filterObj->chatId = $updateObj->message->chat->id;
                $filterObj->commandName = $cmd;
                return $filterObj;
            }
            else{
                $filterObj = new StdClass;
                $filterObj->chatId = $updateObj->message->chat->id;
                return $filterObj;
            }
        }
        /**
         * Get filter out command name from update object . Returns null if the command is not registeres
         * @param mixed $updateObj
         * 
         * @return [type]
         */
        public function getCommandName($updateObj){
            $data = ltrim($updateObj->message->text,"/");
            if(in_array($data,$this->classArray)){
                return $data;
            }
            else{
                return null;
            }
        }
    }
?> 