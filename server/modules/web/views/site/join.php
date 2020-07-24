<?php
use app\assets\WebAsset;
use yii\helpers\Url;
WebAsset::register($this);
$this->beginContent('@views/layouts/web.php');
?>
<?=\app\modules\web\model\process\PublicProcess::TopWeb()?>
<div class="top">
    <img src="<?=Url::to('images/join_bg.png')?>" alt="" style="background: rgba(0,0,0,0);">
</div>
<div class="container login">
    <div class="bg"></div>
    <div class="content-box flex-box">
        <div class="filler">
            <img src="<?=Url::to('images/join.png')?>" alt="" class="lable-img">
        </div>
        <div class="form">
            <div class="content">
                <div class="input-box flex-box">
                    <img src="<?=Url::to('images/company.png')?>" alt="">
                    <input type="text" name="sUnitName" placeholder="单位名称" class="filler">
                </div>
                <!-- 错误提示 -->
                <div class="errorPrompt" style="display: none;">
                    <span class="font_family">&#xe635;</span>
                    <span class="eptitle">&nbsp;</span>
                </div>
                <div class="input-box flex-box">
                    <img src="<?=Url::to('images/user.png')?>" alt="">
                    <input type="text" name="person" placeholder="负责人" class="filler">
                </div>
                <!-- 错误提示 -->
                <div class="errorPrompt" style="display: none;">
                    <span class="font_family">&#xe635;</span>
                    <span class="eptitle">&nbsp;</span>
                </div>
                <div class="input-box flex-box">
                    <img src="<?=Url::to('images/direction.png')?>" alt="">
                    <input type="text" name="direction" placeholder="加盟方向" class="filler">
                </div>
                <!-- 错误提示 -->
                <div class="errorPrompt" style="display: none;">
                    <span class="font_family">&#xe635;</span>
                    <span class="eptitle">&nbsp;</span>
                </div>
                <div class="input-box flex-box">
                    <img src="<?=Url::to('images/city.png')?>" alt="">
                    <select name="iCityID" id="iCityID" class="filler">
                        <option value="0">所属城市</option>
                        <?php foreach($city as $r){?>
                            <option value="<?=$r->iCityID?>"><?=$r->sCityName?></option>
                        <?php }?>
                    </select>
                </div>
                <!-- 错误提示 -->
                <div class="errorPrompt" style="display: none;">
                    <span class="font_family">&#xe635;</span>
                    <span class="eptitle">&nbsp;</span>
                </div>
                <div class="input-box flex-box">
                    <img src="<?=Url::to('images/phone.png')?>" alt="">
                    <input type="text" name="sPhone" placeholder="联系电话" class="filler">
                </div>
                <!-- 错误提示 -->
                <div class="errorPrompt" style="display: none;">
                    <span class="font_family">&#xe635;</span>
                    <span class="eptitle">&nbsp;</span>
                </div>
                <div class="input-box flex-box">
                    <img src="<?=Url::to('images/password.png')?>" alt="">
                    <input type="text" name="sMail" placeholder="邮箱" class="filler">
                </div>
                <!-- 错误提示 -->
                <div class="errorPrompt" style="display: none;">
                    <span class="font_family">&#xe635;</span>
                    <span class="eptitle">&nbsp;</span>
                </div>
                <button type="button" class="commit" style="cursor:pointer">提 交</button>
            </div>
        </div>
    </div>
</div>
<footer>
    <?=\app\modules\web\model\process\PublicProcess::MiddleWeb()?>
</footer>
<script>
    $(function()
    {
        $('.commit').click(function(){
            $('.errorPrompt').css('display','none');
            $('.errorPrompt').css('margin-top','-24px');
            var sUnitName = $('input[name=sUnitName]').val();
            var person = $('input[name=person]').val();
            var direction = $('input[name=direction]').val();
            var iCityID = $('#iCityID').val();
            var sMail = $('input[name=sMail]').val();
            var sPhone = $('input[name=sPhone]').val();
            var key = '<?=Yii::$app->params['KEY']?>';

            if(sUnitName.length == 0){
                $("input[name=sUnitName]").parent().next(".errorPrompt").css("display","block");
                $("input[name=sUnitName]").parent().next(".errorPrompt").find(".eptitle").html("&nbsp;单位名称不得为空");
                return false;
            }
            if(person.length == 0){
                $("input[name=person]").parent().next(".errorPrompt").css("display","block");
                $("input[name=person]").parent().next(".errorPrompt").find(".eptitle").html("&nbsp;负责人不得为空");
                return false;
            }
            if(direction.length == 0){
                $("input[name=direction]").parent().next(".errorPrompt").css("display","block");
                $("input[name=direction]").parent().next(".errorPrompt").find(".eptitle").html("&nbsp;加盟方向不得为空");
                return false;
            }
            if(iCityID == 0){
                $('#iCityID').parent().next(".errorPrompt").css("display","block");
                $('#iCityID').parent().next(".errorPrompt").find(".eptitle").html("&nbsp;请选择城市");
                return false;
            }
            var data2 = validatemobile(sPhone);
            if(data2["code"] != 0)
            {
                $("input[name=sPhone]").parent().next(".errorPrompt").css("display","block");
                $("input[name=sPhone]").parent().next('.errorPrompt').find(".eptitle").html("&nbsp;"+data2["msg"]);
                return false;
            }

            var data = validateemail(sMail);
            if(data["code"] != 0)
            {
                $("input[name=sMail]").parent().next(".errorPrompt").css("display","block");
                $("input[name=sMail]").parent().next('.errorPrompt').find(".eptitle").html("&nbsp;"+data["msg"]);
                return false;
            }

            var arrPara = ['merCode','timestamp','client','sUnitName','person','direction','iCityID','sMail','sPhone'];
            var jsonData = {
                merCode: '<?=Yii::$app->params['MERCODE']?>',
                timestamp: Date.now(),
                client:'web',
                sUnitName:sUnitName,
                person:person,
                direction:direction,
                iCityID:iCityID,
                sMail:sMail,
                sPhone:sPhone
            };
            arrPara = arrPara.sort();
            var str = "";
            for(var i = 0; i < arrPara.length; i++) {
                str += arrPara[i]+"="+jsonData[arrPara[i]]+"&";
            }
            str += 'key='+key;
            jsonData['signMsg'] = md5(str);
            getAJAX(jsonData,join,'site/join');
        });
    });

    function join(jsonStr)
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

        layui.use(['form','layer'], function(){
            $ = layui.jquery;
            var layer = layui.layer;
            setTimeout(function(){
                location.href= 'index.php?r=web/site/join';
            },3000);
            layer.msg("提交成功，请等待审核");
        });
    }
</script>

<?php
$this->endContent();
?>
