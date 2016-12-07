# EOSS2

`EOSS` (stands for Event Oriented Server Side) is a free open-source PHP framework. It is not finished yet, but it's ready for use. EOSS could help you get around the basic PHP principles and do stuff that other frameworks can't do. It comes up with an idea of handling events (also intervals in new version) on a server-side. It creates the copy of a CSI (Client Side Interface) in format of HTML or PHP into an objects and make you able to use them as you were on client-side.

Here is a little demonstration of EOSS:
[EOSS Video](https://www.youtube.com/watch?v=G5y7wY2yBp8&feature=youtu.be)

You can visit our [website](http://eoss.wz.sk/) to get more information about EOSS.


You start with a config file, which should look like this:

`app/config.eoss`:

```json
    "home_eoss": "indexEOSS",
    "layout_dir": "view/",
    "models": "model/",
    "refresh": true,
    "showFlashFunction" : "showFlash",
    "enviroment": "debug"
```

`home_eoss` is a starting controller class, which is launched at the begining. It should contain the name of the class not the filename. The filename must be the same as the class name except for extension.
`layout_dir` is a directory path relative to `app/` folder where the views are located.
`models` is the path to the models of your application. They are loaded at the very beginning before everything else.
`refresh` attribute tells the EOSS whether it should keep the session about the current state of your EOSS class alive.
`showFlashFunction` is a name of the javascript function which will take two arguments (message and class) and it should append the flash message to the view dynamically.
`enviroment` for now this property says if AJAX responses should be `console.log`ged.

Now that you have your `config.eoss` ready, we can go ahead and create some stuff.

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
    <div id="hello" data-ignore="true">
    </div>
</body>
</html>
```

Be careful about the elements id attributes. EOSS creates the structure of classes which will be called by these ids. If you want the EOSS to ignore some elements set the `data-ignore="true"` attribute to those elements as we did for `#hello` element It must not contain `-`. Now let's make our Todo list actually work by creating the `indexEOSS` inside our `app/controller/` directory.


`app/controller/indexEOSS.php`:

```php
<?php

use \EOSS\EOSS;

class indexEOSS extends EOSS
{

    public $counter = 1;

    public function load()
    {
        $this->csi->setFile("layout.php");
    }

    public function bind()
    {
        $this->csi->addTodo->onclick[] = "addTodoFunction";
    }

    public function addTodoFunction($sender) {
        $this->csi->todos->html .= "<div>" . $this->counter . ": " . $this->csi->todo->value . "</div>";
        $this->csi->todo->value = "";
        $this->counter++;
    }


}
```

In load method we set the view file we've created earlier. We can pass parameters into the view by setting `$this->csi->params->anyKindOfParameter` to some value. Bind method is called after the EOSS generates the CSI structure of classes. Now we can access all of our view elements from `$this->csi->idOfAnElement`. In this phase we should bind all of the events and set all of the intervals we need. Events are passed as a string containing the name of the function. Then we need to implement this function. We can use public members and do with them whatever we want (e.g. increment them) and they will be stored inside Sessions. To the function of some event the `$sender` parameter is passed which contains the information about the element that the event was fired on.

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
        $this->csi->txtSource->onkeypress[] = "rewrite";
    }

    public function rewrite($sender, $keyCode) {
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
  "onkeypress": "keypress:keyCode",
  "onenterpressed": "keypress-event.keyCode==13"
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
        $this->csi->next->onclick[] = "next";
    }


    public function next($sender) {
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
        $this->csi->send->onclick[] = "sendMsg";
        $this->csi->back->onclick[] = "back";
        $this->csi->intervals["reloadPosts"] = 500;
    }

    public function reloadPosts() {
        $this->csi->chat->html = $this->chatModel->getChatMessagesFormatted();
    }

    public function sendMsg($sender) {
        $this->chatModel->sendMessage(\EOSS\Registry::getInstance()->username, $this->csi->message->value);
        $this->csi->message->value = "";
    }

    public function back($sender) {
        $this->redirect("chatLoginEOSS");
    }



}
```

We've set the interval to call `reloadPosts` every 500 ms. The syntax is `$this->csi->intervals["functionYouWantToCall"] = 500`.

And now we're done...

# Groups

Now that we understand the Intervals Database and Registry we can move on some easier stuff. Let's learn about Groups.

Let's create our view with three buttons added to one group using `data-group` attribute. We want to show the clicked button's value inside `div`.

`app/view/indexView.php`:

```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>

	<div id="lblView"></div>
	<input type="button" data-group="buttons" value="1" />
	<input type="button" data-group="buttons" value="2" />
	<input type="button" data-group="buttons" value="3" />

