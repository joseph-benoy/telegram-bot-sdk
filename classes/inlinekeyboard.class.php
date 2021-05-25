<?php
    namespace Telegram\component;
    class InlineKeyboard{
        public $keyboard = array();
        public function addRow($row){
            array_push($this->keyboard,$row);
        }
        public function getMarkup(){
            return json_encode(
                array(
                    'inline_keyboard'=>$this->keyboard
                )
            );
        }
    }
?>