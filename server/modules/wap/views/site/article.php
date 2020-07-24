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
    .container.article{
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
<div class="container article">
    <div class="container" style="position: relative;">
        <div class="section-title" style="height: 7.36vh">
            <div class="article-title">全部文章</div>
        </div>
        <hr style="height:1px;border:none;background: #FEF5EC">
        <div class="article-type">

            <div class="article-type-info" onclick="optionsArticle(1,this)">
                <div class="article-type-info-tag"></div>
                <div class="article-type-info-title">网站资讯...</div>
            </div>
            <div class="article-type-technical" onclick="optionsArticle(2,this)">
                <div class="article-type-info-tag" style="visibility: hidden"></div>
                <div class="article-type-info-title">技能薪酬...</div>
            </div>
        </div>
        <div class="article-info">
            <h3>网站资讯类文章（共<?=count($article)?>篇）</h3>
            <?php foreach($article as $k => $r){?>
                <a href="index.php?r=wap/site/articleinfo&id=<?=$r->id?>"><p><?=($k+1)?>、<?=mb_substr($r->title,0,15)?>...</p></a>
            <?php }?>
        </div>
        <div class="article-info" style="display:none">
            <h3>网站资讯类文章（共<?=count($article2)?>篇）</h3>
            <?php foreach($article2 as $k2 => $r2){?>
                <a href="index.php?r=wap/site/articleinfo&id=<?=$r->id?>"><p><?=($k2+1)?>、<?=mb_substr($r2->title,0,15)?>...</p></a>
            <?php }?>
        </div>
    </div>
</div>
<script>
    optionsHeight(1);
    function optionsHeight(index) {
        if(index == 1)
        {
            var h = $('.article-info:first').height() / 8;
        }else{
            var h = $('.article-info:last').height() / 8;
        }

        var windowHeight=$(window).height() / 8;
        var height = 0;
        var phoneType = iphoneAdapter();
        if(h > windowHeight)
        {

            height = h;
            if(phoneType == 'iPhone8P'){
                height = h - 10;
            }
            if(phoneType == 'iPhone5'){
                height = h + 18;
            }
            if(phoneType == 'Pixel 2'){
                height = h - 10;
            }
            if(phoneType == 'Pixel 2 XL'){
                height = h - 15;
            }
            if(phoneType == 'Moto G (4)' || phoneType == 'Android'){
                height = h + 4;
            }
            if(phoneType == 'iPad'){
                height = h - 131;
            }
        }else{
            height = windowHeight - 12.6;
            if(phoneType == 'iPhone8P'){
                height = windowHeight - 21.4;
            }
            if(phoneType == 'iPhone5'){
                height = windowHeight-0.6;
            }
            if(phoneType == 'Pixel 2 XL'){
                height = windowHeight - 9;
            }
            if(phoneType == 'Pixel 2'){
                height = windowHeight - 22.6;
            }
            if(phoneType == 'Moto G (4)' || phoneType == 'Android'){
                height = windowHeight - 9.6;
            }
            if(phoneType == 'iPad'){
                height = windowHeight - 98.2;
            }
            if(phoneType == 'iPhoneX'){
                height = windowHeight - 14;
            }
        }

        $('.article-type').css('height',height+'rem');
    }

    function optionsArticle(index,that) {
        if(index == 1)
        {
            $('.article-type-info').css('background','#FFF');
            $('.article-type-technical').css('background','#FFFCF9');
            $('.article-info:first').css('display','inline-block');
            $('.article-info:last').css('display','none');
            $('.article-type-info-tag:first').css('visibility','visible');
            $('.article-type-info-tag:last').css('visibility','hidden');
            optionsHeight(1);
        }else{
            $('.article-type-info').css('background','#FFFCF9');
            $('.article-type-technical').css('background','#fff');
            $('.article-info:first').css('display','none');
            $('.article-info:last').css('display','inline-block');
            $('.article-type-info-tag:first').css('visibility','hidden');
            $('.article-type-info-tag:last').css('visibility','visible');
            optionsHeight(2);
        }
    }
</script>

<?php
$this->endContent();
?>
