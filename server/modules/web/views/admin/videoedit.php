<?php
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>
<style>
    h1{
        font-size: 20px;padding: 1rem;font-weight: 900;
    }
</style>
<body>
<div class="x-body">
    <form class="layui-form" method="post" action="">
        <h1>基本信息：</h1>
        <input type="hidden" value="<?=$video['id'] ?? '' ?>" name="id">

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">视频标题：</label>
            <div class="layui-input-inline">
                <input type="text" id="sProblemName" value="<?=$video['sProblemName'] ?? ''?>"  name="sProblemName" lay-verify="required" autocomplete="off" class="layui-input" maxlength="100">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">选择学员：</label>
            <div class="layui-input-inline">
                <select name="iUserID" lay-filter="iUserID">
                    <option value = 0 >选择学员</option>
                    <?php foreach($user as $kc => $pre){?>
                        <option value = <?=$pre->iUserID?> <?=isset($video['iUserID']) && $video['iUserID'] == $pre->iUserID ? 'selected' : ''?>><?=$pre->sNick?></option>
                    <?php }?>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">视  频：</label>
            <div class="layui-input-inline" style="width: 80%">
                <input type="hidden" name="UploadForm[videoFile]" value="">
                <input type="hidden" name="sVideoUrl" value="<?=$video['sVideoUrl'] ?? ''?>">
                <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'sVideoUrl')">
                <?php if(!empty($video['sVideoImg'])){?>
                    <span class="sVideoUrl"><?=$video['sVideoUrl']?></span>
                <?php }else{?>
                    <span class="sVideoUrl"></span>
                <?php }?>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">背景图片：</label>
            <div class="layui-input-inline" style="width: 80%">
                <input type="hidden" name="UploadForm[imageFile]" value="">
                <input type="hidden" name="sVideoImg" value="<?=$video['sVideoImg'] ?? ''?>">
                <input type="file" name="UploadForm[imageFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'sVideoImg')">
                <?php if(!empty($video['sVideoImg'])){?>
                    <img src="<?=Yii::$app->params['imagePath'].$video['sVideoImg']?>" alt="" style="margin-bottom: 10px;width: 24%;height: 200px;" class="sVideoImg">
                <?php }else{?>
                    <img src="" alt="" style="margin-bottom: 10px;width: 24%;height: 200px;display: none" class="sVideoImg">
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

    function uploadFile(that,file)
    {
        var url = 'index.php?r=web/upload/upload';
        if(file == 'sVideoUrl')
        {
            var url = 'index.php?r=web/upload/video';
        }

        $(that).fileupload({
            dataType: 'json',
            url: url,
            success: function (json) {
                if(json.code == 0){
                    if(file == 'sVideoUrl')
                    {
                        $("input[name=sVideoUrl]").val(json.data.url);
                        $(".sVideoUrl").text(json.data.url);
                        $(".sVideoUrl").css('display','block');
                    }else{
                        $("input[name=sVideoImg]").val(json.data.url);
                        $(".sVideoImg").attr('src',"<?=Yii::$app->params['imagePath']?>"+json.data.url);
                        $(".sVideoImg").css('display','block');
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
