<?php
    namespace Telegram\Api;
    abstract class Command{
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
        protected function sendReply($method,$data){
            $url = "https://api.telegram.org/bot".$this->apiToken. "/" . $method;
            $curl = curl_init();
            if($method!='sendMessage'){
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    "Content-Type:multipart/form-data"
                ));
            }
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, $url); 
            $output = curl_exec($curl);
            curl_close($curl);
            return $output;
        }
        protected function replyMessage($text){
            $data = array("chat_id"=>$this->getChatId(),"text"=>$text);
            $this->sendReply('sendMessage',$data);
        }
        protected function replyPhoto($path){
            $data=null;
            if($caption!=null){
                $data = array("chat_id"=>$this->getChatId(),'caption'=>$caption,"photo"=>new \CURLFile(realpath($path)));
            }
            else{
                $data = array("chat_id"=>$this->getChatId(),"photo"=>new \CURLFile(realpath($path)));
            }
            $this->sendReply('sendPhoto',$data);
        }
        protected function replyDoc($path){
            $data=null;
            if($caption!=null){
                $data = array("chat_id"=>$this->getChatId(),'caption'=>$caption,"document"=>new \CURLFile(realpath($path)));
            }
            else{
                $data = array("chat_id"=>$this->getChatId(),"document"=>new \CURLFile(realpath($path)));
            }
            $this->sendReply('sendDocument',$data);
        }
        protected function replyAudio($path,$caption=null){
            $data=null;
            if($caption!=null){
                $data = array("chat_id"=>$this->getChatId(),'caption'=>$caption,"audio"=>new \CURLFile(realpath($path)));
            }
            else{
                $data = array("chat_id"=>$this->getChatId(),"audio"=>new \CURLFile(realpath($path)));
            }
            $this->sendReply("sendAudio",$data);
        }
    }
?>