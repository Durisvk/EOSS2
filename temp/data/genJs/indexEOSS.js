$( '#txtSource' ).on('click',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtSource','event':'onclick','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtSourceonclick(data);
							});
						});$( '#txtSource' ).on('hover',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtSource','event':'onhover','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtSourceonhover(data);
							});
						});$( '#txtSource' ).on('change',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtSource','event':'onchange','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtSourceonchange(data);
							});
						});$( '#txtSource' ).on('focus',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtSource','event':'onfocus','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtSourceonfocus(data);
							});
						});$( '#txtSource' ).on('focusin',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtSource','event':'onfocusin','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtSourceonfocusin(data);
							});
						});$( '#txtSource' ).on('focusout',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtSource','event':'onfocusout','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtSourceonfocusout(data);
							});
						});$( '#txtSource' ).on('load',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtSource','event':'onload','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtSourceonload(data);
							});
						});$( '#txtSource' ).on('mousedown',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtSource','event':'onmousedown','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtSourceonmousedown(data);
							});
						});$( '#txtSource' ).on('keypress',function (event) {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtSource','event':'onkeypress','values':createJSON(),'param': event.keyCode, curValue:$(this).val()+String.fromCharCode(event.keyCode)}, function (data) {
                                console.log(data);
								eval(data);
								txtSourceonkeypress(data);
							});
						});$( '#lblCopy' ).on('click',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblCopy','event':'onclick','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblCopyonclick(data);
							});
						});$( '#lblCopy' ).on('hover',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblCopy','event':'onhover','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblCopyonhover(data);
							});
						});$( '#lblCopy' ).on('change',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblCopy','event':'onchange','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblCopyonchange(data);
							});
						});$( '#lblCopy' ).on('focus',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblCopy','event':'onfocus','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblCopyonfocus(data);
							});
						});$( '#lblCopy' ).on('focusin',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblCopy','event':'onfocusin','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblCopyonfocusin(data);
							});
						});$( '#lblCopy' ).on('focusout',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblCopy','event':'onfocusout','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblCopyonfocusout(data);
							});
						});$( '#lblCopy' ).on('load',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblCopy','event':'onload','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblCopyonload(data);
							});
						});$( '#lblCopy' ).on('mousedown',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblCopy','event':'onmousedown','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblCopyonmousedown(data);
							});
						});$( '#lblCopy' ).on('keypress',function (event) {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblCopy','event':'onkeypress','values':createJSON(),'param': event.keyCode, curValue:$(this).val()+String.fromCharCode(event.keyCode)}, function (data) {
                                console.log(data);
								eval(data);
								lblCopyonkeypress(data);
							});
						});$( '#lblTodos' ).on('click',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblTodos','event':'onclick','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblTodosonclick(data);
							});
						});$( '#lblTodos' ).on('hover',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblTodos','event':'onhover','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblTodosonhover(data);
							});
						});$( '#lblTodos' ).on('change',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblTodos','event':'onchange','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblTodosonchange(data);
							});
						});$( '#lblTodos' ).on('focus',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblTodos','event':'onfocus','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblTodosonfocus(data);
							});
						});$( '#lblTodos' ).on('focusin',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblTodos','event':'onfocusin','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblTodosonfocusin(data);
							});
						});$( '#lblTodos' ).on('focusout',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblTodos','event':'onfocusout','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblTodosonfocusout(data);
							});
						});$( '#lblTodos' ).on('load',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblTodos','event':'onload','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblTodosonload(data);
							});
						});$( '#lblTodos' ).on('mousedown',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblTodos','event':'onmousedown','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								lblTodosonmousedown(data);
							});
						});$( '#lblTodos' ).on('keypress',function (event) {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'lblTodos','event':'onkeypress','values':createJSON(),'param': event.keyCode, curValue:$(this).val()+String.fromCharCode(event.keyCode)}, function (data) {
                                console.log(data);
								eval(data);
								lblTodosonkeypress(data);
							});
						});$( '#txtTodo' ).on('click',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtTodo','event':'onclick','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtTodoonclick(data);
							});
						});$( '#txtTodo' ).on('hover',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtTodo','event':'onhover','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtTodoonhover(data);
							});
						});$( '#txtTodo' ).on('change',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtTodo','event':'onchange','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtTodoonchange(data);
							});
						});$( '#txtTodo' ).on('focus',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtTodo','event':'onfocus','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtTodoonfocus(data);
							});
						});$( '#txtTodo' ).on('focusin',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtTodo','event':'onfocusin','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtTodoonfocusin(data);
							});
						});$( '#txtTodo' ).on('focusout',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtTodo','event':'onfocusout','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtTodoonfocusout(data);
							});
						});$( '#txtTodo' ).on('load',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtTodo','event':'onload','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtTodoonload(data);
							});
						});$( '#txtTodo' ).on('mousedown',function () {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtTodo','event':'onmousedown','values':createJSON()}, function (data) {
                                console.log(data);
								eval(data);
								txtTodoonmousedown(data);
							});
						});$( '#txtTodo' ).on('keypress',function (event) {
$.get('http://localhost/EOSS2/libs/request.php?eoss=indexEOSS&id=txtSource&event=onfocusout&values=%5B%7B%22id%22%3A%22txtSource%22%2C%22val%22%3A%22asdfgh%22%7D%2C%7B%22id%22%3A%22txtTodo%22%2C%22val%22%3A%22%22%7D%5Dlibs/request.php',{'eoss':'indexEOSS','id':'txtTodo','event':'onkeypress','values':createJSON(),'param': event.keyCode, curValue:$(this).val()+String.fromCharCode(event.keyCode)}, function (data) {
                                console.log(data);
								eval(data);
								txtTodoonkeypress(data);
							});
						});

