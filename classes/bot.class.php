<?php
    namespace Telegram\Api;
    class Bot{
        protected $apiToken;
        protected $classArray=[];
        protected $callbackQueryArray=[];
        public function __construct($token,$classArray=null,$callbackQueryArray=null){
            $this->apiToken = $token;
            if($classArray!=null){
                foreach($classArray as $class){
                    if(!in_array($class,$this->classArray)){
                        array_push($this->classArray,$class);
                    }
                }
            }
            if($callbackQueryArray!=null){
                foreach($callbackQueryArray as $query){
                    if(!in_array($query,$this->callbackQueryArray)){
                        array_push($this->callbackQueryArray,$query);
                    }
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
        protected function getQueryName($data){
            if(in_array($data,$this->callbackQueryArray)){
                return $data;
            }
            else{
                return null;
            }
        }
        protected function filterUpdate($updateObj):\stdClass{
            if(property_exists($updateObj,'callback_query')){
                $queryName = $this->getQueryName($updateObj->callback_query->data);
                if($queryName!=null){
                    $filterObj = new \stdClass;
                    $filterObj->chatId = $updateObj->callback_query->from->id;
                    $filterObj->queryData =$queryName;
                    return $filterObj;
                }
                else{
                    $filterObj = new \stdClass;
                    $filterObj->chatId = $updateObj->callback_query->from->id;
                    $filterObj->queryData = null;
                    return $filterObj;
                }
            }
            elseif($this->isCommand($updateObj->message->text)){
                $cmd = $this->getCommandName($updateObj->message->text);
                if($cmd!=null){
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
                if($filterObj->queryData==""){
                    //$this->sendError($filterObj,"Invalid callback query");
                }
                else{
                    error_log("###################",0);
                    $this->executeCallbackQuery($filterObj,$updateObj);
                }
            }
            elseif(property_exists($filterObj,'commandName')){
                //execute as registered command
                if($filterObj->commandName==""){
//                    $this->sendError($filterObj,"Invalid Command");// send error message because command is not registered
                }
                else{
                    $this->executeCommand($filterObj,$updateObj);
                }
            }
            else{
                //execute as random input
                error_log("RRRRRRRRRRRRRRRRRRRRRRRR",0);
            }
        }
        protected function executeCommand($filterObj,$updateObj):void{
            $class = $filterObj->commandName;
            $command = new $class($this->apiToken,$updateObj);
            $command->handle();
        }
        public function registerCommands($class_array){
            foreach($class_array as $class){
                if(!in_array($class,$this->classArray)){
                    array_push($this->classArray,$class);
                }
            }
        }
        public function registerCallbackQueries($callbackQueryArray){
            foreach($callbackQueryArray as $query){
                if(!in_array($query,$this->callbackQueryArray)){
                    array_push($this->callbackQueryArray,$query);
                }
            }
        }
        protected function executeCallbackQuery($filterObj,$updateObj):void{
            
        }
    }

?> 