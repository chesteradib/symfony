
////////////////////////////////////////////////////////////////////////////
/// Global
////////////////////////////////////////////////////////////////////////////

var Utils= (function(){

    var $ = jQuery;

    var ajax_call = function(type,
                             url,
                             data,
                             cache,
                             beforeSend,
                             success,
                             complete,
                             contentType,
                             processData){


        contentType = typeof contentType !== 'undefined' ? a : 'application/x-www-form-urlencoded; charset=UTF-8';
        processData = typeof processData !== 'undefined' ? processData : true;
        data = typeof data !== 'undefined' ? data : {};

        $.ajax({
            type: type,
            url: url,
            data:data,
            cache: cache,
            beforeSend:beforeSend,
            success: success,
            complete:complete,
            contentType: contentType,
            processData: processData
        });
    };

    return {
        ajax_call : ajax_call
    };
})();