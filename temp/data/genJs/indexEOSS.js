

$( '#b7, #b8, #b9, #b4, #b5, #b6, #b1, #b2, #b3, #b0' ).on('click',function () {
var $self = $(this);
$.get('http://localhost/EOSS2/libs/request.php',{'eoss':'indexEOSS','id':'b', 'element_id':$(this).attr('id'), 'event':'onclick','values':createJSON()}, function (data) {
        console.log(data);
        eval(data);
        bonclick(data);
    });
});

$( '#plus, #minus, #multiple, #divide, #negate' ).on('click',function () {
var $self = $(this);
$.get('http://localhost/EOSS2/libs/request.php',{'eoss':'indexEOSS','id':'o', 'element_id':$(this).attr('id'), 'event':'onclick','values':createJSON()}, function (data) {
        console.log(data);
        eval(data);
        oonclick(data);
    });
});
$( '#bc' ).on('click',function () {
$.get('http://localhost/EOSS2/libs/request.php',{'eoss':'indexEOSS','id':'bc','event':'onclick','values':createJSON()}, function (data) {
        console.log(data);
        eval(data);
        bconclick(data);
    });
});
$( '#bce' ).on('click',function () {
$.get('http://localhost/EOSS2/libs/request.php',{'eoss':'indexEOSS','id':'bce','event':'onclick','values':createJSON()}, function (data) {
        console.log(data);
        eval(data);
        bceonclick(data);
    });
});
$( '#result' ).on('click',function () {
$.get('http://localhost/EOSS2/libs/request.php',{'eoss':'indexEOSS','id':'result','event':'onclick','values':createJSON()}, function (data) {
        console.log(data);
        eval(data);
        resultonclick(data);
    });
});

