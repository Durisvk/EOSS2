

$( '[data-group="buttons"]' ).on('click',function (event) {
var $self = $(this);
var data = {'eoss':'indexEOSS', 'id':'buttons', 'event':'onclick','values':createJSON()};
if(typeof $(this).attr("id") == "undefined" || $(this).attr("id") == "") {
$(this).attr("id", randomString(10));
data.element_id = $(this).attr("id"); 
data.anonymous = getAllAttributes($(this));

} else {
 data.element_id = $(this).attr('id'); 
}
$.post('http://localhost/EOSS2/libs/request.php', data, function (data) {
        console.log(data);
        eval(data);
        buttonsonclick(data);
    });
});
$( '#txtSource' ).on('keypress',function (event) {
$.post('http://localhost/EOSS2/libs/request.php',{'eoss':'indexEOSS','id':'txtSource','event':'onkeypress','values':createJSON(),'param': event.keyCode, curValue:$(this).val()+String.fromCharCode(event.keyCode)}, function (data) {
        console.log(data);
        eval(data);
        txtSourceonkeypress(data);
    });
});
$( '#txtTodo' ).on('keypress',function (event) {
if(event.keyCode==13)
	$.post('http://localhost/EOSS2/libs/request.php',{'eoss':'indexEOSS','id':'txtTodo','event':'onenterpressed','values':createJSON()}, function (data) {
        console.log(data);
        eval(data);
        txtTodoonenterpressed(data);
    });
});



$( '.lblCopy' ).val($( "[data-binding = \"SourceElement: '.lblCopy', SourceAttribute: 'value', TargetAttribute: 'value'\"]" ).val());
$( "[data-binding=\"SourceElement: '.lblCopy', SourceAttribute: 'value', TargetAttribute: 'value'\"]" ).on('click mousedown mouseup focus blur input change', function(e) {
$( '.lblCopy' ).val($(this).val());

});$( '.lblCopy' ).on('click mousedown mouseup focus blur input change', function(e) {
$( "[data-binding = \"SourceElement: '.lblCopy', SourceAttribute: 'value', TargetAttribute: 'value'\"]" ).val($(this).val());

});


$( '.lblRange' ).val($( "[data-binding = \"SourceElement: '.lblRange', SourceAttribute: 'value', TargetAttribute: 'value'\"]" ).val());
$( "[data-binding=\"SourceElement: '.lblRange', SourceAttribute: 'value', TargetAttribute: 'value'\"]" ).on('click mousedown mouseup focus blur input change', function(e) {
$( '.lblRange' ).val($(this).val());

});$( '.lblRange' ).on('click mousedown mouseup focus blur input change', function(e) {
$( "[data-binding = \"SourceElement: '.lblRange', SourceAttribute: 'value', TargetAttribute: 'value'\"]" ).val($(this).val());

});
