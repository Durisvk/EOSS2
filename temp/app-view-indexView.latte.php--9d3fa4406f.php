<?php
// source: /home/lchost/EOSS2/app/view/indexView.latte.php

use Latte\Runtime as LR;

class Template9d3fa4406f extends Latte\Runtime\Template
{

	function main()
	{
		extract($this->params);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo LR\Filters::escapeHtmlText($title) /* line 8 */ ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/flashes.js"></script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">EOSS2</a>
        </div>
        <div class="scrolling-text">
            <marquee>Welcome to EOSS framework. It's UP and ready to serve you as you need. We hope you'll enjoy it. More info about the framework itself could be found <a href="https://github.com/Durisvk/EOSS2">here</a>.</marquee>
        </div>
    </div><!-- /.container-fluid -->
</nav>

<div id="flashes" data-ignore>

</div>

<div class="main-panel panel panel-default">
    <div class="panel-body">
        We're glad to see you here. Every bug you should report on the <a href="https://github.com/Durisvk/EOSS2">github website</a>. We are looking forward to our collaboration. We are happy that you've chosen the EOSS2. By the way we are looking for a contributors on our <a href="https://github.com/Durisvk/EOSS2">github page</a>. You can write me an email on <a href="mailto:durisvk2@gmail.com">durisvk2@gmail.com</a>
        <div class="example">
            <input type="text" id="txtSource" value="" placeholder="Type here something">
            <div id="lblCopy">

            </div>
        </div>
        Here is the same example with two-way data binding:
        <div class="example">
            <input type="text" data-binding="SourceElement: '.lblCopy', SourceAttribute: 'value', TargetAttribute: 'value'" placeholder="Type here something">
            <input type="text" class="lblCopy" placeholder="Type something here also.">
        </div>
        Did you like the example? Did you realize how easy it is to use this framework?
        Here are some tips before you start to work with the framework.
        <ul>
            <li>Your controllers should be named as this: xyzEOSS</li>
            <li>Your views should contain the least ids as they can.</li>
            <li>Your models should contain the low-level logic and should be instantiated only once (you can use Registry for it)</li>
        </ul>
        <div class="example">
            <div id="lblTodos"><b>TODOS:</b></div>
            <input type="text" id="txtTodo" data-test="asdf" value="" placeholder="Type here something and hit enter.">
        </div>
        <br>
        Here is another binding example:
        <div class="example">
            <input type="text" id="txtRange" data-binding="SourcePath: 'model.range', TargetAttribute: 'value'" class="lblRange">
            <input type="range" data-binding="SourceElement: '.lblRange', SourceAttribute: 'value', TargetAttribute: 'value'" value="50" min="0" max="100">
        </div>
        <div class="example">
            <input id="randomText1" type="text" data-binding="SourcePath: 'property', TargetAttribute: 'value'">
            <input id="randomText2" type="text" data-binding="SourcePath: 'property', TargetAttribute: 'value'">
        </div>
        There is a lot work to be done. The EOSS2 is not finished yet.
        Here is an example of data-groups functionallity:
        <div class="example">
            <div id="lblButtons"></div>
            <input type="button" data-group="buttons" value="1">
            <input type="button" data-group="buttons" value="2">
            <input type="button" data-group="buttons" value="3">
        </div>
        Here is an example with Collection data binding:
        <div class="example">
            <ul id="personsList" data-binding="ItemSourcePath: 'collection', ItemTemplateFilePath: 'itemTemplate.blade.php'">
            </ul>
            <select id="personsSelect" data-binding="ItemSourcePath: 'collection'">
                <option>(*name*) - (*age*)</option>
            </select>
        </div>
        <div id="panel-footer" class="panel-footer" data-ignore="true">
            Thank You. Your EOSS team :).
        </div>
    </div>
</div>
</body>
</html><?php
		return get_defined_vars();
	}

}
