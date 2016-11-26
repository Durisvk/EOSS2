# EOSS2

`EOSS` (stands for Event Oriented Server Side) is a free open-source PHP framework. It is not finished yet, but it's ready for use. EOSS could help you get around the basic PHP principles and do stuff that other frameworks can't do. It comes up with an idea of handling events (also intervals in new version) on a server-side. It creates the copy of a CSI (Client Side Interface) in format of HTML or PHP into an objects and make You able to use them as You were on client-side.

You start with a config file, which should look like this:

`app/config.eoss`:

```
    "home_eoss": "indexEOSS",
    "layout_dir": "view/",
    "models": "model/",
    "refresh": true,
    "enviroment": "debug"
```

`home_eoss` is a starting controller class, which is launched at the begining. It should contain the name of the class not the filename. The filename must be the same as the class name except for extension.
`layout_dir` is a directory path relative to `app/` folder where the views are located.
`models` is the path to the models of Your application. They are loaded at the very beginning before everything else.
`refresh` attribute tells the EOSS whether it should keep the session about the current state of Your EOSS class alive.
`enviroment` for now this property says if AJAX responses should be `console.log`ged.

Now that You have Your `config.eoss` ready, we can go ahead and create some stuff.

Let's create our view inside `app/view/` folder.

`app/view/layout.php`:

```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Todo</title>
</head>
<body>
    <div id="todos"></div>
    <input id="todo" type="text" />
    <input type="button" id="addTodo" value="Add Todo" />
</body>
</html>
```

Be careful about the elements id attributes. EOSS creates the structure of classes which will be called by these ids. It must not contain `-`. Now let's make our Todo list actually work by creating the `indexEOSS` inside our `app/controller/` directory.


`app/controller/indexEOSS.php`:

```php
<?php

use \EOSS\EOSS;

class indexEOSS extends EOSS
{

    private $counter = 1;

    public function load()
    {
        $this->csi->setFile("layout.php");
    }

    public function bind()
    {
        $this->csi->addTodo->onclick = "addTodoFunction";
    }

    public function addTodoFunction() {
        $this->csi->todos->html .= "<div>" . $this->counter . ": " . $this->csi->todo->value . "</div>";
        $this->csi->todo->value = "";
        $this->counter++;
    }


}
```

In load method we set the view file we've created earlier. We can pass parameters into the view by setting `$this->csi->params->anyKindOfParameter` to some value. Bind method is called after the EOSS generates the CSI structure of classes. Now we can access all of our view elements from `$this->csi->idOfAnElement`. In this phase we should bind all of the events and set all of the intervals we need. Events are passed as a string containing the name of the function. Then we need to implement this function. We can use private members and do with them whatever we want (e.g. increment them) and they will be stored inside Sessions.

This is it... We've got the working application.

# Events:

Let's create a `textbox` which content will be copied into a `div` element real-time.

First we will need a view. Let's create a `rewrite.php` file.

`app/view/rewrite/rewrite.php`:

```html
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
</head>
<body>
<div id="lblCopy"></div>
<input type="text" id="txtSource">
<input type="button" id="back" value="Back" />
<input type="button" id="next" value="Next" />
</body>
</html>
```

We will pass the `$title` parameter into the view from our EOSS controller. Let's now create `indexEOSS` class.

`app/controller/indexEOSS.php`:

```php
<?php

use \EOSS\EOSS;

class indexEOSS extends EOSS
{
    public function load()
    {
        $this->csi->setFile("rewrite/rewrite.php");
    }

    public function bind()
    {
        $this->csi->txtSource->onkeypress = "rewrite";
    }

    public function rewrite($keyCode) {
        $this->csi->lblCopy->html = $this->csi->txtSource->value;
    }


}
```

And we're done. That's it.

Available events(some will be added over time):

```json
{
  "onclick": "click",
  "onhover": "hover",
  "onchange": "change",
  "onfocus": "focus",
  "onfocusin": "focusin",
  "onfocusout": "focusout",
  "onload": "load",
  "onmousedown": "mousedown",
  "onkeypress": "keypress:keyCode"
}
```


