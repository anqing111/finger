<?php
use app\assets\WapAsset;
use yii\helpers\Url;
WapAsset::register($this);
$this->beginContent('@views/layouts/wap.php');
?>
<?=\app\modules\wap\model\process\PublicProcess::TopWeb()?>
    <div class="container index">
        <div class="specialist">
            <div class="section-title">
                <div class="title">全部专家</div>
            </div>
            <hr style="height:1px;border:none;border-top:1px double rgba(222,230,236,1);">
            <div class="content-box">
                <a href="index.php?r=wap/site/instructorinfo&id=5">
                    <div class="item flex-box">
                        <img src="https://f.cdn.xsteach.cn/uploaded/08/16/a1/0816a17b060ef5187ba7ce233430d935001.jpg" alt="">
                        <div class="detail filler">
                            <div class="name">安庆</div>
                            <div class="time">3年从业经验</div>
                            <div class="tip">毕业后即就职于某某公司，曾多次获得某某奖，深入解答各种疑难问题，用最专业的教学，这里css控制4行多余省略号测试一下
                            </div>
                        </div>
                    </div>
                </a>
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
    </div>
    <footer>
        <?=\app\modules\wap\model\process\PublicProcess::MiddleWeb()?>
    </footer>
<?php
$this->endContent();
?>