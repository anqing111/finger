initLayout()
$(function(){
    if($('header .nav-img').length){
        $('header .nav-img').click(function(){
            if($('header .nav-list').hasClass('active'))
            {
                $('header .nav-list').removeClass('active')
            }else{
                $('header .nav-list').addClass('active')
            }
        })
        $('header .nav-list a').click(function(){
            $('header .nav-list').removeClass('active')
        })
    }

    // 首页
    if($('.container.index').length){
        var swiper = new Swiper('.swiper-container', {
            loop:true,
            autoplay:true,
            speed:2000,
            pagination: {
                el: '.swiper-pagination',
            },
        });
    }
    
})

function videoPlay(url)
{
    // 弹窗播放器
    var PopDPlayer='';
    // 弹窗视频播放器
    if($('.pop-dp-bg').length){
        PopDPlayer = new DPlayer({
            container: document.getElementById('PopDPlayer'),
            video: {
                url: url
            }
        });
        $('.pop-dp-bg .close').click(function(){
            $('.pop-dp-bg').removeClass('active');
            $('.PopDPlayer').css('display','none');
            // 暂停弹窗播放器视频播放
            PopDPlayer.pause();
        });
    }

    $('.pop-dp-bg').addClass('active');
    $('.PopDPlayer').css('display','block');
}

function initLayout(){
    var windowWidth=window.innerWidth;
    var windowHeight=window.innerHeight;
    if(windowWidth>=750){
        windowWidth=750;
    }
    var html=document.getElementsByTagName("html")[0];
    html.style.fontSize=windowWidth/46.875+"px";
    var body=document.getElementsByTagName("body")[0];
    html.style.width=windowWidth+"px";
    html.style.minHeight=windowHeight+"px";
    window.onresize=function(){
        var windowWidth=window.innerWidth;
        if(windowWidth>=750){
            windowWidth=750;
        }
        var html=document.getElementsByTagName("html")[0];
        html.style.fontSize=windowWidth/46.875+"px";
        var body=document.getElementsByTagName("body")[0];
        html.style.minHeight=windowHeight+"px";
    }
}
