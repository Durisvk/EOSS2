function createJSON() {
    jsonObj = [];
    $('input').each(function() {
        if($(this).attr("data-ignore") != "true") {
            var id = $(this).attr('id');
            var val = $(this).val();

            if(typeof id == 'undefined' || id == "") return;
            item = {};
            item ['id'] = id;
            item ['val'] = val;

            jsonObj.push(item);
        }
    });
    return (JSON.stringify(jsonObj));
}

function randomString(len, charSet) {
    charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var randomString = '';
    for (var i = 0; i < len; i++) {
        var randomPoz = Math.floor(Math.random() * charSet.length);
        randomString += charSet.substring(randomPoz,randomPoz+1);
    }
    return randomString;
}

function getAllAttributes($el) {
    attributes = {};
    $el.each(function() {
        $.each(this.attributes, function() {
            // this.attributes is not a plain object, but an array
            // of attribute nodes, which contain both the name and value
            if(this.specified) {
                attributes[this.name] = this.value;
            }
        });
    });
    return attributes;
}