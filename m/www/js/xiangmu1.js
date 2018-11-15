$(document).ready(function () {
	
	   //返回顶部
    $('.toTop').hide();

    $('.toTop').click(function(e){
        e.preventDefault();
        $('body,html').animate({scrollTop:0},500);
        return false;
    });
	
    //滚动到底部加载更多
    $(window).bind('scroll', function () {
        var $window = $(window);
        var $document = $(document);

        var winHeight = $window.height();
        var docHeight = $document.height();
        var scrollTop = $window.scrollTop();
        
        if (scrollTop>100){
        	$('.toTop').css("display","inline-block"); ;
        }else{
        	$('.toTop').fadeOut(200);
        }

        if ( winHeight+scrollTop+50 >= docHeight){
            loadMore();
        }


    });

    var page=2;
    var $panelLoading = $('div.loading');
    var isLoadingMore = false;
    var finishedLoadingMore = function(){
        isLoadingMore = false;
    };
    
    $panelLoading.click(function(e){
    	e.preventDefault();
    	loadMore();
    });
    
    var loadMore  = function(){

        if(isLoadingMore || page < 0){
            return;
        }
        
        var $url = $.url();
        var keywords = $url.param('keywords');
        var cates = $url.param('cates');
        var locs  = $url.param('residences');
        var stages = $url.param('fundStages');
        
        var url = LOCAL_URL+'/fundings?snippet=true&page='+page;
        if(keywords && keywords.length > 0){
            url = url + "&keywords="+ encodeURIComponent(keywords);
        }
        if(cates && cates.length > 0){
            url = url + "&cates="+ encodeURIComponent(cates);
        }
        if(locs && locs.length > 0){
            url = url + "&residences="+ encodeURIComponent(locs);
        }
        if(stages && stages.length > 0){
            url = url + "&fundStages="+ encodeURIComponent(stages);
        }
        
        $panelLoading.fadeIn();
        isLoadingMore = true;
        //加载更多中。。。;
        $.ajax(url,{
            type:'GET',
            success:function(res){
                if(!res || res.length == 0){
                    page=-1;
                    finishedLoadingMore();
                    $panelLoading.fadeOut();
                    return;
                }
                var $moreContent = $(res);
                $(".item-card").append($moreContent);
                page++;
                finishedLoadingMore();
            },
            error:function(){
                finishedLoadingMore();
            }

        });
    };
    
    $(".switch-filter").click(function(e){
    	e.preventDefault();
    	$(".filter-wrap").fadeIn();
    });
    
    $(".filter-wrap .cancel").click(function(e){
    	e.preventDefault();
    	$(".filter-wrap").fadeOut();
    });
    
    $(".filter-group ul li").click(function(e){
    	e.preventDefault();
    	$(this).siblings().removeClass("current");
    	$(this).addClass("current");
    });
    
    $(".filter-wrap .reset").click(function(e){
    	e.preventDefault();
    	$(".filter-group ul li").removeClass("current");
    	$(".filter-cates li:first, .filter-locs li:first, .filter-stages li:first").addClass("current");
    });
    
    $(".filter-wrap .confirm").click(function(e){
    	e.preventDefault();
    	
    	
    	var url = '/fundings?page=1';
    	
    	var $url = $.url();
        var keywords = $url.param('keywords');
        if(keywords && keywords.length > 0){
            url = url + "&keywords="+ encodeURIComponent(keywords);
        }
        
        var cates = $(".filter-cates li.current").attr("data-value");
        if(cates && cates.length > 0){
            url = url + "&cates="+ encodeURIComponent(cates);
        }
        
        var locs = $(".filter-locs li.current").attr("data-value");
        if(locs && locs.length > 0){
            url = url + "&residences="+ encodeURIComponent(locs);
        }
        
        var stages = $(".filter-stages li.current").attr("data-value");
        if(stages && stages.length > 0){
            url = url + "&fundStages="+ encodeURIComponent(stages);
        }
        
        location.href=url;
    });
    
    $("li.sort-name a").click(function(e){
    	e.preventDefault();
    	var url = $(this).attr("href");
    	
    	var $url = $.url();
        var keywords = $url.param('keywords');
        var cates = $url.param('cates');
        var locs  = $url.param('residences');
        var stages = $url.param('fundStages');
        
        if(keywords && keywords.length > 0){
            url = url + "&keywords="+ encodeURIComponent(keywords);
        }
        
        if(cates && cates.length > 0){
            url = url + "&cates="+ encodeURIComponent(cates);
        }
        
        if(locs && locs.length > 0){
            url = url + "&residences="+ encodeURIComponent(locs);
        }
        
        if(stages && stages.length > 0){
            url = url + "&fundStages="+ encodeURIComponent(stages);
        }
        
        location.href=url;
    })
    
 
    
});