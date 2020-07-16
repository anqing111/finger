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
</style>
<div class="container login" style="background-image:url(<?=Url::to('images/error.png')?>) ">
    <div class="container login">
        <div class="bg"></div>
        <div class="content-box flex-box">
            <div class="filler">
                <div class="fail">
                    <p style="font-family: '微软雅黑', Arial;font-size: 22px;color: #000;font-weight: bold">抱 歉， 您 访 问 的 资 源 不 存 在 !</p>
                </div>
                <div class="success">
                    <img src="<?=Url::to('images/404.png')?>" alt="" class="lable-img" style="background: rgba(0,0,0,0);">
                    <div class="error">
                        <p style="font-family: '微软雅黑', Arial;font-size: 16px;color: #000;font-weight: bold">不要着急，让我们去 <a href="index.php?r=web/site" style="color: #FF9D2A">首页</a> 看看吧</p>
                        <p style="font-family: '微软雅黑', Arial;font-size: 14px;color: #000;font-weight: bold">联系电话：400-000-0000</p>
                        <p style="font-family: '微软雅黑', Arial;font-size: 14px;color: #000;font-weight: bold">联系邮箱：13393072310@163.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->endContent();
?>
