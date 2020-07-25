<?php
use app\assets\AppAsset;
use yii\helpers\Url;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>
<style>
    h1{
        font-size: 20px;padding: 1rem;font-weight: 900;
    }
    h5{
        font-size: 14px;padding: 1rem;
    }
</style>
<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">学生详情</a>
      </span>
</div>
<div class="x-body">
    <h1>基础信息</h1>
    <?php if(!empty($userBaseInfo)){?>
        <table class="layui-table">
            <thead>
            <th>姓名</th>
            <th>身份证号</th>
            <th>邮箱</th>
            <th>手机号</th>
            <th>默认密码</th>
            </thead>
            <tbody>
            <tr>
                <td><?=$userBaseInfo['sNick']?></td>
                <td><?=$userBaseInfo['idcard']?></td>
                <td><?=$userBaseInfo['sMail']?></td>
                <td><?=$userBaseInfo['sPhone']?></td>
                <td><?=$userBaseInfo['sPassWord']?></td>
            </tr>

            </tbody>
        </table>
        <h1>作品展示</h1>
        <?php foreach($userBaseInfo["studentopus"] as $k => $r){?>
            <table class="layui-table" style="width: 50%">
                <tbody>
                <tr>
                    <td style="width: 20%">
                        <div class="layui-container" style="width: 100%">
                            <div class="layui-row layui-col-space15 margin15">
                                <section class="layui-card">
                                    <div class="layui-card-body">
                                        <div class="sOpusvideoUrl" id="sOpusvideoUrl<?=$k?>" data-url="<?=Yii::$app->params['imagePath'].$r['sOpusvideoUrl']?>" style="width: 100%;"></div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </td>
                    <td style="width: 30%;text-align:left;vertical-align:top">
                        <p style="font-size: 14px;letter-spacing:2px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$r['sContent']?></p>
                    </td>
                </tr>
                </tbody>
            </table>
        <?php }?>
        <hr>
        <table class="layui-table" style="width: 50%">
            <head>
                <tr><th>辅导员背书</th><th>同学背书</th><th>课堂笔记</th></tr>
            </head>
            <tbody>
            <tr>
                <td><a href="<?=Yii::$app->params['imagePath'].$userBaseInfo['studentprofile']['sInstructorEndorsementImg']?>" target="_blank"><img src="<?=Yii::$app->params['imagePath'].$userBaseInfo['studentprofile']['sInstructorEndorsementImg']?>" alt=""></a></td>
                <td><a href="<?=Yii::$app->params['imagePath'].$userBaseInfo['studentprofile']['sStudentEndorsementImg']?>" target="_blank"><img src="<?=Yii::$app->params['imagePath'].$userBaseInfo['studentprofile']['sStudentEndorsementImg']?>" alt=""></a></td>
                <td><a href="<?=Yii::$app->params['imagePath'].$userBaseInfo['studentprofile']['sClassNotesImg']?>" target="_blank"><img src="<?=Yii::$app->params['imagePath'].$userBaseInfo['studentprofile']['sClassNotesImg']?>" alt=""></a></td>
            </tr>
            </tbody>
        </table>
        <hr>
        <h1>培训视频</h1>
        <table class="layui-table" style="width: 50%">
            <tbody>
            <tr>
                <?php foreach($userBaseInfo["trainingvideo"] as $k1 => $r1){?>
                    <td style="width: 20%">
                        <table class="layui-table">
                            <tbody>
                            <tr><td>
                                    <div class="layui-container" style="width: 100%">
                                        <div class="layui-row layui-col-space15 margin15">
                                            <section class="layui-card">
                                                <div class="layui-card-body">
                                                    <div class="sTrainingvideoUrl" id="sTrainingvideoUrl<?=$k1?>" data-url="<?=Yii::$app->params['imagePath'].$r1['sTrainingvideoUrl']?>" style="width: 100%;"></div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </td></tr>
                            <tr>
                                <td>
                                    <h1><?=$r1['sChapterName']?></h1>
                                    <h5><?=$r1['author']?> <?=$r1['time']?>分钟</h5>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                <?php }?>
            </tr>
            </tbody>
        </table>
        <hr>
        <h1>答辩视频</h1>
        <table class="layui-table" style="width: 50%">
            <tbody>
            <tr>
                <?php foreach($userBaseInfo["defensevideo"] as $k2 => $r2){?>
                    <td style="width: 20%">
                        <table class="layui-table">
                            <tbody>
                            <tr><td>
                                    <div class="layui-container" style="width: 100%">
                                        <div class="layui-row layui-col-space15 margin15">
                                            <section class="layui-card">
                                                <div class="layui-card-body">
                                                    <div class="sDefensevideoUrl" id="sDefensevideoUrl<?=$k2?>" data-url="<?=Yii::$app->params['imagePath'].$r2['sDefensevideoUrl']?>" style="width: 100%;"></div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </td></tr>
                            <tr>
                                <td>
                                    <h1><?=$r2['sProblemName']?></h1>
                                    <h5><?=$r2['author']?> <?=$r2['time']?>分钟</h5>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                <?php }?>
            </tr>
            </tbody>
        </table>
        <hr>
        <h1>实操视频</h1>
        <table class="layui-table" style="width: 50%">
            <tbody>
            <tr>
                <?php foreach($userBaseInfo["practicevideo"] as $k2 => $r2){?>

                    <td style="width: 20%">
                        <table class="layui-table">
                            <tbody>
                            <tr><td>
                                    <div class="layui-container" style="width: 100%">
                                        <div class="layui-row layui-col-space15 margin15">
                                            <section class="layui-card">
                                                <div class="layui-card-body">
                                                    <div class="sPracticevideoUrl" id="sPracticevideoUrl<?=$k2?>" data-url="<?=Yii::$app->params['imagePath'].$r2['sPracticevideoUrl']?>" style="width: 100%;"></div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </td></tr>
                            <tr>
                                <td>
                                    <h1><?=$r2['sProblemName']?></h1>
                                    <h5><?=$r2['author']?> <?=$r2['time']?>分钟</h5>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                <?php }?>
            </tr>
            </tbody>
        </table>
        <hr>
        <h1>证书信息</h1>
        <table class="layui-table">
            <thead>
            <th>证书编号</th>
            <th>获得时间</th>
            <th>我的证书</th>
            </thead>
            <tbody>
            <tr>
                <?php foreach($userBaseInfo['studentcertificate'] as $k3 => $r3){?>
                    <td><?=$r3['sCertificateNum']?></td>
                    <td><?=$r3['dGetDate']?></td>
                    <td><a href="<?=Yii::$app->params['imagePath'].$r3['sCertificateImg']?>" target="_blank"><?=$r3['sCertificateImg']?></a></td>
                <?php }?>
            </tr>
            </tbody>
        </table>
        <h1>学习视频</h1>
        <table class="layui-table" style="width: 50%">
            <tbody>
            <tr>
                <?php foreach($userBaseInfo["video"] as $k4 => $r4){?>

                    <td style="width: 20%">
                        <table class="layui-table">
                            <tbody>
                            <tr><td>
                                    <div class="layui-container" style="width: 100%">
                                        <div class="layui-row layui-col-space15 margin15">
                                            <section class="layui-card">
                                                <div class="layui-card-body">
                                                    <div class="sVideoUrl" id="sVideoUrl<?=$k4?>" data-url="<?=Yii::$app->params['imagePath'].$r4['sVideoUrl']?>" style="width: 100%;"></div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </td></tr>
                            <tr>
                                <td>
                                    <h1><?=$r4['sProblemName']?></h1>、
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                <?php }?>
            </tr>
            </tbody>
        </table>
    <?php }?>
