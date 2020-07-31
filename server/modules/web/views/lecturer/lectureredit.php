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
        <input type="hidden" value="<?=$lecturer['id'] ?? '' ?>" name="id">
        <input type="hidden" value="<?=\Yii::$app->session->get('iUserID')?>" name="iUserID">

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">姓  名：</label>
            <div class="layui-input-inline">
                <input type="text" id="sName" value="<?=$lecturer['sName'] ?? ''?>"  name="sName" lay-verify="required" autocomplete="off" class="layui-input" maxlength="30">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">性  别：</label>
            <div class="layui-input-inline">
                <select id="sex" name="sex" lay-filter="sex" lay-verify="required">
                    <option value = 0 >性  别</option>
                    <?php foreach(\app\models\db\ELecturer::$_sex as $kc => $pre){?>
                        <option value = <?=$kc?> <?=isset($lecturer->sex) && $lecturer->sex == $kc ? 'selected' : ''?> ><?=$pre?></option>
                    <?php }?>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">头  像：</label>
            <div class="layui-input-inline" style="width: 80%">
                <input type="hidden" name="UploadForm[imageFile]" value="">
                <input type="hidden" name="headportrait" value="<?=$lecturer['headportrait'] ?? ''?>">
                <input type="file" name="UploadForm[imageFile]" autocomplete="off" class="layui-input" style="float: left;width: 18%;border: none" onclick="uploadFile(this,'image')">
                <font>参考尺寸：256*348</font>
                <?php if(isset($lecturer['headportrait'])){?>
                    <img class="headportrait" src="<?=Yii::$app->params['imagePath'].$lecturer['headportrait']?>" alt="">
                <?php }else{?>
                    <img class="headportrait" src="" alt="" style="display: none">
                <?php }?>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">证  书：</label>
            <div class="layui-input-inline" style="width: 80%">
                <input type="hidden" name="UploadForm[imageFile]" value="">
                <input type="hidden" name="certificate" value="<?=$lecturer['certificate'] ?? ''?>">
                <input type="file" name="UploadForm[imageFile]" autocomplete="off" class="layui-input" style="float: left;width: 18%;border: none" onclick="uploadFile(this,'image1')">
                <font>参考尺寸：1274*901</font>
                <?php if(isset($lecturer['certificate'])){?>
                    <img class="certificate" src="<?=Yii::$app->params['imagePath'].$lecturer['certificate']?>" alt="">
                <?php }else{?>
                    <img class="certificate" src="" alt="" style="display: none">
                <?php }?>
           </div>
        </div>

        <div class="layui-form-item">
            <label for="L_mail" class="layui-form-label">个人简介：</label>
            <div class="layui-input-inline">
                <textarea name="info" id="" cols="75" rows="10" lay-verify="required"><?=$lecturer['info'] ?? ''?></textarea>
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
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        form.on('submit(save)', function(data){

            if($("#sex").val() == 0)
            {
                layer.msg('请选择性别');
                return false;
            }

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

    function uploadFile(that,file)
    {
        $(that).fileupload({
            dataType: 'json',
            url: 'index.php?r=web/upload/upload',
            success: function (json) {
                if(json.code == 0){
                    if(file == 'image')
                    {
                        $("input[name=headportrait]").val(json.data.url);
                        $(".headportrait").attr('src',"<?=Yii::$app->params['imagePath']?>"+json.data.url);
                        $(".headportrait").css('display','block');
                    }else{
                        $("input[name=certificate]").val(json.data.url);
                        $(".certificate").attr('src',"<?=Yii::$app->params['imagePath']?>"+json.data.url);
                        $(".certificate").css('display','block');
                    }
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
