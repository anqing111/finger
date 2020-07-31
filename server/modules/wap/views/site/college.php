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
    .title{
        width:2.8916rem;
        height:1px;
        background:rgba(239,137,17,1);
        border:1px solid rgba(216,112,0,1);
        display: inline-block;
        margin-bottom: 5px;
    }
    .top{
        line-height: 4.04166rem;
        height: 15.625rem;
    }
    .top img{
        height: 15.625rem;
        position: relative;
        right: 38rem;
    }
</style>
<?=\app\modules\wap\model\process\PublicProcess::TopWeb()?>
<div class="top">
    <img src="<?=Yii::$app->params['imagePath'].'/wap/images/bg.png'?>" alt="" style="background: rgba(0,0,0,0);">
</div>
<div class="container college" style="height: 100%;">
    <div class="redactor-editor" contenteditable="false" dir="ltr" style="min-height: 800px;border: none">
        <p style="text-align: center;font-weight: bold;font-size: 3rem"><span class="title"></span><?=$university->title ?? ''?><span class="title"></span></p>
        <?=$university->content ?? ''?>
    </div>
</div>
<footer>
    <?=\app\modules\wap\model\process\PublicProcess::MiddleWeb()?>
</footer>
<?php
$this->endContent();
?>
