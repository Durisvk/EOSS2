

$('body').on('click', '[data-group="buttons"]', function (event) {
var $self = $(event.target);
if($self.is('a')) {
event.preventDefault()
}
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
    if($self.is('a')) return false;
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

$('body').on('click', "[data-event=\"Event: 'onclick', Action: 'deleteThePerson'\"]", function (event) {
var $self = $(event.target);
if($self.is('a')) {
event.preventDefault()
}
var data = {'eoss':'indexEOSS', 'id':'anonymous', 'event':'onclick', 'action': 'deleteThePerson','values':createJSON()};
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
        anonymousonclick(data);
    });
    if($self.is('a')) return false;
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
$( "#randomText1" ).val("random text");$( "#randomText1" ).change();

$( '#randomText1' ).val($( "#randomText2" ).val());
$( "[data-binding=\"SourcePath: 'property', TargetAttribute: 'value'\"]" ).on('click mousedown mouseup focus blur input change', function(e) {
$( '#randomText1' ).val($(this).val());

});$( '#randomText1' ).on('click mousedown mouseup focus blur input change', function(e) {
$( "#randomText2" ).val($(this).val());

});
$( "#randomText2" ).val("random text");$( "#randomText2" ).change();

$( "#personsList" ).html( "<li>Person <b data-key=\"name\">Andrew Perkins</b> is  <span data-key=\"age\">25</span> years old. <a href=\"\" data-id=\"0\" data-event=\"Event: 'onclick', Action: 'deleteThePerson'\">X</a></li><li>Person <b data-key=\"name\">John Doe</b> is  <span data-key=\"age\">43</span> years old. <a href=\"\" data-id=\"1\" data-event=\"Event: 'onclick', Action: 'deleteThePerson'\">X</a></li><li>Person <b data-key=\"name\">Some Person</b> is  <span data-key=\"age\">32</span> years old. <a href=\"\" data-id=\"2\" data-event=\"Event: 'onclick', Action: 'deleteThePerson'\">X</a></li>" ).attr("data-collection", '[{"id":0,"name":"Andrew Perkins","age":25},{"id":1,"name":"John Doe","age":43},{"id":2,"name":"Some Person","age":32}]');


$( "#personsSelect" ).html( "<option>Andrew Perkins - 25</option><option>John Doe - 43</option><option>Some Person - 32</option>" ).attr("data-collection", '[{"id":0,"name":"Andrew Perkins","age":25},{"id":1,"name":"John Doe","age":43},{"id":2,"name":"Some Person","age":32}]');


