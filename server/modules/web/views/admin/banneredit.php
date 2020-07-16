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
    <div class="layui-form-item">
        <label for="L_phone" class="layui-form-label">Banner：</label>
        <?php $form=\yii\widgets\ActiveForm::begin([
            'id'=>'upload',
            'enableAjaxValidation' => false,
            'options'=>['enctype'=>'multipart/form-data']
        ]);
        ?>
        <?=$form->field($model, 'imageFile')->label(false)->fileInput(['style'=>'display:inline;']) ?>
        <?php \yii\widgets\ActiveForm::end(); ?>
        <div class="image">
            <img src="<?=isset($banner['image']) ? Yii::$app->params['imagePath'].$banner['image'] : ''?>" alt="" style="margin-bottom: 10px">
        </div>
    </div>
    <form class="layui-form" method="post" action="">
        <input type="hidden" value="<?=$banner['id'] ?? '' ?>" name="id">

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">标  题：</label>
            <div class="layui-input-inline">
                <input type="text" id="name" value="<?=$banner['name'] ?? ''?>"  name="name" lay-verify="required" autocomplete="off" class="layui-input" maxlength="30">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">文章URL：</label>
            <div class="layui-input-inline">
                <select id="aid" name="aid" lay-filter="aid" lay-verify="required">
                    <option value = 0 >选择文章</option>
                    <?php foreach($article as $kc => $pre){?>
                        <option value = <?=$pre->id?> <?=isset($banner->aid) && $banner->aid == $pre->id ? 'selected' : ''?> ><?=$pre->title?></option>
                    <?php }?>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">开始时间：</label>
            <div class="layui-input-inline">
                <input type="text" id="date_from" value="<?=$banner['date_from'] ?? ''?>"  name="date_from" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">结束时间：</label>
            <div class="layui-input-inline">
                <input type="text" id="date_to" value="<?=$banner['date_to'] ?? ''?>"  name="date_to" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <input type="hidden" name="image" value="<?=$banner['image'] ?? ''?>">
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
            elem: '#date_from',
            type:"datetime"
            ,trigger: 'click'//呼出事件改成click
            ,value: '<?=$dBeginTime?>'
        });
        laydate.render({
            elem: '#date_to',
            type:"datetime"
            ,trigger: 'click'//呼出事件改成click
            ,value: '<?=$dBeginTime?>'
        });
    });

    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        $('#uploadform-imagefile').fileupload({
            dataType: 'json',
            url: 'index.php?r=web/upload/upload',
            success: function (json) {
                if(json.code == 0){
                    $(".image img").attr('src',"<?=Yii::$app->params['imagePath']?>"+json.data.url);
                    $("input[name=image]").val(json.data.url);
                }else{
                    layer.msg(json.msg);
                }
            }
        });

        //自定义验证规则
        form.verify({
            classhour: [/^[1-9]*[1-9][0-9]*$/, '课时必需为正整数']
        });

        form.on('submit(save)', function(data){

            if($("input[name=image]").val().length == 0)
            {
                layer.msg('请上传Banner图片');
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

</script>
<?php
$this->endContent();
?>
