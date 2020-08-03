<?php
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>
<style>
    h1{
        font-size: 20px;padding: 1rem;font-weight: 900;
    }
    font{
        color: red;
    }
</style>
<body>
<div class="x-body">
    <form class="layui-form" method="post" action="">
        <h1>基本信息：</h1>
        <input type="hidden" value="<?=$cate['id'] ?? '' ?>" name="id">
        <input type="hidden" value="<?=$cate['iUserID'] ?? Yii::$app->session->get('iUserID') ?>" name="iUserID">

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">证书名称：</label>
            <div class="layui-input-inline">
                <input type="text" id="sName" value="<?=$cate['sName'] ?? ''?>"  name="sName" lay-verify="required" autocomplete="off" class="layui-input" maxlength="100">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">证书编号：</label>
            <div class="layui-input-inline">
                <input type="text" id="sCertificateNum" value="<?=$cate['sCertificateNum'] ?? ''?>"  name="sCertificateNum" lay-verify="required" autocomplete="off" class="layui-input" maxlength="100">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">选择类别：</label>
            <div class="layui-input-inline">
                <select name="cid" lay-filter="cid">
                    <option value = 0 >选择类别</option>
                    <?php foreach($certificate as $r){?>
                        <option value = <?=$r->id?> <?=isset($cate['cid']) && $cate['cid'] == $r->id ? 'selected' : ''?>><?=$r->subjectName?></option>
                    <?php }?>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">身份证号：</label>
            <div class="layui-input-inline">
                <input type="text" id="idcard" value="<?=$cate['idcard'] ?? ''?>"  name="idcard" lay-verify="required" autocomplete="off" class="layui-input" maxlength="18">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">文字简介：</label>
            <div class="layui-input-inline">
                <input type="text" id="sContent" value="<?=$cate['sContent'] ?? ''?>"  name="sContent" lay-verify="required" autocomplete="off" class="layui-input" maxlength="255">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">获得时间：</label>
            <div class="layui-input-inline">
                <input type="text" id="dGetDate" value="<?=$cate['dGetDate'] ?? ''?>"  name="dGetDate" lay-verify="required" autocomplete="off" class="layui-input" maxlength="100">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">所属机构：</label>
            <div class="layui-input-inline">
                <input type="text" id="sOrganName" value="<?=$cate['sOrganName'] ?? ''?>"  name="sOrganName" lay-verify="required" autocomplete="off" class="layui-input" maxlength="100">
            </div>
        </div>

        <?php if(!empty($cate['id']) && $cate['status'] == \app\models\db\EStudentcertificate::FILED){?>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">审核不通过原因：</label>
                <div class="layui-input-inline">
                    <textarea name="cause" id="" cols="30" rows="10" disabled><?=$cate['cause'] ?? ''?></textarea>
                </div>
            </div>
        <?php }?>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">上传证书：</label>
            <div class="layui-input-inline" style="width: 80%">
                <input type="hidden" name="UploadForm[imageFile]" value="">
                <input type="hidden" name="sCertificateImg" value="<?=$cate['sCertificateImg'] ?? ''?>">
                <input type="file" name="UploadForm[imageFile]" autocomplete="off" class="layui-input" style="float: left;width: 18%;border: none" onclick="uploadFile(this)">
                <font>参考尺寸：1274*901</font>
                <?php if(!empty($cate['sCertificateImg'])){?>
                    <img src="<?=Yii::$app->params['imagePath'].$cate['sCertificateImg']?>" alt="" class="sCertificateImg">
                <?php }else{?>
                    <img src="" alt="" style="display: none" class="sCertificateImg">
                <?php }?>

            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">
            </label>
            <button lay-submit lay-filter="save" class="layui-btn" >提交</button>
        </div>
    </form>
</div>
<script>
    // 日期插件
    layui.use('laydate', function(){
        var laydate = layui.laydate;
        laydate.render({
            elem: '#dGetDate',
            type:"date"
            ,trigger: 'click'//呼出事件改成click
            ,value: '<?=$cate['dGetDate'] ?? $dBeginTime?>'
        });
    });
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        form.on('submit(save)', function(data){

            $.ajax({
                url:location.href,
                async: false,
                type:"POST",
                dataType: "text",
                data:data.field,
                success: function(data){
                    data = $.parseJSON( data );
                    if(data.code == 0){
                        layer.alert("编辑成功", {icon: 6}, function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                            parent.location.reload();
                        });
                    }else {
                        layer.msg(data.msg);
                    }
                }
            });
            return false;

        });
    });

    function uploadFile(that)
    {
        $(that).fileupload({
            dataType: 'json',
            url: 'index.php?r=web/upload/upload',
            success: function (json) {
                if(json.code == 0){
                    $("input[name=sCertificateImg]").val(json.data.url);
                    $(".sCertificateImg").attr('src',"<?=Yii::$app->params['imagePath']?>"+json.data.url);
                    $(".sCertificateImg").css('display','block');
                }else{
                    layui.use(['layer'], function() {
                        $ = layui.jquery;
                        var layer = layui.layer;
                        layer.msg(json.msg);
                    });
                }
            }
        });
    }

</script>
<?php
$this->endContent();
?>
