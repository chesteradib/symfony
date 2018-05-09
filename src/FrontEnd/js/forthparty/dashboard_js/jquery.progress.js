
////////////////////////////////////////////////////////////////////////////
/// Progress 
////////////////////////////////////////////////////////////////////////////

var progress= (function(){


    $.fn.cProgressBar = function (percent){

        var progressBarWidth = percent * $(this).width() / 100;
        $(this).find('div').animate({ width: progressBarWidth }, 500);
    };

    var firstProgress = function(target,targetProgress, r1){        
        targetProgress.cProgressBar(r1);
        firstFadeProgress(target);       
    };
    
    var secondProgress = function(targetProgress, r2){        
        targetProgress.cProgressBar(r2);
         
    };
    
    var thirdProgress = function(target,targetProgress){
        targetProgress.cProgressBar(100);
        secondFadeProgress(target);
    };

    var startProgress = function(target,targetProgress){
        firstFadeProgress(target);
        showProgress(targetProgress);
    };
    var endProgress = function(target,targetProgress){
        secondFadeProgress(target);
        hideProgress(targetProgress);
    };
    var showProgress = function(targetProgress){
        targetProgress.show();
    };
    var hideProgress = function(targetProgress){
        targetProgress.hide();
    };

    var firstFadeProgress = function(target){
        target.fadeTo('fast', 0.05);
    };
    
    var secondFadeProgress = function(target){
        target.fadeTo('slow', 1.0);
    };
    return {
        firstProgress: firstProgress,
        secondProgress:secondProgress,
        thirdProgress:thirdProgress,
        firstFadeProgress:firstFadeProgress,
        secondFadeProgress:secondFadeProgress,
        startProgress: startProgress,
        endProgress : endProgress
    };
    
})();
