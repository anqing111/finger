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
<div class="top">
    <div class="article-title"><?=$article->title?></div>
    <div class="article-head"><img src="<?=Url::to('images/head.png')?>" alt="" style="width: 3.75rem;height: 3.75rem"></div>
    <div class="article-author"><?=$article->author?></div>
    <div class="article-time">发布时间：<?=date('Y年m月d日 H:i',strtotime($article->dReleaseTime))?></div>
</div>
<div class="container article">
    <div class="bg"></div>
    <div class="redactor-editor" contenteditable="true" dir="ltr" style="min-height: 800px;border: none">
        <?=$article->content?>
    </div>
</div>
<script>
    var h = $('.article-title').height();
    if(h > 17)
    {
        $('.top .article-title').css('top','3.75rem');
    }
</script>
<?php
$this->endContent();
?>
