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
    .instructor-title{
        height:19px;
        font-size:20px;
        font-family:Microsoft YaHei;
        font-weight:bold;
        color:rgba(103,101,98,1);
        line-height:21px;
        padding-top: 20px;
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
                    <div class="instructor-title">讲师信息</div>
                </div>
                <hr style="height:3px;border:none;border-top:1px double rgba(222,230,236,1);;">
                <div class="content-box instructor-info">
                    <div class="item flex-box" style="width: 800px">
                        <img src="<?=Yii::$app->params['imagePath'].$instructor['bigheadportrait']?>" alt="" style="width:256px;margin-right: 80px;">
                        <div class="detail filler">
                            <div class="name"><?=$instructor['sName']?></div>
                            <div class="time"><?=$instructor['year']?>年从业经验</div>
                            <div class="tip2">
                                <?=$instructor['info']?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container2">
                <div class="section-title">
                    <div class="instructor-book" style="margin-bottom: 20px">著作展示</div>
                </div>
                <hr style="height:3px;border:none;border-top:1px double rgba(222,230,236,1);;">
                <div class="content-box" style="margin-top: 20px">
                    <?php foreach ($instructor['instructorbook'] as $book){?>
                        <div class="flex-box instructor-book-list">
                            <img src="<?=Yii::$app->params['imagePath'].$book['sBookImg']?>" alt="">
                            <p class="instructor-name"><?=$book['sBookName']?></p>
                        </div>
                    <?php }?>
                </div>
            </div>
            <div class="container3">
                <div class="section-title">
                    <div class="instructor-title">作品展示</div>
                </div>
                <hr style="height:3px;border:none;border-top:1px double rgba(222,230,236,1);;">
                <div class="content-box instructor-video">
                    <?php foreach ($instructor['instructorvideo'] as $video){?>
                        <div class="item flex-box" style="width: 1000px">
                            <img src="<?=Yii::$app->params['imagePath'].$video['sTrainImg']?>" alt="" style="width:256px;margin-right: 58px;" onclick="videoPlay('<?=$video['sTrainUrl']?>')">
                            <div class="detail filler">
                                <div class="tip2">
                                    <?=$video['sOpusInfo']?>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
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
    var height=$(".instructor-info .tip2").height()<256?256:$(".instructor-info .tip2").height();
    if($('.container .instructor-info').length){
        $('.container .instructor-info').css('height',height+100+'px')
    }

    $('.container2').css('top',height+100+'px');
    $('.container3').css('top',height+100+'px');

    height=$(".instructor-video").height()<256?256:$(".instructor-video").height();

    if($('.container3 ').length){
        $('.container3 ').css('height',height+174+'px')
    }

    var windowHeight = $('.container3 ').height() + $('.specialist-bg').height()
    windowHeight=windowHeight<800?800:windowHeight;

    $('.container .specialist').css('height',windowHeight+200+'px')
</script>
<?php
$this->endContent();
?>
