<?php
use app\assets\WapAsset;
use yii\helpers\Url;
WapAsset::register($this);
$this->beginContent('@views/layouts/wap.php');
?>
<?=\app\modules\wap\model\process\PublicProcess::TopWeb()?>
<style>
    .error{
        margin-top: 5rem;
        line-height: 3.125rem;
    }
    .fail{
        position: relative;
        top:18.3125rem;
        font-size: 2.125rem;
    }
    .container.login .content-box .filler{
        position: relative;
        display: flex;
        flex-wrap: wrap;justify-content: center;
    }
    .container.login .content-box .filler .success{
        position: relative;
        display: flex;
        flex-wrap: wrap;justify-content: center;
    }
    .container.login .content-box .filler .success img{
        width: 34.375rem;
        height: 13.8125rem;
        margin-top: 26.5rem;
        margin-bottom: 6.25rem;
    }
    .container.login .content-box .filler .success p{
        color: #676562;
        text-align: center;
    }
</style>
<div class="container login" style="background-image:url(<?=Yii::$app->params['imagePath'].'/wap/images/error.png'?>);height: 78.25rem ">
    <div class="container login">
        <div class="content-box flex-box">
            <div class="filler">
                <div class="fail">
                    <p style="font-family: '微软雅黑', Arial;color: #000;font-weight: bold">抱 歉， 您 访 问 的 资 源 不 存 在 !</p>
                </div>
                <div class="success">
                    <img src="<?=Yii::$app->params['imagePath'].'/wap/images/404.png'?>" alt="" class="lable-img" style="background: rgba(0,0,0,0);">
                    <div class="error">
                        <p style="font-family: '微软雅黑', Arial;font-size: 2rem;color: #000;font-weight: bold">不要着急，让我们去 <a href="index.php?r=wap/site" style="color: #FF9D2A">首页</a> 看看吧</p>
                        <p style="font-family: '微软雅黑', Arial;font-size: 1.75rem;color: #000;font-weight: bold">联系电话：400-000-0000</p>
                        <p style="font-family: '微软雅黑', Arial;font-size: 1.75rem;color: #000;font-weight: bold">联系邮箱：13393072310@163.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->endContent();
?>
