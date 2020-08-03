<?php
use app\assets\WapAsset;
use yii\helpers\Url;
WapAsset::register($this);
$this->beginContent('@views/layouts/wap.php');
?>
<style>
    body{
        overflow-x: hidden;
    }
    .container.course{
        background-color: #FDF7F2; /* 浏览器不支持时显示 */
        /* Safari */
        background: -webkit-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
        /* Opera */
        background: -o-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
        /* Firefox */
        background: -moz-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
        /* 标准的语法, 放在最后 */
        background: linear-gradient(#FFFDFA 30%,  #FFFEFF 75%);
    }
</style>
<?=\app\modules\wap\model\process\PublicProcess::TopWeb()?>
<div class="container course">
    <div class="container" style="position: relative;">
        <div class="section-title" style="height: 7.36vh">
            <div class="course-title">我的证书</div>
        </div>
        <hr style="height:1px;border:none;background: #FEF5EC">
        <div class="course-type">
            <div class="course-type-info" onclick='optionCourse(-1,this)'>
                <div class="course-type-info-tag"></div>
                <div class="course-type-info-title">全部</div>
            </div>
            <?php foreach($certificate as $k => $r){?>
                <div class="course-type-info" onclick='optionCourse(<?=$r->id?>,this)' style=" margin-top: -5rem;background-color: #FFFCF9;">
                    <div class="course-type-info-tag" style="visibility: hidden"></div>
                    <div class="course-type-info-title"><?=mb_substr($r->subjectName,0,4)?>...</div>
                </div>
            <?php }?>
        </div>
        <div class="course-info">
            <h3>全部（共<?=count($cate)?>个证书）</h3>
            <?php foreach($cate as $c){?>
                <div class="course-list">
                    <div class="course-head">
                        <img src="<?=Yii::$app->params['imagePath'].$c['sCertificateImg']?>" alt="">
                    </div>
                    <div class="course-content">
                        <?php if(mb_strlen($c['sName']) > 7){?>
                            <div class="course-name"><?=mb_substr($c['sName'],0,7)?>...</div>
                        <?php }else{?>
                            <div class="course-name"><?=$c['sName']?></div>
                        <?php }?>
                        <div class="course-author">No：<?=$c['sCertificateNum']?></div>
                        <div class="course-sign"><a href="<?=$c['url']?>">查看详情</a></div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</div>
<script>
    optionsHeight();
    function optionsHeight() {
        var h = $('.course-info').height() / 8;
        var windowHeight=$(window).height() / 8;
        var height = 0;
        var phoneType = iphoneAdapter();
        if(h > windowHeight)
        {

            height = h;
            if(phoneType == 'iPhone8P'){
                height = h - 10;
            }
            if(phoneType == 'iPhone5'){
                height = h + 18;
            }
            if(phoneType == 'Pixel 2'){
                height = h - 10;
            }
            if(phoneType == 'Pixel 2 XL'){
                height = h - 15;
            }
            if(phoneType == 'Moto G (4)' || phoneType == 'Android'){
                height = h + 4;
            }
            if(phoneType == 'iPad'){
                height = h - 131;
            }
        }else{
            height = windowHeight - 12.6;
            if(phoneType == 'iPhone8P'){
                height = windowHeight - 21.4;
            }
            if(phoneType == 'iPhone5'){
                height = windowHeight-0.6;
            }
            if(phoneType == 'Pixel 2 XL'){
                height = windowHeight - 9;
            }
            if(phoneType == 'Pixel 2'){
                height = windowHeight - 22.6;
            }
            if(phoneType == 'Moto G (4)' || phoneType == 'Android'){
                height = windowHeight - 9.6;
            }
            if(phoneType == 'iPad'){
                height = windowHeight - 98.2;
            }
            if(phoneType == 'iPhoneX'){
                height = windowHeight - 14;
            }
        }

        $('.course-type').css('height',height+'rem');
    }

    function optionCourse(id,that)
    {
        $('.course-type-info').css('background','#FFFCF9');
        $(that).css('background-color','#FFFFFF');
        $('.course-type-info-tag').css('visibility','hidden');
        $(that).find('.course-type-info-tag').css('visibility','visible');

        var arrPara = ['merCode','timestamp','client','cid'];
        var jsonData = {
            merCode: '<?=Yii::$app->params['MERCODE']?>',
            timestamp: Date.now(),
            client:'wap',
            cid:id
        };
        arrPara = arrPara.sort();
        var str = "";
        for(var i = 0; i < arrPara.length; i++) {
            str += arrPara[i]+"="+jsonData[arrPara[i]]+"&";
        }
        str += 'key=<?=Yii::$app->params['KEY']?>';
        jsonData['signMsg'] = md5(str);
        getAJAX(jsonData,courseindex,'site/certificatelist');
    }

    function courseindex(jsonStr) {
        var str = '<h3>'+jsonStr.data.subjectName+'（共'+jsonStr.data.cate.length+'个证书）</h3>';
        $(jsonStr.data.cate).each(function (ids, items) {
            str += '<div class="course-list">\n' +
                '                <div class="course-head">\n' +
                '                <img src="<?=Yii::$app->params['imagePath']?>'+items.sCertificateImg+'" alt="">\n'+
                '                </div>\n'+
                '                <div class="course-content">\n'+
                '                <div class="course-name">'+items.sName+'</div>\n'+
                '                <div class="course-author">No：'+items.sCertificateNum+'</div>\n'+
                '            <div class="course-sign"><a href="'+items.url+'">查看详情</a></div>\n'+
                '            </div>\n'+
                '            </div>';
        });
        $('.course-info').html(str);
        optionsHeight();
    }
</script>

<?php
$this->endContent();
?>
