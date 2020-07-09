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
    <h1>基本信息：</h1>
    <div class="layui-form-item">
        <label for="L_phone" class="layui-form-label">背景大图：</label>
        <?php $form=\yii\widgets\ActiveForm::begin([
            'id'=>'upload',
            'enableAjaxValidation' => false,
            'options'=>['enctype'=>'multipart/form-data']
        ]);
        ?>
        <?=$form->field($model, 'imageFile')->label(false)->fileInput(['style'=>'display:inline;']) ?>
        <?php \yii\widgets\ActiveForm::end(); ?>
        <div class="img">
            <img src="<?=isset($university['img']) ? Yii::$app->params['imagePath'].$university['img'] : ''?>" alt="" style="margin-bottom: 10px">
        </div>
    </div>
    <?php $form=\yii\widgets\ActiveForm::begin([
        'enableAjaxValidation' => false,
        'options'=>['enctype'=>'multipart/form-data','class'=>'layui-form']
    ]);
    ?>
    <input type="hidden" value="<?=$university['id'] ?? '' ?>" name="id">

    <div class="layui-form-item">
        <label for="L_username" class="layui-form-label">标题：</label>
        <div class="layui-input-inline">
            <input type="text" id="title" value="<?=$university['title'] ?? ''?>"  name="title" lay-verify="required" autocomplete="off" class="layui-input" maxlength="100">
        </div>
    </div>

    <?= $form->field($redactor, 'content')->widget(\yii\redactor\widgets\Redactor::className(),[
        'clientOptions' => [
            'lang' => 'zh_cn',
            'plugins' => ['clips', 'fontcolor','imagemanager'],
            'minHeight'=>'800px'
        ],
        'options'=>['value'=>$university['content'] ?? '']
    ])?>
    <input type="hidden" name="img" value="<?=$university['img'] ?? ''?>">
    <button lay-submit lay-filter="save" class="layui-btn" >提交</button>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>
<script>

    $(function () {
        $('.redactor-editor').find('p').html("<?=$university['content'] ?? ''?>");
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
                    $(".img img").attr('src',"<?=Yii::$app->params['imagePath']?>"+json.data.url);
                    $("input[name=img]").val(json.data.url);
                }else{
                    layer.msg(json.msg);
                }
            }
        });

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

</script>
<?php
$this->endContent();
?>
