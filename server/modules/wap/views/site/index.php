<?php
use app\assets\WapAsset;
use yii\helpers\Url;
WapAsset::register($this);
$this->beginContent('@views/layouts/wap.php');
?>
<?=\app\modules\wap\model\process\PublicProcess::TopWeb()?>
    <div class="container index">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide" style="background-image: url(<?=Yii::$app->params['imagePath']?>/wap/images/index-poster.png);"></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="player-box">
            <div class="player" id="MainDPlayer"></div>
            <div class="blur-shadow active">
                <div class="title">【日韩漫画/二次元绘画】vip学习体验教室</div>
                <div class="tip">直播已结束</div>
                <button>查看详情</button>
            </div>
            <div class="list">
                <div class="title">07月10日   星期五</div>
                <div class="content">
                    <div class="item flex-box active">
                        <img src="<?=Yii::$app->params['imagePath']?>/wap/images/player-list-icon.png" alt="" class="icon">
                        <div class="filler one-line">这是一门课程，很好的课程，快点开看看吧，一期看看，大家都看看，来学习没错的</div>
                        <span class="time">14:00</span>
                    </div>
                    <div class="item flex-box">
                        <img src="<?=Yii::$app->params['imagePath']?>/wap/images/player-list-icon.png" alt="" class="icon">
                        <div class="filler one-line">这是一门课程，很好的课程，快点开看看吧，一期看看，大家都看看，来学习没错的</div>
                        <span class="time">14:00</span>
                    </div>
                    <div class="item flex-box">
                        <img src="<?=Yii::$app->params['imagePath']?>/wap/images/player-list-icon.png" alt="" class="icon">
                        <div class="filler one-line">这是一门课程，很好的课程，快点开看看吧，一期看看，大家都看看，来学习没错的</div>
                        <span class="time">14:00</span>
                    </div>
                    <div class="item flex-box">
                        <img src="<?=Yii::$app->params['imagePath']?>/wap/images/player-list-icon.png" alt="" class="icon">
                        <div class="filler one-line">这是一门课程，很好的课程，快点开看看吧，一期看看，大家都看看，来学习没错的</div>
                        <span class="time">14:00</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="person-show">
            <div class="section-title">
                <div class="title">个人秀</div>
                <a href="" class="more">更多个人秀></a>
            </div>
            <div class="content-box">
                <div class="flex-box">
                    <img src="https://f.cdn.xsteach.cn/uploaded/0a/43/6f/0a436f829eb2c3831721754afb40522a001.jpg" alt="" class="img-title">
                    <div class="list">
                        <div class="title flex-box">
                            <span class="dot"></span>
                            <span class="text">技能展示</span>
                        </div>
                        <div class="content flex-box">
                            <div class="filler">
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
                            </div>
                            <div class="filler">
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
                <div class="group flex-box">
                    <img src="https://f.cdn.xsteach.cn/uploaded/97/12/27/9712275d06e29964b9464c50a29fa3d1001.jpg" class="item"></img>
                    <img src="https://f.cdn.xsteach.cn/uploaded/97/12/27/9712275d06e29964b9464c50a29fa3d1001.jpg" class="item"></img>
                    <img src="https://f.cdn.xsteach.cn/uploaded/97/12/27/9712275d06e29964b9464c50a29fa3d1001.jpg" class="item"></img>
                    <img src="https://f.cdn.xsteach.cn/uploaded/97/12/27/9712275d06e29964b9464c50a29fa3d1001.jpg" class="item"></img>
                    <img src="https://f.cdn.xsteach.cn/uploaded/97/12/27/9712275d06e29964b9464c50a29fa3d1001.jpg" class="item"></img>
                    <img src="https://f.cdn.xsteach.cn/uploaded/97/12/27/9712275d06e29964b9464c50a29fa3d1001.jpg" class="item"></img>
                </div>
            </div>
        </div>
        <div class="specialist">
            <div class="section-title">
                <div class="title">专家介绍</div>
                <a href="index.php?r=wap/site/instructor" class="more">更多专家></a>
            </div>
            <div class="content-box">
                <div class="item flex-box">
                    <img src="https://f.cdn.xsteach.cn/uploaded/08/16/a1/0816a17b060ef5187ba7ce233430d935001.jpg" alt="">
                    <div class="detail filler">
                        <div class="name">安庆</div>
                        <div class="time">3年从业经验</div>
                        <div class="tip">毕业后即就职于某某公司，曾多次获得某某奖，深入解答各种疑难问题，用最专业的教学，这里css控制4行多余省略号测试一下
                    </div>
                    </div>
                </div>
                <div class="item flex-box">
                    <img src="https://f.cdn.xsteach.cn/uploaded/08/16/a1/0816a17b060ef5187ba7ce233430d935001.jpg" alt="">
                    <div class="detail filler">
                        <div class="name">安庆</div>
                        <div class="time">3年从业经验</div>
                        <div class="tip">毕业后即就职于某某公司，曾多次获得某某奖，深入解答各种疑难问题，用最专业的教学，这里css控制4行多余省略号测试一下
                    </div>
                    </div>
                </div>
                <div class="item flex-box">
                    <img src="https://f.cdn.xsteach.cn/uploaded/08/16/a1/0816a17b060ef5187ba7ce233430d935001.jpg" alt="">
                    <div class="detail filler">
                        <div class="name">安庆</div>
                        <div class="time">3年从业经验</div>
                        <div class="tip">毕业后即就职于某某公司，曾多次获得某某奖，深入解答各种疑难问题，用最专业的教学，这里css控制4行多余省略号测试一下
                    </div>
                    </div>
                </div>
                <div class="item flex-box">
                    <img src="https://f.cdn.xsteach.cn/uploaded/08/16/a1/0816a17b060ef5187ba7ce233430d935001.jpg" alt="">
                    <div class="detail filler">
                        <div class="name">安庆</div>
                        <div class="time">3年从业经验</div>
                        <div class="tip">毕业后即就职于某某公司，曾多次获得某某奖，深入解答各种疑难问题，用最专业的教学，这里css控制4行多余省略号测试一下
                    </div>
                    </div>
                </div>
                <div class="item flex-box">
                    <img src="https://f.cdn.xsteach.cn/uploaded/08/16/a1/0816a17b060ef5187ba7ce233430d935001.jpg" alt="">
                    <div class="detail filler">
                        <div class="name">安庆</div>
                        <div class="time">3年从业经验</div>
                        <div class="tip">毕业后即就职于某某公司，曾多次获得某某奖，深入解答各种疑难问题，用最专业的教学，这里css控制4行多余省略号测试一下
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="articles">
            <div class="section-title">
                <div class="title">文章资讯</div>
                <a href="" class="more">技能薪酬类文章></a>
                <a href="" class="more">网站资讯类文章></a>
            </div>
            <div class="content-box">
                <div class="main-list">
                    <div class="item one-line active">1、自考新手指南，这7个问题你一定要看，教你</div>
                    <div class="item one-line">2、自考新手指南，这7个问题你一定要看，教你</div>
                    <div class="item one-line">3、自考新手指南，这7个问题你一定要看，教你</div>
                    <div class="item one-line">4、自考新手指南，这7个问题你一定要看，教你</div>
                    <div class="item one-line">5、自考新手指南，这7个问题你一定要看，教你</div>
                    <div class="item one-line">6、自考新手指南，这7个问题你一定要看，教你</div>
                    <div class="item one-line">7、自考新手指南，这7个问题你一定要看，教你</div>
                    <div class="item one-line">8、自考新手指南，这7个问题你一定要看，教你</div>
                    <div class="item one-line">9、自考新手指南，这7个问题你一定要看，教你</div>
                    <div class="item one-line">10、自考新手指南，这7个问题你一定要看，教你</div>
                </div>
                <div class="hot-list">
                    <div class="title flex-box">
                        <span class="dot"></span>
                        <span class="text">技能展示</span>
                    </div>
                    <div class="imgs flex-box">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                    </div>
                    <div class="list">
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
    <footer>
        <?=\app\modules\wap\model\process\PublicProcess::MiddleWeb()?>
    </footer>
    <section class="pop-dp-bg">
        <img src="" alt="" class="close">
        <div class="content" id="PopDPlayer">

        </div>
    </section>
<?php
$this->endContent();
?>