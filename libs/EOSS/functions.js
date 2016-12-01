function createJSON() {
    jsonObj = [];
    $('input').each(function() {
        if($(this).attr("data-ignore") != "true") {
            var id = $(this).attr('id');
            var val = $(this).val();

            item = {};
            item ['id'] = id;
            item ['val'] = val;

            jsonObj.push(item);
        }
    });
    return (JSON.stringify(jsonObj));
}

