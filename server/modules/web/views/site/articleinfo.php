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
    .top{
        background: #FEF6F2;
        height:200px;
        position:relative;
    }
    .top-head{
        width: 1200px;
        height: 200px;
        margin: 0 auto;
    }
    .top-head-child{
        width: 500px;
        height: 100px;
        position: relative;
        top: 87px;
    }
</style>
<?=\app\modules\web\model\process\PublicProcess::TopWeb()?>
<div class="top">
    <div class="top-head">
        <div class="article-title"><span><?=$article->title?></span></div>
        <div class="top-head-child">
            <div class="article-head"><img src="<?=Url::to('images/head.png')?>" alt=""></div>
            <div class="article-author"><?=$article->author?></div>
            <div class="article-time">发布时间：<?=date('m-d H:i',strtotime($article->dReleaseTime))?></div>
        </div>
    </div>
</div>
<div class="container article">
    <div class="bg"></div>
    <div class="redactor-editor" contenteditable="false" dir="ltr" style="min-height: 800px;border: none">
        <?=$article->content?>
    </div>
</div>
<footer>
    <?=\app\modules\web\model\process\PublicProcess::MiddleWeb()?>
</footer>
<script>
    var windowHeight=$(window).height()<600?600:$(window).height();
    if($('.container .article').length){
        $('.container .article').css('height',windowHeight-195+'px')
    }

    var left = $(".article-title span").position().left;
    $('.top-head-child').css('left',left+'px');

</script>
<?php
$this->endContent();
?>
