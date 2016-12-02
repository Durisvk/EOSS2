
function showFlash(message, cls) {
    var $flashes = $("#flashes");
    if($flashes.length > 0) {
        var $flash = $("<div style='display:none' class='alert alert-" + cls + "'>" + message + "</div>");
        $flashes.append($flash);
        $flash.fadeIn(200);
        setTimeout(function() {
            $flash.fadeOut(2000, function() {
               $(this).remove();
            });
        }, 3000);
    }
}