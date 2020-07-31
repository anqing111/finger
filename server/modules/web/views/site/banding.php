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
                    <input type="hidden" name="iUserID" value="<?=$iUserID?>">
                    <input type="hidden" name="sMail" value="<?=$sMail?>">
                    <div class="input-box flex-box">
                        <img src="<?=Url::to('images/phone.png')?>" alt="" style="width:13px;height: 21px;margin-top: 16px; margin-left: 11px;margin-right: 16px">
                        <input type="text" name="sPhone" placeholder="手机号" class="filler">
                    </div>
                    <!-- 错误提示 -->
                    <div class="errorPrompt" style="display:none ;">
                        <span class="font_family">&#xe635;</span>
                        <span class="eptitle"></span>
                    </div>
                    <div class="msg-box flex-box">
                        <div class="input-box flex-box">
                            <img src="<?=Url::to('images/code.png')?>" alt="" style="width:20px;height: 17px;margin-top: 18px; margin-left: 11px">
                            <input type="text" name="code" placeholder="请输入验证码" class="filler">
                        </div>
                        <button class="msg" id="time">获取验证码</button>
                    </div>
                    <!-- 错误提示 -->
                    <div class="errorPrompt" style="display:none ;">
                        <span class="font_family">&#xe635;</span>
                        <span class="eptitle"></span>
                    </div>
                    <button type="button" class="commit banding" style="cursor:pointer">立即绑定</button>
                    <button type="button" class="commit jump" style="cursor:pointer">跳过</button>
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
        var source = "registermessage";
        var key = '<?=Yii::$app->params['KEY']?>';

        $(function () {
            gettime();
        });

        //获取短信验证码
        $("#time").click(function(){

            var account = $("input[name=sPhone]").val();
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

        $('.banding').click(function ()
        {
            $('.errorPrompt').css('display','none');
            $('.errorPrompt').css('margin-top','-24px');
            var sPhone = $('input[name=sPhone]').val();
            var code = $('input[name=code]').val();
            var sMail = $('input[name=sMail]').val();
            var iUserID = $('input[name=iUserID]').val();
            var key = '<?=Yii::$app->params['KEY']?>';

            if(sPhone.length == 0){
                $("input[name=sPhone]").parent().next(".errorPrompt").css("display","block");
                $("input[name=sPhone]").parent().next('.errorPrompt').find(".eptitle").html("&nbsp;请输入手机号");
                return false;
            }

            var data = validatemobile(sPhone);
            if(data["code"] != 0)
            {
                $("input[name=sPhone]").parent().next(".errorPrompt").css("display","block");
                $("input[name=sPhone]").parent().next('.errorPrompt').find(".eptitle").html("&nbsp;"+data["msg"]);
                return false;
            }

            if(code.length == 0){
                $("input[name=code]").parent().parent().next(".errorPrompt").css("display","block");
                $("input[name=code]").parent().parent().next('.errorPrompt').find(".eptitle").html("&nbsp;请输入短信验证码");
                return false;
            }

            var arrPara = ['merCode','timestamp','client','sPhone','code','source','iUserID','sMail'];
            var jsonData = {
                merCode: '<?=Yii::$app->params['MERCODE']?>',
                timestamp: Date.now(),
                client:'web',
                sPhone:sPhone,
                code:code,
                iUserID:iUserID,
                sMail:sMail,
                source:source
            };
            arrPara = arrPara.sort();
            var str = "";
            for(var i = 0; i < arrPara.length; i++) {
                str += arrPara[i]+"="+jsonData[arrPara[i]]+"&";
            }
            str += 'key='+key;
            jsonData['signMsg'] = md5(str);
            getAJAX(jsonData,banding,'site/banding');

        });

        function banding(jsonData)
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

        $('.jump').click(function () {
            location.href = 'index.php?r=web/site/success';
        });

    </script>
<?php
$this->endContent();
?>