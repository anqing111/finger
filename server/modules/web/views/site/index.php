<?php
use app\assets\WebAsset;
use yii\helpers\Url;
use app\models\lib\CCliveRetrieverProcess;
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
        <div class="blur-shadow-live" style="cursor:pointer">
            <p>进入教室  边学边聊</p>
            <img src="<?=Url::to('images/rectangle.png')?>" alt="" class="img2">
            <img src="<?=Url::to('images/livein.png')?>" alt="" class="img1">
            <img src="<?=Url::to('images/arrow.png')?>" alt="" class="img3">
        </div>
        <div class="blur-shadow active">
            <div class="blur-shadow-box">
                <img src="<?=Url::to('images/live.png')?>" alt="">
                <div class="title" style="margin-top: 27px"></div>
                <div class="tip" style="margin-top: 10px"></div>
            </div>
        </div>
        <div class="list filler flex-box">
            <div class="title"><?=date('m月d日')?>   <?=\app\modules\web\model\process\PublicProcess::week()?></div>
            <div class="content">
                <?php if(!empty($cclive)){?>
                    <?php foreach ($cclive as $k => $c){
                        $timeEnd = 0;
                        if($c['liveStatus'] == \app\models\db\BCclive::LIVE) //正在直播
                        {
                            $timeEnd = 1;
                        }else{
                            if(strtotime($c['liveStartTime']) < time())
                            {
                                $timeEnd = 2;
                            }
                        }

                        ?>
                        <?php if($k == 0){?>
                            <div class="item flex-box active" onclick='liveUrl("<?= $c['id']?>","<?=$c['name']?>","<?=$timeEnd?>",this)'>
                                <img src="<?=Url::to('images/player-list-icon.png')?>" alt="" class="icon" style="background-color:rgba(0,0,0,0);">
                                <div class="filler one-line"><?=$c['name']?></div>
                                <span class="time"><?=date('m-d H:i',strtotime($c['liveStartTime']))?></span>
                            </div>
                        <?php }else{?>
                            <div class="item flex-box" onclick='liveUrl("<?= $c['id']?>","<?=$c['name']?>","<?=$timeEnd?>",this)'>
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
            <img src="<?=Url::to('images/join.png')?>" alt="" class="img-title">
            <div class="group filler">
                <?php foreach($video as $ks => $s){?>
                    <img src="<?=Yii::$app->params['imagePath'].$s->sVideoImg?>" class="item" onclick="videoPlay('<?=Yii::$app->params['imagePath'].$s->sVideoUrl?>')"/>
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
                            <span class="text one-line"><?=mb_substr($p->sProfessionalName,0,20)?>...</span>
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
                        <div class="item flex-box" onclick="optionInstructor(<?=$r2->id?>)" style="cursor:pointer">
                            <img src="<?=Yii::$app->params['imagePath'].$r2->headportrait?>" alt="">
                            <div class="detail filler">
                                <div class="name"><?=$r2->sName?></div>
                                <div class="time"><?=$r2->year?>年从业经验</div>
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
            <a style="cursor:pointer" class="more" onclick="optionsArticle(2,this)">技能薪酬类文章></a>
            <a style="cursor:pointer;color: #FF9D2A" class="more" onclick="optionsArticle(1,this)">网站资讯类文章></a>
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
                        <span class="text">热门文章</span>
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
                        <span class="text">热门文章</span>
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
    <img src="<?=Url::to('images/close.png')?>" alt="" class="close">
    <div class="content" id="PopDPlayer">

    </div>
</section>
<script>
    $(function () {
        if($('.container.index').length) {
            $('.blur-shadow-live').css('visibility','hidden');
            $('.blur-shadow-live').css('opacity','0');
            // 主播放器初始化
            $('#MainDPlayer').find('iframe').attr('src', '<?=Url::to("live/video.html#roomid={$cclive[0]['id']}")?>');
            $('.blur-shadow').find('.title').html("<?=$cclive[0]['name']?>");
            <?php
            $timeEnd = 0;
            if($cclive[0]['liveStatus'] == \app\models\db\BCclive::LIVE) //正在直播
            {
                $timeEnd = 1;
            }else{
                if(strtotime($cclive[0]['liveStartTime']) < time())
                {
                    $timeEnd = 2;
                }
            }
            ?>
            var timeEnd = <?=$timeEnd?>;
            if(timeEnd == 2)
            {
                $('.blur-shadow').find('.tip').html("直播已结束");
            }else if(timeEnd == 0)
            {
                $('.blur-shadow').find('.tip').html("直播未开始");
            }else{
                $('.blur-shadow').find('.tip').css('display','none');
                $('.blur-shadow').find('.title').css('display','none');
                $('.blur-shadow.active').css('visibility','hidden');
                $('.icon:first').attr('src',"<?=Url::to('images/live.gif')?>");
                $('.blur-shadow-live').css('visibility','visible');
                $('.blur-shadow-live').css('opacity','1');
                $('.blur-shadow-live').click(function () {
                    var url = '<?=sprintf(Yii::$app->params['ccliveUrl'],$cclive[0]['id'],CCliveRetrieverProcess::userid)?>';
                    window.open(url);
                });
            }
        }
    });
    function jumpUrl(url) {
        location.href = url;
    }
    function liveUrl(roomid,name,timeEnd,that) {
        $(that).parent().find('.item').removeClass('active');
        $(that).addClass('active');
        //直播切换
        $('#MainDPlayer').html('<iframe src="<?=Url::to("live/video.html#roomid=")?>'+roomid+'" frameborder="0"  name="myFrameName" scrolling="yes" class="x-iframe" style="height: 100%;width: 100%"></iframe>');

        $('.blur-shadow').find('.tip').css('display','block');
        $('.blur-shadow').find('.title').css('display','block');
        $('.blur-shadow.active').css('visibility','visible');
        $('.blur-shadow').find('.title').html(name);
        $('.blur-shadow-live').css('visibility','hidden');
        $('.blur-shadow-live').css('opacity','0');
        if(timeEnd == 2)
        {
            $('.blur-shadow').find('.tip').html("直播已结束");
        }else if(timeEnd == 0)
        {
            $('.blur-shadow').find('.tip').html("直播未开始");
        }else{
            $('.blur-shadow').find('.tip').css('display','none');
            $('.blur-shadow').find('.title').css('display','none');
            $('.blur-shadow.active').css('visibility','hidden');
            $(that).find('img').attr('src',"<?=Url::to('images/live.gif')?>");
            $('.blur-shadow-live').css('visibility','visible');
            $('.blur-shadow-live').css('opacity','1');
            $('.blur-shadow-live').click(function () {
                var url = '<?=sprintf(Yii::$app->params['ccliveUrl'],'roomid1234',CCliveRetrieverProcess::userid)?>';
                url = url.replace("roomid1234",roomid);
                window.open(url);
            });
        }

    }

    function optionsArticle(index,that) {
        $('.articles1').css('display','none');
        $('.articles2').css('display','none');
        $('.more').css('color','#676562');
        $(that).css('color','#FF9D2A');
        if(index == 1)
        {
            $('.articles1').css('display','');
        }else{
            $('.articles2').css('display','flex');
        }
    }

    function optionInstructor(id) {
        location.href = 'index.php?r=web/site/instructorinfo&id='+id;
    }

</script>
<?php
$this->endContent();
?>
