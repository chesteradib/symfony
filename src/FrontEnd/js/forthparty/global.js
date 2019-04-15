
////////////////////////////////////////////////////////////////////////////
/// Global
////////////////////////////////////////////////////////////////////////////

//
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

        contentType = typeof contentType !== 'undefined' ? contentType : 'application/x-www-form-urlencoded; charset=UTF-8';
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

    var dump = function(obj) {
        var out = '';
        for (var i in obj) {
            out += i + ": " + obj[i] + "\n";
        }
        // or, if you wanted to avoid alerts...

        var pre = document.createElement('pre');
        pre.innerHTML = out;
        document.body.appendChild(pre)
    }



    return {
        ajax_call : ajax_call,
        dump: dump
    };
})();

let promises = [];


let abortPreviousRequests = () => {

    var promise;
    while (promises.length > 0) {
        promise = promises.pop();
        promise.abort();
    }
};
////////////////////////////////////////////////////////////////////////////
/// Dumping function for debug purposes To be deleted in production
////////////////////////////////////////////////////////////////////////////