</body>
</html>
```

Now we can create our controller.

`app/controller/indexEOSS.php`:

```php
<?php

use EOSS\EOSS;

class indexEOSS extends EOSS
{

    public function load()
    {
        $this->csi->setFile("indexView.php");
    }

    public function bind()
    {

        $this->csi->buttons->onclick[] = "showNumber";
    }


    public function showNumber($sender) {
        $this->csi->lblButtons->html = $sender->value;
        $sender->value += 1;
    }

}
```

Now we can use the group we've defined earlier to bind the event to the all elements in that group.
You can but don't have to specify the id attribute to the elements of the group.

And we are done...

#Forms

Forms are used to group the data form user input together. They are also needed for special operations such as file upload.

In EOSS the forms are very similar to the ones in [Nette Framework](https://nette.org/). Let's make some registration form.

We'll start with `indexEOSS` class.

`app/controller/indexEOSS.php`:

```php
<?php

use EOSS\EOSS;
use Forms\Form;
use Debug\Linda;

class indexEOSS extends EOSS {
	
	public function load() {
		$this->csi->params->ourForm = $this->createForm();
		$this->csi->setFile("indexView.php");
	}

	public function bind() {}

	private function createForm() {
		$form = new Form("myForm", $this);
		
		// Or we don't have to pass $this
		// and we can do $eoss->registerForm($form)
		// later.

		$form->addText("username", "Username: ")->setRequired();
		$form->addEmail("email", "Email: ");
		$form->addPassword("password", "Password: ")->setRequired();
		$form->addHidden("hidden", "secret") // hidden is the name and secret is the value
		$form->addFile("avatar", FALSE, "Avatar: ");
		$form->addSubmit("submit", "Submit our Form")->addAttribute("class", "btn btn-submit");
		$form->onsubmit[] = "ourFormSubmitted";
	}

	public function ourFormSubmitted(SubmittedForm $form) {
		Linda::dump("Hello " . $form->username);
		// Store data into database for example...
	}

}


```

Now let's render our form in `indexView.php`:

`app/view/indexView.php`:

```php

	<div class="form-wrapper">
		<?= $ourForm; ?>
	</div>

```

or we can render form as table:

`app/view/indexView.php`:

```php

	<div class="form-wrapper">
		<?= $ourForm->asTable(); ?>
	</div>

```

And those are the forms in EOSS2. We can also fill the default values with `$form->setDefaults()` which takes an array of key => value pair with field names => default values for the form.

# Flashes

If you want to give the user some information about successful login or registration, you should check the flash message functionallity of EOSS.

What you need is put the flash container into the view for example:

```html
<div id="flashes" data-ignore>

</div>
```

Maybe you need to do some CSS stuff to make it look good for example:

```css
#flashes {
    position: fixed;
    top: 10px;
    width: 800px;
    left: 50%;
    margin-left: -400px;
}
```

Now what you need to do is to program the function with name added to `config.eoss` to the parameter `showFlashFunction`. Let's create the one in `assets/js/flashes.js`.

```javascript

function showFlash(message, cls) {
    var $flashes = $("#flashes");
    if($flashes.length > 0) {
        var $flash = $("<div style='display:none' class='alert alert-" + cls + "'>" + message + "</div>");
        $flashes.append($flash);
        $flash.fadeIn(200);
        setTimeout(function() {
            $flash.fadeOut(2000, function() {
               $(this).remove();
            });
        }, 3000);
    }
}

```

Now we need to register that into our config.eoss which will looks like this:


```json
    "home_eoss": "indexEOSS",
    "layout_dir": "view/",
    "models": "model/",
    "refresh": true,
    "showFlashFunction" : "showFlash",
    "enviroment": "debug"
```

Now we can use the functionallity we've programmed to display the flash message. Anywhere in our application we can call `$eoss->flashMessage($message, $class)`. Of course if we are inside the EOSS we can simply use `$this->flashMessage($message, $class)`. Let's do this:

`app/controller/indexEOSS.php`:

```php
<?php

use EOSS\EOSS;

class indexEOSS extends EOSS {

	public function load() {
        $this->csi->params->title = "Welcome To EOSS | EOSS2";
        $this->csi->setFile("indexView.php");
	}

    public function bind() {
        $this->csi->buttons->onclick[] = "showNumber";
    }

    public function showNumber($sender) {
        $this->flashMessage("You've successfully clicked on " . $sender->value . " button.", "success");
    }
}
```


And this is it. So easy :).

# Templating Engine

**Twig**

To use templating engine Twig you just need to name your view as: xyz.twig.php. That's all you need to do to enable Twig as your templating engine. Note that xyz can be anything you want. If you want to clear your cache stored templates just remove everything from the `temp` directory.