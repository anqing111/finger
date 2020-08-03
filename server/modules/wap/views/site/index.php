<?php
use app\assets\WapAsset;
use yii\helpers\Url;
use app\models\lib\CCliveRetrieverProcess;
WapAsset::register($this);
$this->beginContent('@views/layouts/wap.php');
?>
    <style>
        .hot-list .more {
            font-size: 1.5rem;
            color: #676562;
            margin-left: 22.25rem;
            width: 13rem;
        }

        .articles2{
            display: none;
        }
        .blur-shadow-box{
            height: 11.375rem;
            position: relative;
            top:9.5rem;
        }
        .blur-shadow-box img{
            background-color: rgba(0, 0, 0, 0);
            width: 5rem;
            height: 4.5625rem;
        }
        .blur-shadow-live{
            width: 40.625rem;
            height: 8.625rem;
            position: absolute;
            left: 4.6875rem;
            top: 10.9375rem;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            opacity: 1;
            visibility: visible;
            transition: all 0.3s;
        }
        .blur-shadow-live .img1{
            width: 8.75rem;
            height: 8.625rem;
            background-color: rgba(0, 0, 0, 0);
            position: relative;
            top: -10.0625rem;
        }
        .blur-shadow-live .img2{
            width: 31.875rem;
            height: 5.625rem;
            background-color: rgba(0, 0, 0, 0);
            position: relative;
            left: 1.75rem;
            top:-1.75rem;
        }
        .blur-shadow-live .img3{
            width: 2.5rem;
            height: 1.625rem;
            background-color: rgba(0, 0, 0, 0);
            position: relative;
            left: 19.375rem;
            top:-12.555rem;
        }
        .blur-shadow-live p{
            width: 17.0625rem;
            height: 1.8125rem;
            position: relative;
            left: 11.87rem;
            top:1.625rem;
            z-index: 1;
            font-size: 1.875rem;
            color: #FFFFFF;
        }
        .container.index .articles .hot-list .imgs img:nth-child(even){
            margin-left: 1.275rem;
        }
        .container.index .person-show .content-box .group .item:nth-child(even){
            margin-left: 1.275rem;
        }
        .container.index .person-show .content-box .group .item {
            /*width: 20.25rem;*/
            height: 15.625rem;
            margin-top: 1rem;
        }
        .container.index .articles .hot-list .item .index
        {
            width: 1.675rem;
            height: 1.675rem;
        }
        .play{
            position: relative;
            top: -1rem;
        }
        .playImg{
            position: relative;
            top:16.7rem;
            width: auto;
            height: 3.75rem;
            opacity: 0.6;
            background: rgba(0,0,0,1);
        }
        .playImg img{
            width: 2.3rem;
            height: 2.3rem;
            background: rgba(0,0,0,0);
            margin-left: 1.2rem;
            margin-top: 0.8rem;
        }
        .playImg p{
            width: 15rem;
            font-size: 1.5rem;
            color: #CFCFCF;
            position: relative;
            display: inline-block;
            vertical-align: middle;
            top: 0.23rem;
        }
    </style>
