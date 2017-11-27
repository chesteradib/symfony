function search_listener()
{
        $("#search-form").submit(function(){ 
            
        var formData = {};
        
        $("#search-form").find("input[name]").each(function (index, node) {
            formData[node.name] = node.value;
        });
        var numberOfItemsPerCenter= $('#content').data('number-of-items-per-center');
        formData['articles_per_page'] = numberOfItemsPerCenter;
        
        var url= $(this).attr('action');
        search(formData,url);      
        return false;
});
      
}

function search(data,url){
    
    var $target= $('#center');
    var $targetProgress = $("#center_progress");
    
    
    $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            beforeSend: function(){
                progress.firstProgress($target,$targetProgress, 35);   
            }, 
            success: function(data){
                $target.empty().html(data);
            
                show_article_listener();
                product_hover_listener();
                progress.secondProgress($targetProgress,85);

                final_next_previous_page_listenner('center');
                       
            },
            complete:function(){
                progress.thirdProgress($target,$targetProgress);   
            }      
        });    
        return false;
}
