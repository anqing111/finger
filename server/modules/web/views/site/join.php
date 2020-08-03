<?php
use app\assets\WebAsset;
use yii\helpers\Url;
WebAsset::register($this);
$this->beginContent('@views/layouts/web.php');
?>
<style>
    .layui-select-title input{
        border: none;
        width: 300px;
        height: 40px;
    }
    .layui-form-select .layui-edge{
        left: 297px;
    }
    .layui-form-selected dl{
        width: 307px;
    }
    .layui-form-item{
        margin-bottom:0;
    }
    .layui-form-select dl dd.layui-this
    {
        background: #FF9D2A ;
    }
    .layui-select-title input{
        color: #95928F;
    }
</style>
<?=\app\modules\web\model\process\PublicProcess::TopWeb()?>
<div class="top">
    <img src="<?=Url::to('images/join_bg.png')?>" alt="" style="background: rgba(0,0,0,0);margin-top: 0px">
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
                    <img src="<?=Url::to('images/company.png')?>" alt="" style="height:18px;width: 20px;margin-top: 17px;">
                    <input type="text" name="sUnitName" placeholder="单位名称" class="filler">
                </div>
                <!-- 错误提示 -->
                <div class="errorPrompt" style="display: none;">
                    <span class="font_family">&#xe635;</span>
                    <span class="eptitle">&nbsp;</span>
                </div>
                <div class="input-box flex-box">
                    <img src="<?=Url::to('images/user.png')?>" alt="" style="width: 21px;height: 21px">
                    <input type="text" name="person" placeholder="负责人" class="filler">
                </div>
                <!-- 错误提示 -->
                <div class="errorPrompt" style="display: none;">
                    <span class="font_family">&#xe635;</span>
                    <span class="eptitle">&nbsp;</span>
                </div>
                <div class="input-box flex-box">
                    <img src="<?=Url::to('images/direction.png')?>" alt="" style="height: 21px;width: 21px">
                    <input type="text" name="direction" placeholder="加盟方向" class="filler">
                </div>
                <!-- 错误提示 -->
                <div class="errorPrompt" style="display: none;">
                    <span class="font_family">&#xe635;</span>
                    <span class="eptitle">&nbsp;</span>
                </div>
                <div class="input-box flex-box" style="margin-bottom: -14px;">
                    <img src="<?=Url::to('images/city.png')?>" alt="" style="width: 20px;height: 16px">
                    <input type="hidden" name="iCityID">
                </div>
                <!-- 错误提示 -->
                <div class="errorPrompt" style="display: none;">
                    <span class="font_family">&#xe635;</span>
                    <span class="eptitle">&nbsp;</span>
                </div>
                <div class="x-body" style="position: relative;top: -34px;left: 30px;">
                    <form class="layui-form" method="post" action="">
                        <div class="layui-form-item">
                            <div class="layui-input-inline">
                                <select name="iCityID" id="iCityID" class="filler" lay-filter="iCityID" lay-verify="required">
                                    <option value="0">所属城市</option>
                                    <?php foreach($city as $r){?>
                                        <option value="<?=$r->iCityID?>"><?=$r->sCityName?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="input-box flex-box">
                    <img src="<?=Url::to('images/phone.png')?>" alt="" style="width: 13px;height: 21px;margin-left: 13px">
                    <input type="text" name="sPhone" placeholder="联系电话" class="filler" style="margin-left: 3px;">
                </div>
                <!-- 错误提示 -->
                <div class="errorPrompt" style="display: none;">
                    <span class="font_family">&#xe635;</span>
                    <span class="eptitle">&nbsp;</span>
                </div>
                <div class="input-box flex-box">
                    <img src="<?=Url::to('images/mail.png')?>" alt="" style="width: 20px;height: 15px;margin-top: 18.3px">
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
            var iCityID = $('input[name=iCityID]').val();
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
            if(iCityID.length == 0){
                $('.layui-select-title input').css('height','34px');
                $('.x-body').css('top','-80px');
                $("input[name=iCityID]").parent().next(".errorPrompt").css('margin-top','19px');
                $("input[name=iCityID]").parent().next(".errorPrompt").css("display","block");
                $("input[name=iCityID]").parent().next(".errorPrompt").find(".eptitle").html("&nbsp;请选择城市");
                return false;
            }
            var data2 = validatemobile(sPhone);
            if(data2["code"] != 0)
            {
                $('.x-body').css('top','-34px');
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

    layui.use(['form','layer'], function() {
        $ = layui.jquery;
        var form = layui.form
            , layer = layui.layer;

        form.on('select(iCityID)', function (data) {

            $('input[name=iCityID]').val(data.value);
            form.render('select');
        });
    });

    function join(jsonStr)
    {
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
            var layer = layui.layer;
            if(jsonStr.code!=0)
            {
                $(".errorPrompt").css("display","block");
                if(jsonStr.msg == undefined){

                    layer.msg("网络异常");
                }else{
                    layer.msg(jsonStr.msg);
                }
                return false;
            }
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
