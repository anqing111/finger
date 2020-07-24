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
    .container.index{
        background-color: #FDF7F2; /* 浏览器不支持时显示 */
        /* Safari */
        background: -webkit-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
        /* Opera */
        background: -o-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
        /* Firefox */
        background: -moz-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
        /* 标准的语法, 放在最后 */
        background: linear-gradient(#FFFDFA 30%,  #FFFEFF 75%);
    }
</style>
<?=\app\modules\wap\model\process\PublicProcess::TopWeb()?>
<div class="container index">
    <div class="container">
        <div class="section-title">
            <div class="instructorinfo-title">讲师信息</div>
        </div>
        <hr style="height:1px;border:none;border-top:1px double rgba(222,230,236,1);">
        <div class="content-box instructorinfo-info">
            <div class="item flex-box" style="justify-content: center;">
                <img src="<?=Yii::$app->params['imagePath'].$instructor['bigheadportrait']?>" alt="">
            </div>
            <div class="detail">
                <div class="name"><?=$instructor['sName']?></div>
                <div class="name" style="font-weight: 400;margin-top: 1.6875rem;"><?=$instructor['year']?>年工作经验</div>
                <div class="tip2">
                    <?=$instructor['info']?>
                </div>
            </div>
        </div>

    </div>
    <hr style="height:1px;border:none;border-top:4px double #FEF5EC;background: #FEF5EC;margin-top: 9rem">
    <div class="container2">
        <div class="section-title">
            <div class="instructorinfo-book">著作展示</div>
        </div>
        <hr style="height:1px;border:none;background: #FEF5EC">
        <div class="content-box">
            <?php foreach ($instructor['instructorbook'] as $k => $book){?>
                <?php if(($k+1) % 2 == 0){?>
                    <div class="flex-box instructorinfo-book-list" style="margin-right: 0">
                        <img src="<?=Yii::$app->params['imagePath'].$book['sBookImg']?>" alt="">
                        <p class="instructor-name"><?=$book['sBookName']?></p>
                    </div>
                <?php }else{?>
                    <div class="flex-box instructorinfo-book-list">
                        <img src="<?=Yii::$app->params['imagePath'].$book['sBookImg']?>" alt="">
                        <p class="instructor-name"><?=$book['sBookName']?></p>
                    </div>
                <?php }?>
            <?php }?>
        </div>
    </div>
    <hr style="height:1px;border:none;border-top:4px double #FEF5EC;background: #FEF5EC">
    <div class="container3">
        <div class="section-title">
            <div class="instructorinfo-title">作品展示</div>
        </div>
        <hr style="height:1px;border:none;background: #FEF5EC">
        <div class="content-box instructorinfo-video">
            <?php foreach ($instructor['instructorvideo'] as $video){?>
            <div class="item flex-box" onclick="videoPlay('<?=Yii::$app->params['imagePath'].$video['sTrainUrl']?>')">
                <img src="<?=Yii::$app->params['imagePath'].$video['sTrainImg']?>" alt="">
                <div class="tip2">
                    <?=mb_substr($video['sOpusInfo'],0,63).'...'?>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</div>
<footer>
    <?=\app\modules\wap\model\process\PublicProcess::MiddleWeb()?>
</footer>
<section class="pop-dp-bg">
    <img src="<?=Url::to('images/close.png')?>" alt="" class="close">
    <div class="content" id="PopDPlayer">

    </div>
</section>
<?php
$this->endContent();
?>