# Intervals, Database and Registry:

Let's create something more advanced. We will create the chat application with the login information.

First let's create our login view.

`app/view/chat/chatLogin.php`:

```html

<!DOCTYPE html>
<html>
<head>
    <title>EOSS Introduction</title>
</head>
<body>
<div id="error" style="color: red"></div>
<input type="text" id="username" /><br>
<input type="password" id="password" /><br>
<input type="button" id="next" value="Next" />
</body>
</html>

```

Inside the `#error` we will print the `Invalid credentials` when the user enters wrong username or password.

Now let's create `indexEOSS`.

`app/controller/indexEOSS.php`:

```php
<?php

use \EOSS\EOSS;

class indexEOSS extends EOSS
{
    public function load()
    {
        $this->csi->setFile("chat/chatLogin.php");
    }

    public function bind()
    {
        $this->csi->next->onclick = "next";
    }


    public function next() {
        $database = new \Database\PDOWrapper('localhost', 'username', 'password', 'testdatabase');

        if($row = $database->prepareExecuteAndFetch("SELECT * FROM users WHERE username = ? AND password = ?", $this->csi->username->value, $this->csi->password->value)) {
            $this->csi->error->html = "";
            \EOSS\Registry::getInstance()->username = $this->csi->username->value;
            $this->redirect("chatEOSS");
        } else {
            $this->csi->error->html = "Invalid credentials.";
        }
    }


}
```

We will pass the username into the `chatEOSS` through the `Registry` which is the Singleton pattern and is stored inside Sessions.

Let's create a chat view.

`app/view/chat/chat.php`:

```html
<!DOCTYPE html>
<html>
<head>
    <title>EOSS Introduction</title>
</head>
<body>
<div id="chat"><?= isset($chat) ? $chat : "" ?></div>
<input type="text" id="message">
<input type="button" id="send" value="Send">
<input type="button" id="back" value="Back" />
</body>
</html>
```

Now we need to create a `ChatModel` which will look like this:

`app/models/ChatModel.php`:

```php
<?php

class ChatModel
{

    /**
     * @var \Database\PDOWrapper
     */
    private $database;

    public function __construct() {
        $this->database = new \Database\PDOWrapper('localhost', 'username', 'password', 'testdatabase');
    }

    public function getChatMessagesFormatted() {
        $chat = "";
        if($row = $this->database->queryAndFetchAll("SELECT * FROM chat LIMIT 10")) {
            foreach($row as $r) {
                $chat .= "<b>" . $r["username"] . "</b>: " . $r["message"] . "<br>";
            }
        }
        return $chat;
    }

    public function sendMessage($username, $message) {
        $this->database->prepareAndExecute("INSERT INTO chat(username, message) VALUES(?, ?)", $username, $message);
    }

}
```
Now let's create


Now we can finally create our `chatEOSS`.

`app/controller/chatEOSS.php`:

```php
<?php
use \EOSS\EOSS;

class chatEOSS extends EOSS
{

    /**
     * @var ChatModel|null
     */
    private $chatModel = NULL;

    public function load()
    {
        $this->chatModel = new ChatModel();

        $this->csi->setFile("chat/chat.php");

        $this->csi->params->chat = $this->chatModel->getChatMessagesFormatted();
    }


    public function bind()
    {
        $this->csi->send->onclick = "sendMsg";
        $this->csi->back->onclick = "back";
        $this->csi->intervals["reloadPosts"] = 500;
    }

    public function reloadPosts() {
        $this->csi->chat->html = $this->chatModel->getChatMessagesFormatted();
    }

    public function sendMsg() {
        $this->chatModel->sendMessage(\EOSS\Registry::getInstance()->username, $this->csi->message->value);
        $this->csi->message->value = "";
    }

    public function back() {
        $this->redirect("chatLoginEOSS");
    }



}
```

We've set the interval to call `reloadPosts` every 500 ms. The syntax is `$this->csi->intervals["functionYouWantToCall"] = 500`.

And now we're done...