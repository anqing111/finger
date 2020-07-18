<?php
use app\assets\WebAsset;
use yii\helpers\Url;
WebAsset::register($this);
$this->beginContent('@views/layouts/web.php');
?>
    <style>
        .instructor-title{
            width:75px;
            height:19px;
            font-size:18px;
            font-family:Microsoft YaHei;
            font-weight:400;
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
                        <div class="instructor-title">全部专家</div>
                    </div>
                    <hr>
                    <div class="content-box">
                        <?php foreach($instructor as $r2){?>
                            <div class="item flex-box">
                                <img src="<?=Yii::$app->params['imagePath'].$r2->headportrait?>" alt="">
                                <div class="detail filler">
                                    <div class="name"><?=$r2->sName?></div>
                                    <div class="time">3年从业经验</div>
                                    <div class="tip"><?=mb_substr($r2->info,0,50)?>...</div>
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
    <script>
        var windowHeight=$('.container.index .container').height()<700?700:$('.container.index .container').height();
        if($('.container.index .container').length){
            $('.container.index').css('height',windowHeight+200+'px')
        }
    </script>
<?php
$this->endContent();
?>