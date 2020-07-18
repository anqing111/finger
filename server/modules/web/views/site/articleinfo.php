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
</style>
<?=\app\modules\web\model\process\PublicProcess::TopWeb()?>
<div class="top">
    <div class="article-title"><?=$article->title?></div>
    <div class="article-head"><img src="<?=Url::to('images/head.png')?>" alt=""></div>
    <div class="article-author"><?=$article->author?></div>
    <div class="article-time">发布时间：<?=date('Y年m月d日 H:i',strtotime($article->dReleaseTime))?></div>
</div>
<div class="container article">
    <div class="bg"></div>
    <div class="redactor-editor" contenteditable="true" dir="ltr" style="min-height: 800px;border: none">
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
</script>
<?php
$this->endContent();
?>
