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
    <div class="container" style="margin-bottom: 3.08333rem">
        <div class="section-title">
            <div class="certificate-title">我的证书</div>
        </div>
        <hr style="height:1px;border:none;border-top:1px double rgba(222,230,236,1);">
        <div class="content-box certificate-info">
            <div class="item flex-box" style="justify-content: center;">
                <img src="<?=Yii::$app->params['imagePath'].$cert->sCertificateImg?>" alt="">
            </div>
            <div class="detail">
                <div class="name"><?=$cert->sName?></div>
                <div class="tip2">
                    <?=$cert->sContent?>
                </div>
            </div>
        </div>
    </div>
    <hr style="height:1px;border:none;border-top:4px double #FEF5EC;background: #FEF5EC">
    <div class="container2">
        <div class="section-title">
            <div class="certificate-video">学习视频</div>
        </div>
        <hr style="height:1px;border:none;border-top:1px double rgba(222,230,236,1);">
        <div class="content-box">
            <?php foreach ($video as $k => $r){?>
                <?php if(($k + 1) % 2 == 0){?>
                    <div class="flex-box certificate-video-list" style="margin-right: 0">
                        <img src="<?=Yii::$app->params['imagePath'].$r->sVideoImg?>" alt="" onclick="videoPlay('<?=$r->sVideoUrl?>')">
                    </div>
                <?php }else{?>
                    <div class="flex-box certificate-video-list">
                        <img src="<?=Yii::$app->params['imagePath'].$r->sVideoImg?>" alt="" onclick="videoPlay('<?=$r->sVideoUrl?>')">
                    </div>
                <?php }?>
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
