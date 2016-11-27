$( '#txtSource' ).on('keypress',function (event) {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onkeypress&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfqwertyu%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5D&param=105&curValue=asdfqwertyuilibs/request.php',{'eoss':'indexEOSS','id':'txtSource','event':'onkeypress','values':createJSON(),'param': event.keyCode, curValue:$(this).val()+String.fromCharCode(event.keyCode)}, function (data) {
                                console.log(data);
								eval(data);
								txtSourceonkeypress(data);
							});
						});$( '#txtTodo' ).on('keypress',function (event) {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onkeypress&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfqwertyu%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5D&param=105&curValue=asdfqwertyuilibs/request.php',{'eoss':'indexEOSS','id':'txtTodo','event':'onkeypress','values':createJSON(),'param': event.keyCode, curValue:$(this).val()+String.fromCharCode(event.keyCode)}, function (data) {
                                console.log(data);
								eval(data);
								txtTodoonkeypress(data);
							});
						});

