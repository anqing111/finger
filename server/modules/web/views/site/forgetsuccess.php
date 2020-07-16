<!DOCTYPE html>
<?php
use app\assets\WebAsset;
use yii\helpers\Url;
WebAsset::register($this);
$this->beginContent('@views/layouts/web.php');
?>
<?=\app\modules\web\model\process\PublicProcess::TopWebL()?>
<div class="container login">
    <div class="bg"></div>
    <div class="content-box flex-box">
        <div class="filler">
            <div class="success">
                <img src="<?=Url::to('images/repassword-success.png')?>" alt="" class="lable-img">
                <p style="margin-top: 520px">恭喜您，找回密码成功！<span id="time" style="color: red"></span></p>
            </div>
        </div>
    </div>
</div>
<footer class="white">
    <?=\app\modules\web\model\process\PublicProcess::MiddleWeb()?>
</footer>
<script>
    var i=3;
    $(function(){
        setTimeout(function(){
            window.location.href='index.php?r=web/site';
        },3000);//3秒后返回首页
        after();
    });
    //自动刷新页面上的时间
    function after(){
        $("#time").empty().append(i);
        i=i-1;
        setTimeout(function(){
            after();
        },1000);
    }
</script>
<?php
$this->endContent();
?>