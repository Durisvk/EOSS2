
$( '#txtSource' ).on('keypress',function (event) {
$.get('http://localhost/EOSS2/libs/request.php',{'eoss':'indexEOSS','id':'txtSource','event':'onkeypress','values':createJSON(),'param': event.keyCode, curValue:$(this).val()+String.fromCharCode(event.keyCode)}, function (data) {
        console.log(data);
        eval(data);
        txtSourceonkeypress(data);
    });
});
$( '#txtTodo' ).on('keypress',function (event) {
if(event.keyCode==13)
	$.get('http://localhost/EOSS2/libs/request.php',{'eoss':'indexEOSS','id':'txtTodo','event':'onenterpressed','values':createJSON()}, function (data) {
        console.log(data);
        eval(data);
        txtTodoonenterpressed(data);
    });
});

$( '#btn1, #btn2, #btn3' ).on('click',function (event) {
var $self = $(this);
$.get('http://localhost/EOSS2/libs/request.php',{'eoss':'indexEOSS','id':'buttons', 'element_id':$(this).attr('id'), 'event':'onclick','values':createJSON()}, function (data) {
        console.log(data);
        eval(data);
        buttonsonclick(data);
    });
});

