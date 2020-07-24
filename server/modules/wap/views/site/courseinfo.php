<?php
use app\assets\WapAsset;
use yii\helpers\Url;
WapAsset::register($this);
$this->beginContent('@views/layouts/wap.php');
?>
<style>
    body{
        overflow-x: hidden;
    }
</style>
<?=\app\modules\wap\model\process\PublicProcess::TopWeb()?>
<div class="container couserinfo">
    <div class="couserinfo-info">
        <img src="<?=Yii::$app->params['imagePath'].$course['sCourseImg']?>" alt="">
        <div class="detail">
            <div class="couserinfo-name">
                <div class="couserinfo-title"><?=$course['sCourseName']?></div>
                <div class="couserinfo-author">讲师简介></div>
            </div>
            <hr style="height:1px;border:none;background: #FCF7F2">
            <div class="couserinfo-jianjie">简介：</div>
            <div class="couserinfo-content"><?=mb_substr($course['sCourseInfo'],0,150)?>...</div>
        </div>
        <hr style="height:1.25rem;border:none;background: #FCF7F2;margin: 3.125rem 0">
        <div class="couserinfo-video">
            <div class="couserinfo-video-title">录播课时（共<?=count($course['trainingvideo'])?>个课时）</div>
            <div class="couserinfo-video-info">
                <?php foreach ($course['trainingvideo'] as $k => $r){?>
                    <div class="div1" onclick="videoPlay('<?=Yii::$app->params['imagePath'].$r['sTrainingvideoUrl']?>')">
                        <div class="div2"><?=($k+1)?></div>
                        <div class="div3"><img src="<?= Yii::$app->params['imagePath'] . '/wap/images/live.png' ?>" alt=""></div>
                        <div class="div4"><?=$r['sChapterName']?></div>
                    </div>
                    <hr style="height:1px;border:none;background: #FCF7F2">
                <?php }?>
            </div>
        </div>
        <div class="couserinfo-video-sign">我要报名</div>
        <div class="couserinfo-video-author" style="display: none">
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
<section class="pop-dp-bg">
    <img src="<?=Url::to('images/close.png')?>" alt="" class="close">
    <div class="content" id="PopDPlayer">

    </div>
</section>
<script>
    $('.div4').each(function (ids, items) {
        if($(this).text().length > 18)
        {
            $(this).text($(this).text().substring(0,18)+'...');
        }
    });

    $('.couserinfo-author').click(function () {
        $('.couserinfo-video-author').show();
        $('.detail').hide();
        $('.couserinfo-video').hide();
        $('.couserinfo-video-sign').hide();
        $('hr').hide();
    });

    $('.couserinfo-video-author-title').click(function () {
        $('.couserinfo-video-author').hide();
        $('.detail').show();
        $('.couserinfo-video').show();
        $('.couserinfo-video-sign').show();
        $('hr').show();
    });
</script>
<?php
$this->endContent();
?>
