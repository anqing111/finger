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
        <a href="">学生档案信息详情</a>
      </span>
</div>
<div class="x-body">
    <h1>作品展示</h1>
    <table class="layui-table" style="width: 50%">
        <tbody>
        <tr>
            <td style="width: 20%">
                <div class="layui-container" style="width: 100%">
                    <div class="layui-row layui-col-space15 margin15">
                        <section class="layui-card">
                            <div class="layui-card-body">
                                <div class="sOpusvideoUrl" id="sOpusvideoUrl" data-url="<?=Yii::$app->params['imagePath'].$studentopus->sOpusvideoUrl?>" style="width: 100%;"></div>
                            </div>
                        </section>
                    </div>
                </div>
            </td>
            <td style="width: 30%;text-align:left;vertical-align:top">
                <p style="font-size: 14px;letter-spacing:2px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$studentopus->sContent?></p>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
<script>
    layui.config({
        base: '/lib/'
    }).extend({
        ckplayer: 'ckplayer/ckplayer'
    }).use(['jquery', 'ckplayer','form'], function() {
        var $ = layui.$,
            ckplayer = layui.ckplayer

        var vUrl = $('.sOpusvideoUrl').data('url'),
            videoObject = {
                container: "#sOpusvideoUrl",
                loop: true,
                autoplay: false,
                video: [
                    [vUrl, 'video/mp4']
                ]
            };
        var player = new ckplayer(videoObject);

    });
</script>
<?php
$this->endContent();
?>
