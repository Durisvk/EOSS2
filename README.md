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