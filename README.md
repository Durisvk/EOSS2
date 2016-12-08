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

# Data Binding

There are two ways of data binding inside EOSS. One is the **Element to Element** data binding. The second one is the **Element to Property** binding. To make it clear, the element you are specifying `data-binding` attribute to is the **Target**. The **Source** is what you specify inside `data-binding` attribute and it's either the other element or path to a property.

**Element to Element Binding**:

What you need to specify is the **SourceElement**, **SourceAttribute** and **TargetAttribute**. You can specify the **Mode** either `one-way` or `two-way`. Depends on if you need one-way binding from Source to the Target or both ways.
Let's look at the example.
We want to create a range input and bind it to textbox so if we change range the textbox will get updated and if we change the textbox the range will get updated. We want to bind the attribute `value` of our range and attribute `value` of our textbox.

```html
<div class="example">
            <input type="text" class="lblRange">
            <input type="range" data-binding="SourceElement: '.lblRange', SourceAttribute: 'value', TargetAttribute: 'value'" value="50" min="0" max="100" />
        </div>
```

This is it. We can explicitly set the **Mode** to `two-way` to be sure we get our result like that:

```html
<input type="range" data-binding="SourceElement: '.lblRange', SourceAttribute: 'value', TargetAttribute: 'value', Mode: 'two-way'" value="50" min="0" max="100" />
```

And we are done now. This is how the **Element to Element** binding works.

**Element to Property Binding**:

This is a little more advanced way of binding. What you get as the final result is Element's attribute bound to the property (of your EOSS, Model, or anything accessible from your EOSS through public property or getter). So if the Element's attribute changes the Property gets automatically updated to the value of that changed attribute. If it's two-way binding and the Property changes the Element's attribute gets updated to the value of that Property.
You need to specify only two parameters: **SourcePath** and **TargetAttribute**. To make the things clear the **SourcePath** is the path to the property delimited with dots (`.`). For example we have model called model in our indexEOSS so and we want to bind to the model's property `foo`. So we specify the **SourcePath** as follows: `model.foo`. It's not that difficult to understand. Just let's move to the example.
Let's bind our range to the property in our indexEOSS. Let's create it.

```php
<?php
use EOSS\EOSS;

class indexEOSS extends EOSS
{

    public $range;

    public function load() {
    	$this->setFile("index.php");
    }

    public function bind() {}
}

```

Now we can bind to that property.

```html
<input type="range" data-binding="SourcePath: 'range', TargetAttribute: 'value'"/>
```

We have successfully bound the range value to the range property in our indexEOSS.
What if we want to keep our range private. Then we need to create the getter and the setter for that property.

```php
<?php

use EOSS\EOSS;

class indexEOSS extends EOSS
{

    private $range = 50;

    public function load() {
    	$this->setFile("index.php");
    }

    public function bind() {}

    public function getRange() {
    	return $this->range;
    }

    public function setRange($range) {
    	$this->range = $range;
    }
}
```

Notice how we can set the initial value to the property. It will get reflected on the range input element's initial value.

If we want to bind a property of our model which is contained by the indexEOSS we can do that.

Here's the first way we can do it:

```php
<?php

use EOSS\EOSS;

class indexEOSS extends EOSS
{

    public $model;

    public function load() {
    	$this->model = new ExampleModel();
    	$this->setFile("index.php");
    }

    public function bind() {}
}
```


Or we can do it this way to keep our model private:

```php
<?php

use EOSS\EOSS;

class indexEOSS extends EOSS
{

    private $model;

    public function load() {
    	$this->model = new ExampleModel();
    	$this->setFile("index.php");
    }

    public function bind() {}

    public function getModel() {
    	return $this->model;
    }
}
```

And our `ExampleModel` will look like this:

```php
<?php

class ExampleModel
{

    private $range;

    public function getRange()
    {
        return $this->range;
    }

    public function setRange($range)
    {
        $this->range = $range;
    }

}
```

We can now bind to our model instead.

```html
<input type="text" data-binding="SourcePath: 'model.range', TargetAttribute: 'value'">
```

And this is it. The **Element to Property** data binding.

**Troubleshooting**:

Working with the property binding you will get the understoodable errors. Either the specified **SourcePath** is not correct (the property for example doesn't exist) or any of the parts of the specified **SourcePath** aren't accessible (are for example private and no getter/setter are defined).

Notice that the getter and the setter to the property must be in the format: `getPropertyName()` / `setPropertyName($value)`. Getter should not take an argument and should return any value, the setter should take argument. The getters and the setters need to be `camelCase`.


# Dependency Injection and Services

If you need to pass an instance (e.g. of a model) to the EOSS class by constructor, you can simply do that with Dependency Injection and Services.

First you need to register a service. Inside app folder create file `app/services.eoss` which can look something like this:

```json
services: [
    "ExampleModel"
]
```

We suppose you have already created an ExampleModel. Now what you can do in your xyzEOSS class is this:


```php
<?php
use EOSS\EOSS;

class indexEOSS extends EOSS
{

    public $model;

    public function __construct(ExampleModel $model) {
    	parent::__construct();
        $this->model = $model;
    }

    public function load() {
    	...
    }

    public function bind() {
    	...
    }
}
```

What now happens is that your ExampleModel will be automatically passed into the constructor and you are well ready to use it.

We can do the same thing using **inject\*** method. The method must be public and must start with keyword **inject**.


```php
<?php
use EOSS\EOSS;

class indexEOSS extends EOSS
{

    public $model;

    public function injectModel(ExampleModel $model) {
    	$this->model = $model;
    }

    public function load() {
    	...
    }

    public function bind() {
    	...
    }
}
```

Notice that the class name before argument is required (e.g. `ExampleModel $param`). Otherwise you get an error.


The last way to inject dependencies and services is not recommended. You can use public property with annotation which will look like this:

```php
use EOSS\EOSS;

class indexEOSS extends EOSS
{
    /**
     * @var ExampleModel @inject
     */
    public $model;

    public function load() { ... }
    public function bind() { ... }
}
```

This is the most unsecure way to gain dependencies. The `@inject` anotation is required.

Notice that the instance of the object passed into indexEOSS is always the one and the same. No 2 instances of a same class will be created this way.

PS: I am using [Pimple](http://pimple.sensiolabs.org/) to create this magic.