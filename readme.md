# Telegram-bot-sdk

Simple telegram bot api wrapper libary written in PHP. Supports most of the methods listed in [Bot api page](https://core.telegram.org/bots/api) .
# Usage

```php
<?php

require_once("autoload.php"); //autoload all classes required

/**

* [Start command with handle method defintion]

*/

class  start  extends Telegram\Api\Command{

public  function  handle(){

$this->replyMessage("Welcome to the bot!");

}

}

$bot  =  new \Telegram\Api\Bot('bot_token'); //enter your bot token here

$bot->registerCommands(['start','ping']); //register the command to the bot handler class

$bot->capture(); //capture the commands invoked by the client

?>
```

# License
MIT


