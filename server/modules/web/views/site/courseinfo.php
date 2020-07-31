<?php
use app\assets\WebAsset;
use yii\helpers\Url;
WebAsset::register($this);
$this->beginContent('@views/layouts/web.php');
?>
<style>
    body{
        overflow-x: hidden;
    }
    header{
        padding: 0;
        background: url(<?=Url::to('images/banner.png')?>) no-repeat center;
        background-size: cover;
        height: 670px;
        overflow: hidden;
        color:rgba(208,208,208,1);
    }
    header .menu a {
        color:rgba(208,208,208,1);
    }
    header .searcher{
        background: rgba(255,255,255,255);
    }
    header .options,header .options a{
        color:rgba(255,255,255,255);
    }
</style>

<header>
    <div class="container flex-box">
        <div class="filler flex-box">
            <img src="<?=Url::to('images/logo.png')?>" alt="" class="logo" style="background: rgba(0,0,0,0);">
            <div class="menu flex-box">
                <a href="index.php?r=web/site/index" class="item">首页</a>
                <a href="index.php?r=web/site/courseindex" class="item active">课程</a>
                <a href="#" class="item">继续教育</a>
            </div>
            <a href="index.php?r=web/site/certificateindex"><div class="searcher flex-box">
                    <img src="<?=Url::to('images/searcher-icon.png')?>" alt="" class="icon">
                    <input type="text" placeholder="证书查询" class="filler">
                </div></a>
        </div>
        <div class="options">
            <a href="#"><?=Yii::$app->session->get('sNick')?></a>
            <span>|</span>
            <a href="index.php?r=web/admin/adminindex">用户中心</a>
            <span>|</span>
            <a href="index.php?r=web/site/logout" class="logout" onclick="if(!confirm('是否确认退出')){ return false}">退出</a>
        </div>

    </div>
    <div class="couserinfo-info">
        <img src="<?=Yii::$app->params['imagePath'].$course['sCourseImg']?>" alt="">
        <div class="detail filler">
            <div class="couserinfo-title"><?=$course['sCourseName']?></div>
            <div class="couserinfo-time">
                <p class="couserinfo-time1"><?=$course['classhour']?></p>
                <p class="couserinfo-time2">直播课时</p>
            </div>
            <div class="couserinfo-jianjie">简介：</div>
            <div class="couserinfo-content"><?=mb_substr($course['sCourseInfo'],0,150)?>...</div>
            <div class="couserinfo-sign"><a href="#">我要报名</a></div>
        </div>
    </div>
</header>

<div class="container couserinfo">
    <div class="specialist">
        <div class="specialist-bg" style="background-color: #FEF6F4;">
            <div class="couserinfo-video">
                <div class="section-title">
                    <div class="couserinfo-video-title">录播课时</div>
                </div>
                <hr style="height:3px;border:none;border-top:1px double rgba(222,230,236,1);">
                <div class="content-box">
                    <p>共<?=count($course['trainingvideo'])?>个章节</p>
                </div>
                <div class="couserinfo-video-info">
                    <?php foreach ($course['trainingvideo'] as $k => $r){?>
                        <p onclick="videoPlay('<?=$r['sTrainingvideoUrl']?>')"><?=($k+1)?>、<?=$r['sChapterName']?><span><?=$r['time']?></span></p>
                    <?php }?>
                </div>
            </div>
            <div class="couserinfo-video-author">
                <div class="couserinfo-video-author-title">
                    讲师简介
                </div>
                <div class="couserinfo-video-author-head">
                    <img src="<?=Yii::$app->params['imagePath'].$course['headportrait']?>" alt="">
                    <p><?=$course['author']?></p>
                </div>
                <div class="couserinfo-video-author-content"><?=$course['info']?></div>
            </div>
        </div>
    </div>

</div>
<footer>
    <?=\app\modules\web\model\process\PublicProcess::MiddleWeb()?>
</footer>
<section class="pop-dp-bg">
    <img src="<?=Url::to('images/close.png')?>" alt="" class="close">
    <div class="content" id="PopDPlayer">

    </div>
</section>
<script>
    var windowWidth=$(window).width()<1200?1200:$(window).width()
    $('.container.couserinfo .specialist .specialist-bg').css('width',windowWidth+'px')
    $('.container.couserinfo .specialist .specialist-bg').css('margin-left',-(windowWidth-1200)/2+'px')

    $('.couserinfo .specialist-bg .couserinfo-video .couserinfo-video-info p').each(function (ids, items) {
        if((ids+1) % 2 == 0)
        {
            $(this).css('background','#ffffff');
        }
    });
    $('.couserinfo .specialist-bg .couserinfo-video .couserinfo-video-info p').mousemove(function(){
        $(this).css("color","#FF9D2A");
    });
    $('.couserinfo .specialist-bg .couserinfo-video .couserinfo-video-info p').mouseout(function(){

        $(this).css("color","rgba(103,101,98,1)");
    });

    var h = $('.couserinfo-video-info').height()<200?200:$('.couserinfo-video-info').height();

    $('.couserinfo-video').css('height',h+200+'px');

    var height=$('.couserinfo-video').height();

    $('.couserinfo').css('height',height+100+'px')
</script>
<?php
$this->endContent();
?>
