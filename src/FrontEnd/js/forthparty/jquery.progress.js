
////////////////////////////////////////////////////////////////////////////
/// Progress 
////////////////////////////////////////////////////////////////////////////

var progress = (function(){

    var startProgress = function(target,targetProgress){
        target.empty();
        showProgress(targetProgress);
    };
    var endProgress = function(target,targetProgress){
        hideProgress(targetProgress);
    };
    var showProgress = function(targetProgress){
        targetProgress.show();
    };
    var hideProgress = function(targetProgress){
        targetProgress.hide();
    };


    return {
        startProgress: startProgress,
        endProgress : endProgress
    };

})();


var startPogressLeft = function() {
    var $target= $('#left');
    var $targetProgress = $("#progress_left");
    progress.startProgress($target,$targetProgress);
};

var endPogressLeft = function() {
    var $target= $('#left');
    var $targetProgress = $("#progress_left");
    progress.endProgress($target,$targetProgress);
};

var startPogressCenter = function() {
    var $target= $('#center');
    var $targetProgress = $("#progress_center");
    progress.startProgress($target,$targetProgress);
};

var endPogressCenter = function() {
    var $target= $('#center');
    var $targetProgress = $("#progress_center");
    progress.endProgress($target,$targetProgress);
};


var startPogressRight = function() {
    var $target= $('#right');
    var $targetProgress = $("#progress_right");
    progress.startProgress($target,$targetProgress);
};

var endPogressRight = function() {
    var $target= $('#right');
    var $targetProgress = $("#progress_right");
    progress.endProgress($target,$targetProgress);
};
