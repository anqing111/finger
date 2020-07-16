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
                        <img src="<?=Url::to('images/user.png')?>" alt="">
                        <input type="text" name="sNick" placeholder="用户名" class="filler">
                    </div>
                    <!-- 错误提示 -->
                    <div class="errorPrompt" style="display:none ;">
                        <span class="font_family">&#xe635;</span>
                        <span class="eptitle"></span>
                    </div>
                    <div class="input-box flex-box">
                        <img src="<?=Url::to('images/mail.png')?>" alt="">
                        <input type="text" name="sMail" placeholder="邮箱" class="filler">
                    </div>
                    <!-- 错误提示 -->
                    <div class="errorPrompt" style="display:none ;">
                        <span class="font_family">&#xe635;</span>
                        <span class="eptitle"></span>
                    </div>
                    <div class="msg-box flex-box">
                        <div class="input-box flex-box">
                            <img src="<?=Url::to('images/code.png')?>" alt="">
                            <input type="text" name="code" placeholder="邮箱验证码" class="filler">
                        </div>
                        <button class="msg" id="time" style="cursor:pointer">获取验证码</button>
                    </div>
                    <!-- 错误提示 -->
                    <div class="errorPrompt" style="display:none ;">
                        <span class="font_family">&#xe635;</span>
                        <span class="eptitle"></span>
                    </div>
                    <div class="input-box flex-box">
                        <img src="<?=Url::to('images/password.png')?>" alt="">
                        <input type="password" name="sPassWord" placeholder="请输入密码" class="filler">
                    </div>
                    <!-- 错误提示 -->
                    <div class="errorPrompt" style="display:none ;">
                        <span class="font_family">&#xe635;</span>
                        <span class="eptitle"></span>
                    </div>
                    <button type="button" class="commit" style="cursor:pointer">下一步</button>
                    <div class="etc-box flex-box">
                        <div class="filler"></div>
                        <span class="check-label">已有账号？</span>
                        <span class="options"><a href="index.php?r=web/site/login">立即登录</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="white">
        <?=\app\modules\web\model\process\PublicProcess::MiddleWeb()?>
    </footer>
    <script>

        var interval;
        var jsstep;
        var source = "registermail";
        var key = '<?=Yii::$app->params['KEY']?>';

        $(function () {
            gettime();
        });

        //获取短信验证码
        $("#time").click(function(){

            var account = $("input[name=sMail]").val();
            var arrPara = ['merCode','timestamp','client','source','account'];
            var jsonData = {
                merCode: '<?=Yii::$app->params['MERCODE']?>',
                timestamp: Date.now(),
                source:source,
                client:'web',
                account:account
            };
            arrPara = arrPara.sort();
            var str = "";
            for(var i = 0; i < arrPara.length; i++) {
                str += arrPara[i]+"="+jsonData[arrPara[i]]+"&";
            }
            str += 'key='+key;

            jsonData['signMsg'] = md5(str);
            getAJAX(jsonData,getCode,'site/sendcode');
        });

        function getCode(jsonData){

            layui.use('layer', function() {
                var layer = layui.layer;

                if(jsonData.code == 0)
                {
                    layer.msg('验证码发送成功', {icon: 6,time:2000});
                    gettime();
                }else{
                    layer.alert(jsonData.msg, {icon: 1});
                }
            });
        }

        function times(jsonData) {
            jsstep = jsonData.data.time;
            if(jsstep>0){
                updateIntervalTime();
            }else{
                $("#time").removeAttr("disabled"); //移除disabled属性
                $('#time').text('获取验证码');
            }
        }
        function updateIntervalTime()
        {
            interval=setInterval(getRTime,1000);//显示倒计时
        }
        function getRTime(){
            if(jsstep<=1){
                $("#time").removeAttr("disabled"); //移除disabled属性
                $('#time').text('获取验证码');
                window.clearInterval(interval);
                return;
            }else{
                if (jsstep<=1){
                    $("#time").removeAttr("disabled"); //移除disabled属性
                    $('#time').text('获取验证码');
                    window.clearInterval(interval);
                    return;
                }
            }
            jsstep=jsstep-1;
            $("#time").attr("disabled", true); //设置disabled属性
            $('#time').text('重新发送' + jsstep);
        }

        function gettime()
        {
            //获取短信验证码时间
            var arrPara = ['merCode','timestamp','client','source'];
            var jsonData = {
                merCode: '<?=Yii::$app->params['MERCODE']?>',
                timestamp: Date.now(),
                source:source,
                client:'web'
            };
            arrPara = arrPara.sort();
            var str = "";
            for(var i = 0; i < arrPara.length; i++) {
                str += arrPara[i]+"="+jsonData[arrPara[i]]+"&";
            }
            str += 'key='+key;

            jsonData['signMsg'] = md5(str);
            getAJAX(jsonData,times,'site/getmesvalidate');
        }

        $('.commit').click(function ()
        {
            $('.errorPrompt').css('display','none');
            $('.errorPrompt').css('margin-top','-24px');
            var sNick = $('input[name=sNick]').val();
            var sMail = $('input[name=sMail]').val();
            var code = $('input[name=code]').val();
            var sPassWord = $('input[name=sPassWord]').val();
            var key = '<?=Yii::$app->params['KEY']?>';

            if(sNick.length == 0){
                $("input[name=sNick]").parent().next('.errorPrompt').css("display","block");
                $("input[name=sNick]").parent().next('.errorPrompt').find(".eptitle").html("&nbsp;用户名不得为空");
                return false;
            }

            if(sMail.length == 0){
                $("input[name=sMail]").parent().next(".errorPrompt").css("display","block");
                $("input[name=sMail]").parent().next('.errorPrompt').find(".eptitle").html("&nbsp;请输入邮箱");
                return false;
            }

            var data = validateemail(sMail);
            if(data["code"] != 0)
            {
                $("input[name=sMail]").parent().next(".errorPrompt").css("display","block");
                $("input[name=sMail]").parent().next('.errorPrompt').find(".eptitle").html("&nbsp;"+data["msg"]);
                return false;
            }

            if(code.length == 0){
                $("input[name=code]").parent().parent().next(".errorPrompt").css("display","block");
                $("input[name=code]").parent().parent().next('.errorPrompt').find(".eptitle").html("&nbsp;请输入邮箱验证码");
                return false;
            }

            if(sPassWord.length == 0){
                $("input[name=sPassWord]").parent().next(".errorPrompt").css("display","block");
                $("input[name=sPassWord]").parent().next('.errorPrompt').find(".eptitle").html("&nbsp;请输入6-15位数字或字母密码");
                return false;
            }

            var data2 = validatepass(sPassWord);
            if(data2["code"] != 0)
            {
                $("input[name=sPassWord]").parent().next(".errorPrompt").css("display","block");
                $("input[name=sPassWord]").parent().next('.errorPrompt').find(".eptitle").html("&nbsp;"+data2["msg"]);
                return false;
            }

            var arrPara = ['merCode','timestamp','client','sNick','sMail','sPassWord','code','source'];
            var jsonData = {
                merCode: '<?=Yii::$app->params['MERCODE']?>',
                timestamp: Date.now(),
                client:'web',
                sNick:sNick,
                sMail:sMail,
                sPassWord:sPassWord,
                code:code,
                source:source,
            };
            arrPara = arrPara.sort();
            var str = "";
            for(var i = 0; i < arrPara.length; i++) {
                str += arrPara[i]+"="+jsonData[arrPara[i]]+"&";
            }
            str += 'key='+key;
            jsonData['signMsg'] = md5(str);
            getAJAX(jsonData,register,'site/register');

        });

        function register(jsonData)
        {
            layui.use('layer', function() {
                var layer = layui.layer;

                if(jsonData.code == 0)
                {
                    location.href = jsonData.data.url;
                }else{
                    layer.alert(jsonData.msg, {icon: 1});
                }
            });
        }
    </script>
<?php
$this->endContent();
?>