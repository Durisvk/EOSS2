$( '#txtSource' ).on('keypress',function (event) {
$.get('http://localhost/EOSS2/libs/request.php',{'eoss':'indexEOSS','id':'txtSource','event':'onkeypress','values':createJSON(),'param': event.keyCode, curValue:$(this).val()+String.fromCharCode(event.keyCode)}, function (data) {
                                console.log(data);
								eval(data);
								txtSourceonkeypress(data);
							});
						});$( '#txtTodo' ).on('keypress',function (event) {
$.get('http://localhost/EOSS2/libs/request.php',{'eoss':'indexEOSS','id':'txtTodo','event':'onkeypress','values':createJSON(),'param': event.keyCode, curValue:$(this).val()+String.fromCharCode(event.keyCode)}, function (data) {
                                console.log(data);
								eval(data);
								txtTodoonkeypress(data);
							});
						});

