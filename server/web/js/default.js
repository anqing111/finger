$(function(){
    var windowWidth=$(window).width()<1200?1200:$(window).width()
    var windowHeight=$(window).height()<600?600:$(window).height()
    // 弹窗播放器
    var PopDPlayer=''
    // 首页主播放器
    var MainDPlayer=''
    // 弹窗视频播放器
    if($('.pop-dp-bg').length){
        PopDPlayer = new DPlayer({
            container: document.getElementById('PopDPlayer'),
            video: {
                url: '../mp4/video3.mp4',
            }
        });
        $('.pop-dp-bg .close').click(function(){
            $('.pop-dp-bg').removeClass('active')
            // 暂停弹窗播放器视频播放
            PopDPlayer.pause()
        })
    }
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
        // 主播放器初始化
        // MainDPlayer = new DPlayer({
        //     container: document.getElementById('MainDPlayer'),
        //     video: {
        //         url: '../mp4/video1.mp4',
        //     },
        //     autoplay:true
        // });
        // // -----------------临时效果
        // var _hisMainDP='video1'
        // $('.container.index .player-box .list .item').click(function(){
        //     $('.container.index .player-box .list .item').removeClass('active')
        //     $(this).addClass('active')
        //     if(_hisMainDP=='video1'){
        //         MainDPlayer.switchVideo({
        //             url: '../mp4/video2.mp4',
        //         })
        //         _hisMainDP='video2'
        //     }else{
        //         MainDPlayer.switchVideo({
        //             url: '../mp4/video1.mp4',
        //         })
        //         _hisMainDP='video1'
        //     }
        // })
        // -----------------临时效果
        var _hisPopDP='video3'
        // 个人秀触发弹窗
        $('.container.index .person-show .group .item').click(function(){
            $('.pop-dp-bg').addClass('active')
            // -----------------临时效果
            if(_hisPopDP=='video3'){
                PopDPlayer.switchVideo({
                    url: '../mp4/video4.mp4',
                })
                _hisPopDP='video4'
            }else{
                PopDPlayer.switchVideo({
                    url: '../mp4/video3.mp4',
                })
                _hisPopDP='video3'
            }
            console.log(_hisPopDP)
            // -----------------临时效果
            // 暂停主播放器视频播放
            MainDPlayer.pause()
            // 弹窗播放器播放
            if(PopDPlayer!=''){
                PopDPlayer.play()
            }
        })
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
})