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
</style>
<?=\app\modules\web\model\process\PublicProcess::TopWeb()?>
<div class="container index">
    <div class="specialist">
        <div class="specialist-bg" style="background-color: #FDF7F2; /* 浏览器不支持时显示 */
            /* Safari */
            background: -webkit-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
            /* Opera */
            background: -o-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
            /* Firefox */
            background: -moz-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
            /* 标准的语法, 放在最后 */
            background: linear-gradient(#FFFDFA 30%,  #FFFEFF 75%);
            ">
            <div class="container">
                <div class="section-title">
                    <div class="certificate-title">我的证书</div>
                </div>
                <hr>
                <div class="content-box certificate-info">
                    <div class="item flex-box" style="width: 800px">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="" style="width:256px;margin-right: 80px;">
                        <div class="detail filler">
                            <div class="name">人力资源管理师证书</div>
                            <div class="tip2">
                                4A广告公司首席设计师、艺术指导、资深业界专家、品牌视觉设计师、Adobe全国优秀讲师、文化部中文发广告公司设计总监。代表作品《郑渊洁系列图书》整体形象装帧设计、外语教学与研究出版社，高等教育出版社图书出版设计、文化部月刊。曾服务于外研社、高等教育出版社、中国建筑工业出版社、学苑出版社、中国时代经济出版社、知识产权出版社等。
                                参与项目：联想集团3C官网，北京市中小学学籍管理云平台，北京市教育考试院数据资源管理系统，北京警察学院政审管理系统，北京数字学校综合素质评价服务平台，北京语言大学雅思培训中心官网，雏鹰建言网，北京求实职业学校招生就业网，北京考试APP等。
                                大唐高鸿产品经理、系统运营总监；B2B电商平台联合创始人。作品包括PICC人保财险、中国人寿、招商银行、中国联通、神州数码、解放、北汽、奔驰、联想商城、中国鞋服行业协会等项目。目前有十余款APP在线上运营，专注用户体验和交互设计。
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container2">
                <div class="section-title">
                    <div class="certificate-video" style="margin-bottom: 20px">学习视频</div>
                </div>
                <hr>
                <div class="content-box" style="margin-top: 20px">
                    <div class="flex-box certificate-video-list">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                    </div>
                    <div class="flex-box certificate-video-list">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                    </div>
                    <div class="flex-box certificate-video-list">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                    </div>
                    <div class="flex-box certificate-video-list">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                    </div>
                    <div class="flex-box certificate-video-list">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                    </div>
                    <div class="flex-box certificate-video-list">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                    </div>
                    <div class="flex-box certificate-video-list">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                    </div>
                    <div class="flex-box certificate-video-list">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                    </div>
                    <div class="flex-box certificate-video-list">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                    </div>
                    <div class="flex-box certificate-video-list">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                    </div>
                    <div class="flex-box certificate-video-list">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
                    </div>
                    <div class="flex-box certificate-video-list">
                        <img src="https://f.cdn.xsteach.cn/uploaded/c1/85/3f/c1853f5f3ce63f633710a0eac17e5de8001.jpg" alt="">
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
    var height=$(".certificate-info .tip2").height()<256?256:$(".certificate-info .tip2").height();
    if($('.container .certificate-info').length){
        $('.container .certificate-info').css('height',height+100+'px')
    }

    $('.container2').css('top',height+100+'px');

    $('.certificate-video-list').each(function (ids, items) {
        if((ids+1) % 4 == 0 && ids > 0)
        {
            $(this).css('margin-right','0');
        }
    });

    var windowHeight = $('.specialist-bg').height() + $('.container2').height();
    windowHeight=windowHeight<800?800:windowHeight;

    $('.container .specialist').css('height',windowHeight-200+'px');

</script>
<?php
$this->endContent();
?>