</div>
</body>
<script type="text/javascript">
    layui.config({
        base: '/lib/'
    }).extend({
        ckplayer: 'ckplayer/ckplayer'
    }).use(['jquery', 'ckplayer'], function() {
        var $ = layui.$,
            ckplayer = layui.ckplayer;

        for(var i = 0;i < $(".sOpusvideoUrl").length; i++)
        {
            var vUrl = $('.sOpusvideoUrl').eq(i).data('url'),
                videoObject = {
                    container: "#sOpusvideoUrl"+i,
                    loop: true,
                    autoplay: false,
                    video: [
                        [vUrl, 'video/mp4']
                    ]
                };
            var player = new ckplayer(videoObject);
        }

        for(var i = 0;i < $(".sTrainingvideoUrl").length; i++)
        {
            var vUrl = $('.sTrainingvideoUrl').eq(i).data('url'),
                videoObject = {
                    container: "#sTrainingvideoUrl"+i,
                    loop: true,
                    autoplay: false,
                    video: [
                        [vUrl, 'video/mp4']
                    ]
                };
            var player = new ckplayer(videoObject);
        }

        for(var i = 0;i < $(".sDefensevideoUrl").length; i++)
        {
            var vUrl = $('.sDefensevideoUrl').eq(i).data('url'),
                videoObject = {
                    container: "#sDefensevideoUrl"+i,
                    loop: true,
                    autoplay: false,
                    video: [
                        [vUrl, 'video/mp4']
                    ]
                };
            var player = new ckplayer(videoObject);
        }

        for(var i = 0;i < $(".sPracticevideoUrl").length; i++)
        {
            var vUrl = $('.sPracticevideoUrl').eq(i).data('url'),
                videoObject = {
                    container: "#sPracticevideoUrl"+i,
                    loop: true,
                    autoplay: false,
                    video: [
                        [vUrl, 'video/mp4']
                    ]
                };
            var player = new ckplayer(videoObject);
        }
        for(var i = 0;i < $(".sVideoUrl").length; i++)
        {
            var vUrl = $('.sVideoUrl').eq(i).data('url'),
                videoObject = {
                    container: "#sVideoUrl"+i,
                    loop: true,
                    autoplay: false,
                    video: [
                        [vUrl, 'video/mp4']
                    ]
                };
            var player = new ckplayer(videoObject);
        }
    });
</script>
<?php
$this->endContent();
?>
