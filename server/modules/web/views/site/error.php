<?php
use app\assets\WebAsset;
use yii\helpers\Url;
WebAsset::register($this);
$this->beginContent('@views/layouts/web.php');
?>
<?=\app\modules\web\model\process\PublicProcess::TopWebL()?>
<style>
    .error{
        margin-top: 400px;
        line-height: 25px;
    }
    .fail{
        position: absolute;
        top: 20%;
        left: 51%;
        transform: translate(-50%,-50%);
    }
    .container.error-bg .bg{
        height: 300px;
        background-image: url('<?=Url::to('images/login-bg.png')?>');
        background-repeat: no-repeat;
        background-position: top;
        background-size: cover;
        position: absolute;
        bottom: 0;
        z-index: 0;
    }
    .container.error-bg .content-box{
        height: 100%;
    }
    .container.error-bg .content-box .filler .lable-img{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        width: 400px;
        background: rgba(0,0,0,0);
    }
    .container.error-bg .content-box .filler .success{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
    }
    .container.error-bg .content-box .filler .success img{
        width: 450px;
        margin-bottom: 50px;
    }
    .container.error-bg .content-box .filler .success p{
        color: #676562;
        font-size: 24px;
        text-align: center;
    }
    
</style>
<div class="container error-bg" style="background-image:url(<?=Url::to('images/error.png')?>);background-size: cover;width: auto;height: 717px;margin-bottom: -10px">
    <div class="bg"></div>
    <div class="content-box flex-box">
        <div class="filler">
            <div class="fail">
                <p style="font-family: '微软雅黑', Arial;font-size: 22px;color: #000;font-weight: bold">抱 歉， 您 访 问 的 资 源 不 存 在 !</p>
            </div>
            <div class="success">
                <img src="<?=Url::to('images/404.png')?>" alt="" class="lable-img" style="background: rgba(0,0,0,0);">
                <div class="error">
                    <p style="font-family: '微软雅黑', Arial;font-size: 16px;color: #000;font-weight: 400">不要着急，让我们去 <a href="index.php?r=web/site" style="color: #FF9D2A">首页</a> 看看吧</p>
                    <p style="font-family: '微软雅黑', Arial;font-size: 14px;color: #000;font-weight: 400;margin-top: 6px">联系电话：010-5367-0833</p>
                    <p style="font-family: '微软雅黑', Arial;font-size: 14px;color: #000;font-weight: 400;margin-top: 6px">联系邮箱：99171876@qq.com</p>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="white">
    <?=\app\modules\web\model\process\PublicProcess::MiddleWeb()?>
</footer>
<?php
$this->endContent();
?>
