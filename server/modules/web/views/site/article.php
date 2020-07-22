<?php
use app\assets\WebAsset;
use yii\helpers\Url;
WebAsset::register($this);
$this->beginContent('@views/layouts/web.php');
?>
<style>
    .optionCourse{
        color:rgb(255, 157, 42);
    }
    body{
        background:#FEF6F4;
    }
    .articles2{
        display: none;
    }
</style>
<?=\app\modules\web\model\process\PublicProcess::TopWeb()?>
<div class="container article">
    <div class="article-top">
        <h3>全部文章</h3>
        <p>
            <button onclick="optionsArticle(1,this)">网站资讯类文章</button>
            <button onclick="optionsArticle(2,this)">技能薪酬类文章</button>
        </p>
    </div>
    <div class="bg"></div>
    <div class="content-box flex-box" style="margin-top: 20px">
        <div class="filler article-title articles1">
            <?php foreach($article as $k => $r){?>
                <p onclick="optionArticle(<?=$r->id?>)"><?=($k+1)?>、<?=mb_substr($r->title,0,25)?>...</p>
            <?php }?>
        </div>
        <div class="filler article-title articles2">
            <?php foreach($article2 as $k2 => $r2){?>
                <p onclick="optionArticle(<?=$r2->id?>)"><?=($k2+1)?>、<?=mb_substr($r2->title,0,25)?>...</p>
            <?php }?>
        </div>
        <div class="filler article-remen">
            <div class="hot-list flex-box filler">
                <div class="imgs">
                    <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                    <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                    <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                </div>
                <div class="list filler">
                    <div class="title flex-box">
                        <span class="dot"></span>
                        <span class="text">热门文章</span>
                    </div>
                    <div class="content">
                        <div class="item">
                            <span class="index">1</span>
                            <span class="text one-line">计算机技能</span>
                        </div>
                        <div class="item">
                            <span class="index">2</span>
                            <span class="text one-line">计算机技能</span>
                        </div>
                        <div class="item">
                            <span class="index">3</span>
                            <span class="text one-line">计算机技能</span>
                        </div>
                        <div class="item">
                            <span class="index">4</span>
                            <span class="text one-line">计算机技能</span>
                        </div>
                        <div class="item">
                            <span class="index">5</span>
                            <span class="text one-line">计算机技能</span>
                        </div>
                        <div class="item">
                            <span class="index">6</span>
                            <span class="text one-line">计算机技能</span>
                        </div>
                        <div class="item">
                            <span class="index">7</span>
                            <span class="text one-line">计算机技能</span>
                        </div>
                        <div class="item">
                            <span class="index">8</span>
                            <span class="text one-line">计算机技能</span>
                        </div>
                        <div class="item">
                            <span class="index">9</span>
                            <span class="text one-line">计算机技能</span>
                        </div>
                        <div class="item">
                            <span class="index">10</span>
                            <span class="text one-line">计算机技能</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer>
    <?=\app\modules\web\model\process\PublicProcess::MiddleWeb()?>
</footer>
<script>
    var h = 0;
    $('.article-title p').each(function (ids, items) {
        h = parseInt(h) + parseInt($(this).height());
    });
    if(h < 500)
    {
        h = 500;
    }
    $('.article-title').css('height',h+100+'px');
    $('.container.article').css('height',h+300+'px');

    function optionArticle(id) {
        location.href = 'index.php?r=web/site/articleinfo&id='+id;
    }

    $('.article-title p').mousemove(function(){
        $(this).css("color","#FF9D2A");
    });
    $('.article-title p').mouseout(function(){

        if(!$(this).hasClass('optionCourse'))
        {
            $(this).css("color","rgba(103,101,98,1)");
        }
    });

    $('.article-top button').mousemove(function(){
        $(this).css("color","#FF9D2A");
    });
    $('.article-top button').mouseout(function(){

        if(!$(this).hasClass('optionCourse'))
        {
            $(this).css("color","rgba(103,101,98,1)");
        }
    });

    function optionsArticle(index,that) {
        $('.article-top button').each(function () {
            $(this).removeClass('optionCourse');
            $(this).css("color","rgba(103,101,98,1)");
        });
        $(that).addClass('optionCourse');
        $(that).css("color","#FF9D2A");
        $('.articles1').css('display','none');
        $('.articles2').css('display','none');
        if(index == 1)
        {
            $('.articles1').css('display','');
        }else{
            $('.articles2').css('display','flex');
        }
    }
</script>

<?php
$this->endContent();
?>
