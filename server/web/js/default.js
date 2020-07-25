$(function(){
    var windowWidth=$(window).width()<1200?1200:$(window).width();
    var windowHeight=$(window).height()<600?600:$(window).height();

    // 首页
    if($('.container.index').length){
        // 主轮播图尺寸配置
        $('.container.index .swiper-bg .swiper-container').css('width',windowWidth+'px')
        $('.container.index .swiper-bg .swiper-container').css('margin-left',-(windowWidth-1200)/2+'px')
        var swiper = new Swiper('.swiper-container', {
            loop:true,
            autoplay:true,
            speed:2000,
            pagination: {
                el: '.swiper-pagination',
            },
        });

        // 专家模块背景色配置
        $('.container.index .specialist .specialist-bg').css('width',windowWidth+'px')
        $('.container.index .specialist .specialist-bg').css('margin-left',-(windowWidth-1200)/2+'px')
    }
    // 注册
    if($('.container.login').length){
        $('.container.login').css('height',windowHeight-195+'px')
        $('.container.login .bg').css('width',windowWidth+'px')
        $('.container.login .bg').css('left',-(windowWidth-1200)/2+'px')
    }

    // 证书查询
    if($('.container.cert').length){
        $('.container.cert').css('height',windowHeight-195+'px')
        $('.container.cert .bg').css('width',windowWidth+'px')
        $('.container.cert .bg').css('left',-(windowWidth-1200)/2+'px')
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
            $('.pop-dp-bg').removeClass('active')
            // 暂停弹窗播放器视频播放
            PopDPlayer.pause();
        })
    }

    $('.pop-dp-bg').addClass('active');
}