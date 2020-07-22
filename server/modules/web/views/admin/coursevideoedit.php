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
<h1>基本信息：</h1>
<div class="x-body">
    <form class="layui-form" method="post" action="">
        <input type="hidden" value="<?=$course['id']?>" name="cid">
        <input type="hidden" value="<?=$video['id'] ?? '' ?>" name="id">

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">章节名称：</label>
            <div class="layui-input-inline">
                <input type="text" id="sChapterName" value="<?=$video['sChapterName'] ?? ''?>"  name="sChapterName" lay-verify="required" autocomplete="off" class="layui-input" maxlength="100">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_mail" class="layui-form-label">讲  师：</label>
            <div class="layui-input-inline">
                <input type="text" id="author" value="<?=$video['author'] ?? ''?>"  name="author" autocomplete="off" class="layui-input" maxlength="50">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">时  长：</label>
            <div class="layui-input-inline">
                <input type="text" id="time" value="<?=$video['time'] ?? ''?>"  name="time" autocomplete="off" class="layui-input" readonly>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">视  频：</label>
            <div class="layui-input-inline" style="width: 80%">
                <input type="hidden" name="UploadForm[videoFile]" value="">
                <input type="hidden" name="sTrainingvideoUrl" value="<?=$video['sTrainingvideoUrl'] ?? '' ?>" >
                <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this)">
                <span class="sTrainingvideoUrl"><?=$video['sTrainingvideoUrl'] ?? '' ?></span>
            </div>
        </div>

        <div class="layui-form-item" style="margin-left: 10rem">
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
            elem: '#time',
            type:"time"
            ,trigger: 'click'//呼出事件改成click
            ,value: '<?=$banner['time'] ?? ''?>'
        });
    });
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        //自定义验证规则
        form.verify({
            // time: [/^[1-9]*[1-9][0-9]*$/, '课时必需为正整数']
        });

        form.on('submit(save)', function(data){

            // if($("#time").val().length > 0)
            // {
            //     var re = /^[1-9]*[1-9][0-9]*$/;
            //     if (!re.test($("#time").val())) {
            //         layer.msg("课时必需为正整数");
            //         return false;
            //     }
            // }

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
            url: 'index.php?r=web/upload/video',
            success: function (json) {
                if(json.code == 0){
                    $("input[name=sTrainingvideoUrl]").val(json.data.url);
                    $(".sTrainingvideoUrl").text(json.data.url);
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
