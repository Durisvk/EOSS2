<html>
<head>
    <title>Linda Debugger</title>
</head>
<body>
<div style="background-color:#800000; padding:10px 20px;">
    <b style="color:#FFF;text-transform:uppercase;"><span style="padding-right:30px; color:#9E0202;">LINDA DEBUGGER:</span><?php if(isset($text)) { echo $text." in file: <b style='text-transform:initial; text-decoration:underline;'>'".$errfile."'</b>";} ?></b><br>
</div>
<div style="background-color:#FFFF99; box-shadow: inset 0 0 10px #999966; padding:20px;">
    <?php foreach ($array as $a) {echo $a."<br>";} ?>
</div>
</body>
</html>