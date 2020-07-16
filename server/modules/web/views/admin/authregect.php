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
        <input type="hidden" value="<?=$get['id']?>" name="id">
        <input type="hidden" value="<?=$get['param']['status']?>" name="status">

        <div class="layui-form-item">
            <label for="L_mail" class="layui-form-label" style="width: 13rem">审核未通过原因：</label>
            <div class="layui-input-inline">
                <textarea name="cause" id="" cols="75" rows="10" lay-verify="required"></textarea>
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
                url:'<?=$get['param']['url']?>',
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
