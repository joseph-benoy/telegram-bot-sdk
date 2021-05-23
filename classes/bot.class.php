<?php
    namespace Telegram\Api;
    class Bot{
        protected $apiToken;
        protected $classArray=[];
        public function __construct($token,$classArray=null){
            $this->apiToken = $token;
            if($classArray!=null){
                foreach($classArray as $class){
                    array_push($this->classArray,$class);
                }
            }
        }
        protected function isCommand($text){
            if(substr($text,0,1)=="/"){
                return true;
            }
            else{
                return false;
            }
        }
        protected function filterUpdate($updateObj):\stdClass{
            if(property_exists($updateObj,'callback_query')){
                $filterObj = new \stdClass;
                $filterObj->chatId = $updateObj->callback_query->from->id;
                $filterObj->queryData = $updateObj->callback_query->data;
                return $filterObj;
            }
            elseif($this->isCommand($updateObj->message->text)){
                if($cmd = $this->getCommandName($updateObj->message->text)!=null){
                    $filterObj = new \stdClass;
                    $filterObj->chatId = $updateObj->message->chat->id;
                    $filterObj->commandName = $cmd;
                    return $filterObj;
                }
                else{
                    $filterObj = new \stdClass;
                    $filterObj->chatId = $updateObj->message->chat->id;
                    $filterObj->commandName = "";
                    return $filterObj;
                }
            }
            else{
                $filterObj = new \StdClass;
                $filterObj->chatId = $updateObj->message->chat->id;
                return $filterObj;
            }
        }
        protected function getCommandName($text){
            $data = ltrim($text,"/");
            if(in_array($data,$this->classArray)){
                return $data;
            }
            else{
                return null;
            }
        }
        public function capture():void{
            $updateObj = json_decode(file_get_contents("php://input"));
            $filterObj = $this->filterUpdate($updateObj);
            if(property_exists($filterObj,'queryData')){
                //execute as callback_query
            }
            elseif(property_exists($filterObj,'commandName')){
                //execute as registered command
                if($filterObj->commandName==""){
                    $this->sendError($filterObj,"Invalid Command");// send error message because command is not registered
                }
                else{
                    $this->executeCommand($filterObj,$updateObj);
                }
            }
            else{
                //execute as random input
            }
        }
        protected function executeCommand($filterObj,$updateObj):void{
            $command = new $filterObj->commandName($this->apiToken,$updateObj);
            $command->handle();
        }
    }

?> 