<?php
use app\assets\WapAsset;
use yii\helpers\Url;
WapAsset::register($this);
$this->beginContent('@views/layouts/wap.php');
?>
<style>
    body{
        overflow: hidden;
    }
    .container.index{
        background-image: url('<?=Yii::$app->params['imagePath']?>/wap/images/cert_bg.png');
        background-repeat: no-repeat;
        background-position: top;
        background-size: cover;
        position: relative;
        margin: 0 auto;
    }
</style>
<?=\app\modules\wap\model\process\PublicProcess::TopWeb()?>
<div class="container index" style="overflow: hidden;">
    <div class="form" style="top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);">
        <div class="certificate">
            <div class="input-box flex-box">
                <img src="<?=Url::to('images/card.png')?>" alt="" style="width: 1.75rem;height: 1.25rem">
                <input type="text" name="idcard" placeholder="身份证号" class="filler" style="padding-left: 0">
            </div>
            <div class="input-box flex-box">
                <img src="<?=Url::to('images/cert.png')?>" alt="" style="width: 1.75rem;height: 1.75rem">
                <input type="text" name="sCertificateNum" placeholder="证书编号" class="filler" style="padding-left: 0">
            </div>
            <!-- 错误提示 -->
            <div class="errorPrompt" style="display: none;">
                <span class="eptitle" style="margin-left: 4rem">请输入正确的身份证号/证书编号</span>
            </div>
            <button type="button" class="commit" style="cursor:pointer">查 询</button>
        </div>
    </div>
</div>
<footer>
    <?=\app\modules\wap\model\process\PublicProcess::MiddleWeb()?>
</footer>
<script>
    $(function()
    {
        var windowHeight = $(window).height() / 8;
        $('.container.index').css('height',windowHeight - 28.85+'rem');
        optionsHeight();
        function optionsHeight() {

            var phoneType = iphoneAdapter();
            if(phoneType == 'Pixel 2 XL'){

            }
            if(phoneType == 'Moto G (4)' || phoneType == 'Android'){
                $('.container.index').css('height',windowHeight - 24.85+'rem');
            }
            if(phoneType == 'iPhone5'){
                $('.container.index').css('height',windowHeight - 15.85+'rem');
            }
        }

        $('.commit').click(function(){
            var idcard = $('input[name=idcard]').val();
            var sCertificateNum = $('input[name=sCertificateNum]').val();
            var key = '<?=Yii::$app->params['KEY']?>';

            if(idcard.length == 0 || sCertificateNum.length == 0){
                $(".errorPrompt").css("display","block");
                return false;
            }

            var arrPara = ['merCode','timestamp','client','idcard','sCertificateNum'];
            var jsonData = {
                merCode: '<?=Yii::$app->params['MERCODE']?>',
                timestamp: Date.now(),
                client:'web',
                idcard:idcard,
                sCertificateNum:sCertificateNum
            };
            arrPara = arrPara.sort();
            var str = "";
            for(var i = 0; i < arrPara.length; i++) {
                str += arrPara[i]+"="+jsonData[arrPara[i]]+"&";
            }
            str += 'key='+key;
            jsonData['signMsg'] = md5(str);
            getAJAX(jsonData,certindex,'site/certificateindex');
        });
    });

    function certindex(jsonStr)
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

        location.href=jsonStr.data.url;
    }
</script>

<?php
$this->endContent();
?>
