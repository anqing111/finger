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
            <img src="<?=Url::to('images/login.png')?>" alt="" class="lable-img">
        </div>
        <div class="form">
            <div class="content">
                <div class="input-box flex-box">
                    <img src="<?=Url::to('images/mail.png')?>" alt="">
                    <input type="text" name="account" placeholder="邮箱/手机号" class="filler">
                </div>
                <div class="input-box flex-box">
                    <img src="<?=Url::to('images/password.png')?>" alt="">
                    <input type="password" name="sPassWord" placeholder="请输入密码" class="filler">
                </div>
                <!-- 错误提示 -->
                <div class="errorPrompt" style="display: none;">
                    <span class="font_family">&#xe635;</span>
                    <span class="eptitle">&nbsp;请输入正确的手机号/密码</span>
                </div>
                <div class="etc-box flex-box">
<!--                    <input type="checkbox" name="auto">-->
<!--                    <span class="check-label">下次自动登录</span>-->
                    <div class="filler"></div>
                    <span class="options"><a href="index.php?r=web/site/forgetmail">忘记密码</a> | <a href="index.php?r=web/site/register">立即注册</a></span>
                </div>
                <button type="button" class="commit" style="cursor:pointer">登录</button>
            </div>
        </div>
    </div>
</div>
<footer class="white">
    <?=\app\modules\web\model\process\PublicProcess::MiddleWeb()?>
</footer>
<script>
    $(function()
    {
        $('.commit').click(function(){
            var account = $('input[name=account]').val();
            var sPassWord = $('input[name=sPassWord]').val();
            var key = '<?=Yii::$app->params['KEY']?>';

            if(account.length == 0 || sPassWord.length == 0){
                $(".errorPrompt").css("display","block");
                $(".errorPrompt").find(".eptitle").html("&nbsp;账号或密码不能为空");
                return false;
            }

            var arrPara = ['merCode','timestamp','client','account','sPassWord'];
            var jsonData = {
                merCode: '<?=Yii::$app->params['MERCODE']?>',
                timestamp: Date.now(),
                client:'web',
                account:account,
                sPassWord:sPassWord
            };
            arrPara = arrPara.sort();
            var str = "";
            for(var i = 0; i < arrPara.length; i++) {
                str += arrPara[i]+"="+jsonData[arrPara[i]]+"&";
            }
            str += 'key='+key;
            jsonData['signMsg'] = md5(str);
            getAJAX(jsonData,userLogin,'site/login');
        });
    });

    function userLogin(jsonStr)
    {
        if(jsonStr.code!=0)
        {
            $(".errorPrompt").css("display","block");
            if(jsonStr.msg == undefined){

                $(".errorPrompt").find(".eptitle").html("&nbsp;网络异常");
            }else{

                $(".errorPrompt").find(".eptitle").html("&nbsp;"+jsonStr.msg);
            }

            return false;
        }

        location.href= 'index.php?r=web/'+jsonStr.data.url;
    }

    function forget(){
        location.href='index.php?r=web/User/Forget';
    }
</script>

<?php
$this->endContent();
?>