<?=\app\modules\wap\model\process\PublicProcess::TopWeb()?>
    <div class="container index">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach($banner as $r){?>
                    <?php if(!empty($r->wapUrl)){?>
                        <div class="swiper-slide" style="background-image: url(<?=Yii::$app->params['imagePath'].$r->WapBanner?>);background-repeat: no-repeat;background-size: 46.875rem 24.1875rem;" onclick="jumpUrl('<?=$r->wapUrl?>')"></div>
                    <?php }else{?>
                        <div class="swiper-slide" style="background-image: url(<?=Yii::$app->params['imagePath'].$r->WapBanner?>);background-repeat: no-repeat;background-size: 46.875rem 24.1875rem;"></div>
                    <?php }?>
                <?php }?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="player-box">
            <div class="player" id="MainDPlayer">
                <iframe src="" frameborder="0"  name="myFrameName" scrolling="yes" class="x-iframe" style="height: 100%;width: 100%"></iframe>
            </div>
            <div class="blur-shadow-live">
                <p>进入教室  边学边聊</p>
                <img src="<?=Url::to('images/rectangle.png')?>" alt="" class="img2">
                <img src="<?=Url::to('images/livein.png')?>" alt="" class="img1">
                <img src="<?=Url::to('images/arrow.png')?>" alt="" class="img3">
            </div>
            <div class="blur-shadow active">
                <div class="blur-shadow-box">
                    <img src="<?=Url::to('images/live.png')?>" alt="">
                    <div class="title" style="margin-top: 2.1875rem;color: #F9F9F9;font-size: 1.875rem;"></div>
                    <div class="tip" style="margin-top: 0.625rem;color: #F9F9F9;font-size: 1.5rem;"></div>
                </div>
            </div>
            <div class="list" style="margin-bottom: 1.3125rem">
                <div class="title"><?=date('m月d日')?>   <?=\app\modules\wap\model\process\PublicProcess::week()?></div>
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
                                <div class="item flex-box active" onclick='liveUrl("<?= $c['id']?>","<?=$c['name']?>","<?=$timeEnd?>",this)' style="height: 3.65625rem;">
                                    <img src="<?=Url::to('images/player-list-icon.png')?>" alt="" class="icon" style="background-color:rgba(0,0,0,0);">
                                    <div class="filler one-line" style="font-size: 1.875rem"><?=$c['name']?></div>
                                    <span class="time" style="font-size: 1.875rem"><?=date('m-d H:i',strtotime($c['liveStartTime']))?></span>
                                </div>
                            <?php }else{?>
                                <?php if($k == count($cclive)-1){?>
                                    <div class="item flex-box" onclick='liveUrl("<?= $c['id']?>","<?=$c['name']?>","<?=$timeEnd?>",this)' style="height: 4.65625rem;">
                                        <img src="<?=Url::to('images/player-list-icon.png')?>" alt="" class="icon" style="background-color:rgba(0,0,0,0);">
                                        <div class="filler one-line" style="font-size: 1.875rem"><?=$c['name']?></div>
                                        <span class="time" style="font-size: 1.875rem"><?=date('m-d H:i',strtotime($c['liveStartTime']))?></span>
                                    </div>
                                <?php }else{?>
                                    <div class="item flex-box" onclick='liveUrl("<?= $c['id']?>","<?=$c['name']?>","<?=$timeEnd?>",this)' style="height: 3.65625rem;">
                                        <img src="<?=Url::to('images/player-list-icon.png')?>" alt="" class="icon" style="background-color:rgba(0,0,0,0);">
                                        <div class="filler one-line" style="font-size: 1.875rem"><?=$c['name']?></div>
                                        <span class="time" style="font-size: 1.875rem"><?=date('m-d H:i',strtotime($c['liveStartTime']))?></span>
                                    </div>
                                <?php }?>
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
            <div class="content-box">
                <div class="flex-box">
                    <img src="<?=Url::to('images/person.jpg')?>" alt="" class="img-title">
                    <div class="list">
                        <div class="title flex-box">
                            <span class="dot"></span>
                            <span class="text">技能展示</span>
                        </div>
                        <div class="content flex-box">
                            <?php foreach($professional as $kp => $p){?>
                                <?php if($kp == 0 || $kp == 5){?>
                                    <div class="filler">
                                <?php }?>
                                <div class="item">
                                    <span class="index"><?=($kp+1)?></span>
                                    <span class="text one-line"><?=mb_substr($p->sProfessionalName,0,5)?></span>
                                </div>
                                <?php if($kp == 4 || $kp == 9){?>
                                    </div>
                                <?php }?>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <div class="group flex-box" style="width: 44.4rem">
                    <?php foreach($video as $ks => $s){
                        $top = '';
                        if($ks > 1)
                        {
                            $top = 'top:-3rem';
                        }

                        ?>
                        <?php if(($ks + 1) % 2 == 0){?>
                            <div class="play" style="margin-right: 0;<?=$top?>">
                                <div class="playImg">
                                    <img src="<?= Yii::$app->params['imagePath'] . '/wap/images/play.png' ?>" alt="">
                                    <?php if(mb_strlen($s->sProblemName) > 10){?>
                                        <p><?=mb_substr($s->sProblemName,0,10)?></p>
                                    <?php }else{?>
                                        <p><?=$s->sProblemName?></p>
                                    <?php }?>
                                </div>
                                <div>
                                    <img src="<?=Yii::$app->params['imagePath'].$s->sVideoImg?>" class="item" onclick="videoPlay('<?=$s->sVideoUrl?>')"/>
                                </div>
                            </div>
                        <?php }else{?>
                            <div class="play" style="margin-right: 1rem;<?=$top?>">
                                <div class="playImg">
                                    <img src="<?= Yii::$app->params['imagePath'] . '/wap/images/play.png' ?>" alt="">
                                    <?php if(mb_strlen($s->sProblemName) > 10){?>
                                        <p><?=mb_substr($s->sProblemName,0,10)?></p>
                                    <?php }else{?>
                                        <p><?=$s->sProblemName?></p>
                                    <?php }?>
                                </div>
                                <div>
                                    <img src="<?=Yii::$app->params['imagePath'].$s->sVideoImg?>" class="item" onclick="videoPlay('<?=$s->sVideoUrl?>')"/>
                                </div>
                            </div>
                        <?php }?>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="specialist">
            <div class="section-title">
                <div class="title">专家介绍</div>
                <a href="index.php?r=wap/site/instructor" class="more">更多专家></a>
            </div>
            <div class="content-box">
                <?php foreach($instructor as $r2){?>
                    <div class="item flex-box" onclick="optionInstructor(<?=$r2->id?>)" style="cursor:pointer">
                        <img src="<?=Yii::$app->params['imagePath'].$r2->headportrait?>" alt="">
                        <div class="detail filler">
                            <div class="name"><?=$r2->sName?></div>
                            <div class="time" style="font-size: 1.7rem"><?=$r2->year?>年从业经验</div>
                            <?php if(mb_strlen($r2->info) > 50){?>
                                <div class="tip" style="font-size: 1.7rem"><?=mb_substr($r2->info,0,50)?>...</div>
                            <?php }else{?>
                                <div class="tip" style="font-size: 1.7rem"><?=$r2->info?></div>
                            <?php }?>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
        <div class="articles">
            <div class="section-title">
                <div class="title">文章资讯</div>
                <a class="more" onclick="optionsArticle(1,this)" style="color: #FF9D2A">网站资讯类文章></a>
                <a class="more" onclick="optionsArticle(2,this)">技能薪酬类文章></a>
            </div>
            <div class="content-box">
                <div class="main-list articles1">
                    <?php foreach ($article as $k3 => $r3){?>
                        <?php if(mb_strlen($r3->title) > 15){?>
                            <a href="index.php?r=wap/site/articleinfo&id=<?=$r3->id?>"><div class="item one-line" style="line-height: 3.625rem"><?=($k3+1)?>、<?=mb_substr($r3->title,0,15)?>...</div></a>
                        <?php }else{?>
                            <a href="index.php?r=wap/site/articleinfo&id=<?=$r3->id?>"><div class="item one-line" style="line-height: 3.625rem"><?=($k3+1)?>、<?=$r3->title?></div></a>
                        <?php }?>
                    <?php }?>
                </div>
                <div class="main-list articles2">
                    <?php foreach ($article2 as $k2 => $r2){?>
                        <?php if(mb_strlen($r2->title) > 15){?>
                            <a href="index.php?r=wap/site/articleinfo&id=<?=$r2->id?>"><div class="item one-line" style="line-height: 3.625rem"><?=($k2+1)?>、<?=mb_substr($r2->title,0,15)?>...</div></a>
                        <?php }else{?>
                            <a href="index.php?r=wap/site/articleinfo&id=<?=$r2->id?>"><div class="item one-line" style="line-height: 3.625rem"><?=($k2+1)?>、<?=$r2->title?></div></a>
                        <?php }?>
                    <?php }?>
                </div>
                <div class="hot-list">
                    <div class="title flex-box">
                        <span class="dot"></span>
                        <span class="text" style="width: 17rem;">热门文章</span>
                        <a href="index.php?r=wap/site/articlelist" class="more">查看更多></a>
                    </div>
                    <div class="imgs flex-box">
                        <?php foreach($article3 as $k5 => $r5){?>
                            <?php if($k5 == 2){
                                break;
                            }?>
                            <img src="<?=Yii::$app->params['imagePath'].$r5->picture?>" onclick="jumpUrl('index.php?r=wap/site/articleinfo&id=<?=$r5->id?>')">
                        <?php }?>
                    </div>
                    <div class="list">
                        <?php foreach($article3 as $k6 => $r6){?>
                            <?php if($k6 < 2){
                                continue;
                            }else{
                                if(mb_strlen($r6->title) > 15)
                                {
                                    echo '<div class="item">
                                <span class="index">'.($k6-1).'</span>
                                <span class="text one-line">'.mb_substr($r6->title,0,15).'...'.'</span>
                            </div>';
                                }else{
                                    echo '<div class="item" onclick="jumpUrl(\'index.php?r=wap/site/articleinfo&id='.$r6->id.'\')">
                                <span class="index">'.($k6-1).'</span>
                                <span class="text one-line">'.$r6->title.'</span>
                            </div>';
                                }
                            }?>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <?=\app\modules\wap\model\process\PublicProcess::MiddleWeb()?>
    </footer>
    <section class="pop-dp-bg">
        <img src="<?=Url::to('images/close.png')?>" alt="" class="close">
        <div class="content" id="PopDPlayer">

        </div>
    </section>
    <script>
        $(function () {
            if($('.container.index').length) {
                $('.blur-shadow-live').css('display','none');
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
                    $('.blur-shadow-live').css('display','block');
                    $('.blur-shadow-live').click(function () {
                        var url = '<?=sprintf(Yii::$app->params['ccliveUrl'],$cclive[0]['id'],CCliveRetrieverProcess::userid)?>';
                        window.open(url);
                    });
                }
            }
        });
        function liveUrl(roomid,name,timeEnd,that) {
            $(that).parent().find('.item').removeClass('active');
            $(that).addClass('active');
            //直播切换
            $('#MainDPlayer').html('<iframe src="<?=Url::to("live/video.html#roomid=")?>'+roomid+'" frameborder="0"  name="myFrameName" scrolling="yes" class="x-iframe" style="height: 100%;width: 100%"></iframe>');

            $('.blur-shadow').find('.tip').css('display','block');
            $('.blur-shadow').find('.title').css('display','block');
            $('.blur-shadow.active').css('visibility','visible');
            $('.blur-shadow').find('.title').html(name);
            $('.blur-shadow-live').css('display','none');
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
                $('.blur-shadow-live').css('display','block');
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
        function jumpUrl(url) {
            location.href = url;
        }
        function optionInstructor(id) {
            location.href = 'index.php?r=wap/site/instructorinfo&id='+id;
        }
    </script>
<?php
$this->endContent();
?>