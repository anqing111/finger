<?php
use app\assets\WebAsset;
use yii\helpers\Url;
WebAsset::register($this);
$this->beginContent('@views/layouts/web.php');
?>
<style>
    .item{
        font-family: 宋体;
        font-size: 14px;
    }
    .container.index .player-box .list .content .item .icon {
        width: 15px;
        height: 15px;
        margin-top: 16.5px;
    }
    .articles2{
        display: none;
    }
</style>
<?=\app\modules\web\model\process\PublicProcess::TopWeb()?>
<div class="container index">
    <div class="swiper-bg">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach($banner as $r){?>
                    <?php if(!empty($r->url)){?>
                        <div class="swiper-slide" style="background-image: url(<?=Yii::$app->params['imagePath'].$r->image?>);" onclick="jumpUrl('<?=$r->url?>')"></div>
                    <?php }else{?>
                        <div class="swiper-slide" style="background-image: url(<?=Yii::$app->params['imagePath'].$r->image?>);"></div>
                    <?php }?>
                <?php }?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="player-box flex-box">
        <div class="player" id="MainDPlayer">
            <iframe src="" frameborder="0"  name="myFrameName" scrolling="yes" class="x-iframe" style="height: 100%;width: 100%"></iframe>
        </div>
        <div class="blur-shadow active">
            <div class="title">【日韩漫画/二次元绘画】vip学习体验教室</div>
            <div class="tip">直播已结束</div>
            <button>查看详情</button>
        </div>
        <div class="list filler flex-box">
            <div class="title"><?=date('m月d日')?>   <?=\app\modules\web\model\process\PublicProcess::week()?></div>
            <div class="content">
                <?php if(!empty($cclive)){?>
                    <?php foreach ($cclive as $k => $c){?>
                        <?php if($k == 0){?>
                            <div class="item flex-box active" onclick='liveUrl("<?= $c['id']?>",this)'>
                                <img src="<?=Url::to('images/player-list-icon.png')?>" alt="" class="icon" style="background-color:rgba(0,0,0,0);">
                                <div class="filler one-line"><?=$c['name']?></div>
                                <span class="time"><?=date('m-d H:i',strtotime($c['liveStartTime']))?></span>
                            </div>
                        <?php }else{?>
                            <div class="item flex-box" onclick='liveUrl("<?= $c['id']?>",this)'>
                                <img src="<?=Url::to('images/player-list-icon.png')?>" alt="" class="icon" style="background-color:rgba(0,0,0,0);">
                                <div class="filler one-line"><?=$c['name']?></div>
                                <span class="time"><?=date('m-d H:i',strtotime($c['liveStartTime']))?></span>
                            </div>
                        <?php }?>
                    <?php }?>
                <?php }?>
            </div>
        </div>
    </div>
    <div class="person-show">
        <div class="section-title">
            <div class="title">个人秀</div>
        </div>
        <div class="content-box flex-box">
            <img src="https://f.cdn.xsteach.cn/uploaded/0a/43/6f/0a436f829eb2c3831721754afb40522a001.jpg" alt="" class="img-title">
            <div class="group filler">
                <?php foreach($studentopus as $ks => $s){?>
                    <img src="<?=Yii::$app->params['imagePath'].$s->sOpusvideoImg?>" class="item"/>
                <?php }?>
            </div>
            <div class="list flex-box">
                <div class="title flex-box">
                    <span class="dot"></span>
                    <span class="text">技能展示</span>
                </div>
                <div class="content">
                    <?php foreach($professional as $kp => $p){?>
                        <div class="item" style="font-size: 16px">
                            <span class="index"><?=($kp+1)?></span>
                            <span class="text one-line"><?=mb_substr($p->sProfessionalName,0,10)?>...</span>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <div class="specialist">
        <div class="specialist-bg">
            <div class="container">
                <div class="section-title">
                    <div class="title">专家介绍</div>
                    <a href="index.php?r=web/site/instructor" class="more">更多专家></a>
                </div>
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
    <div class="articles">
        <div class="section-title">
            <div class="title">文章资讯</div>
            <a style="cursor:pointer" class="more" onclick="optionsArticle(2)">技能薪酬类文章></a>
            <a style="cursor:pointer" class="more" onclick="optionsArticle(1)">网站资讯类文章></a>
        </div>
        <div class="content-box flex-box articles1">
            <div class="main-list" style="width: 26%">
                <?php foreach ($article as $k3 => $r3){?>
                    <a href="index.php?r=web/site/articleinfo&id=<?=$r3->id?>"><div class="item one-line"><?=($k3+1)?>、<?=mb_substr($r3->title,0,15)?>...</div></a>
                <?php }?>
            </div>
            <div class="hot-list flex-box filler" style="width: 26%">
                <div class="imgs">
                    <?php foreach($article3 as $k5 => $r5){?>
                        <?php if($k5 == 3){
                            break;
                        }?>
                        <img src="<?=Yii::$app->params['imagePath'].$r5->picture?>" alt="">
                    <?php }?>
                </div>
                <div class="list filler">
                    <div class="title flex-box">
                        <span class="dot"></span>
                        <span class="text">技能展示</span>
                    </div>
                    <div class="content">
                        <?php foreach($article3 as $k6 => $r6){?>
                            <?php if($k5 < 3){
                                continue;
                            }?>
                            <div class="item">
                                <span class="index"><?=($k6-2)?></span>
                                <span class="text one-line"><?=mb_substr($r6->title,0,15)?>...</span>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="more-list" style="width: 26%">
                <div class="title">
                    <a href="index.php?r=web/site/articlelist">查看更多></a>
                </div>
                <div class="content">
                    <?php foreach ($article5 as $k9 => $r9){?>
                        <div class="item one-line"><?=($k9+1)?>、<?=mb_substr($r9->title,0,15)?>...</div>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="content-box flex-box articles2">
            <div class="main-list" style="width: 26%">
                <?php foreach ($article2 as $k4 => $r4){?>
                    <a href="index.php?r=web/site/articleinfo&id=<?=$r4->id?>"><div class="item one-line"><?=($k4+1)?>、<?=mb_substr($r4->title,0,15)?>...</div></a>
                <?php }?>
            </div>
            <div class="hot-list flex-box filler" style="width: 26%">
                <div class="imgs">
                    <?php foreach($article4 as $k7 => $r7){?>
                        <?php if($k7 == 3){
                            break;
                        }?>
                        <img src="<?=Yii::$app->params['imagePath'].$r7->picture?>" alt="">
                    <?php }?>
                </div>
                <div class="list filler">
                    <div class="title flex-box">
                        <span class="dot"></span>
                        <span class="text">技能展示</span>
                    </div>
                    <div class="content">
                        <?php foreach($article4 as $k8 => $r8){?>
                            <?php if($k8 < 3){
                                continue;
                            }?>
                            <div class="item">
                                <span class="index"><?=($k8-2)?></span>
                                <span class="text one-line"><?=mb_substr($r8->title,0,15)?>...</span>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="more-list" style="width: 26%">
                <div class="title">
                    <a href="index.php?r=web/site/articlelist">查看更多></a>
                </div>
                <div class="content">
                    <?php foreach ($article6 as $k10 => $r10){?>
                        <div class="item one-line"><?=($k10+1)?>、<?=mb_substr($r10->title,0,15)?>...</div>
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
    <img src="" alt="" class="close">
    <div class="content" id="PopDPlayer">

    </div>
</section>
<script>
    $(function () {
        if($('.container.index').length) {
            // 主播放器初始化
            $('#MainDPlayer').find('iframe').attr('src', '<?=Url::to("live/video.html#roomid={$cclive[0]['id']}")?>');
        }
    });
    function jumpUrl(url) {
        location.href = url;
    }
    function liveUrl(roomid,that) {
        $(that).parent().find('.item').removeClass('active');
        $(that).addClass('active');
        //直播切换
        $('#MainDPlayer').html('<iframe src="<?=Url::to("live/video.html#roomid=")?>'+roomid+'" frameborder="0"  name="myFrameName" scrolling="yes" class="x-iframe" style="height: 100%;width: 100%"></iframe>');
    }
    function optionsArticle(index) {
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
