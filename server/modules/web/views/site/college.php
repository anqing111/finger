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
    .title{
        width:63px;
        height:1px;
        background:rgba(239,137,17,1);
        border:1px solid rgba(216,112,0,1);
        display: inline-block;
        margin-bottom: 5px;
    }
</style>
<?=\app\modules\web\model\process\PublicProcess::TopWeb()?>
<div class="top">
    <img src="<?=Url::to('images/bg.png')?>" alt="" style="background: rgba(0,0,0,0);margin-top: 0px">
</div>
<div class="container college" style="height: 100%;">
    <div class="bg"></div>
    <div class="redactor-editor" contenteditable="false" dir="ltr" style="min-height: 800px;border: none">
        <p style="text-align: center;font-weight: bold;font-size: 22px"><span class="title"></span><?=$university->title ?? ''?><span class="title"></span></p>
        <?=$university->content ?? ''?>
    </div>
</div>
<footer>
    <?=\app\modules\web\model\process\PublicProcess::MiddleWeb()?>
</footer>
<script>
    var windowHeight=$(window).height()<600?600:$(window).height();
    if($('.container .college').length){
        $('.container .college').css('height',windowHeight-195+'px')
    }
</script>
<?php
$this->endContent();
?>
