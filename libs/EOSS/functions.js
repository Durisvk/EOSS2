function createJSON() {
    var jsonObj = [];
    $('*').each(function() {
        if($(this).attr("data-ignore") != "true") {
            var id = $(this).attr('id');
            var val = $(this).val();

            if(typeof id == 'undefined' || id == "" || id == "jsRefresh" || id == "EOSS-linda") {
                var binding = $(this).attr('data-binding');
                if(typeof binding == 'undefined' || binding == false) return;

                binding = binding.replace(/(['"])?([a-z0-9A-Z_]+)(['"])?:/g, '"$2": ');
                binding = binding.replace(/\'/g, '"');
                var json = JSON.parse("{" + binding + "}");
                if(typeof json["SourcePath"] != 'undefined') {
                    var item = {};
                    item['binding'] = "{" + binding + "}";
                    if(json["TargetAttribute"] == 'html') {
                        item['attribute'] = $(this).html();
                    } else if(json["TargetAttribute"] == 'value') {
                        item['attribute'] = $(this).val();
                    } else {
                        item['attribute'] = $(this).attr(json["TargetAttribute"]);
                    }

                    jsonObj.push(item);
                }
                return;
            }
            var item = {};
            item ['id'] = id;
            item ['val'] = val;
            if(!$(this).is('input'))
                item['html'] = $(this).html();

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