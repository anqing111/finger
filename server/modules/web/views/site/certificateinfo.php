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
</style>
<?=\app\modules\web\model\process\PublicProcess::TopWeb()?>
<div class="container index">
    <div class="specialist">
        <div class="specialist-bg" style="background-color: #FDF7F2; /* 浏览器不支持时显示 */
            /* Safari */
            background: -webkit-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
            /* Opera */
            background: -o-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
            /* Firefox */
            background: -moz-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
            /* 标准的语法, 放在最后 */
            background: linear-gradient(#FFFDFA 30%,  #FFFEFF 75%);
            ">
            <div class="container">
                <div class="section-title">
                    <div class="certificate-title">我的证书</div>
                </div>
                <hr>
                <div class="content-box certificate-info">
                    <div class="item flex-box" style="width: 800px">
                        <img src="<?=Yii::$app->params['imagePath'].$cert->sCertificateImg?>" alt="">
                        <div class="detail filler">
                            <div class="name"><?=$cert->sName?></div>
                            <div class="tip2">
                                <?=$cert->sContent?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container2">
                <div class="section-title">
                    <div class="certificate-video" style="margin-bottom: 20px">学习视频</div>
                </div>
                <hr>
                <div class="content-box" style="margin-top: 20px">
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
    </div>

</div>
<footer>
    <?=\app\modules\web\model\process\PublicProcess::MiddleWeb()?>
</footer>
<script>
    var height=$(".certificate-info .tip2").height()<256?256:$(".certificate-info .tip2").height();
    if($('.container .certificate-info').length){
        $('.container .certificate-info').css('height',height+100+'px')
    }

    $('.container2').css('top',height+100+'px');

    $('.certificate-video-list').each(function (ids, items) {
        if((ids+1) % 4 == 0 && ids > 0)
        {
            $(this).css('margin-right','0');
        }
    });

    var windowHeight = $('.specialist-bg').height() + $('.container2').height();
    windowHeight=windowHeight<800?800:windowHeight;

    $('.container .specialist').css('height',windowHeight-200+'px');

</script>
<?php
$this->endContent();
?>
