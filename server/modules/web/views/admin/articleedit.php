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
        margin-left: 90px;
    }
</style>
<body>
<div class="x-body">
    <h1>基本信息：</h1>
    <div class="layui-form-item">
        <label for="L_phone" class="layui-form-label">图  片：</label>
        <?php $form=\yii\widgets\ActiveForm::begin([
            'id'=>'upload',
            'enableAjaxValidation' => false,
            'options'=>['enctype'=>'multipart/form-data']
        ]);
        ?>
        <?=$form->field($model, 'imageFile')->label(false)->fileInput(['style'=>'display:inline;']) ?>
        <?php \yii\widgets\ActiveForm::end(); ?>
        <div class="picture">
            <img src="<?=isset($article['picture']) ? Yii::$app->params['imagePath'].$article['picture'] : ''?>" alt="" style="margin-bottom: 10px">
        </div>
        <font>参考尺寸：200*137</font>
    </div>
    <?php $form=\yii\widgets\ActiveForm::begin([
        'enableAjaxValidation' => false,
        'options'=>['enctype'=>'multipart/form-data','class'=>'layui-form']
    ]);
    ?>
    <input type="hidden" value="<?=$article['id'] ?? '' ?>" name="id">

    <div class="layui-form-item">
        <label for="L_username" class="layui-form-label">标  题：</label>
        <div class="layui-input-inline">
            <input type="text" id="title" value="<?=$article['title'] ?? ''?>"  name="title" lay-verify="required" autocomplete="off" class="layui-input" maxlength="100">
        </div>
    </div>

    <div class="layui-form-item">
        <label for="L_username" class="layui-form-label">作  者：</label>
        <div class="layui-input-inline">
            <input type="text" id="author" value="<?=$article['author'] ?? ''?>"  name="author" lay-verify="required" autocomplete="off" class="layui-input" maxlength="50">
        </div>
    </div>

    <div class="layui-form-item">
        <label for="L_username" class="layui-form-label">文章类型：</label>
        <div class="layui-input-inline">
            <select id="type" name="type" lay-filter="type" lay-verify="required">
                <option value = 0 >文章类型</option>
                <?php foreach(\app\models\db\BArticle::$_type as $kc => $pre){?>
                    <option value = <?=$kc?> <?=isset($article['type']) && $article['type'] == $kc ? 'selected' : ''?> ><?=$pre?></option>
                <?php }?>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label for="L_username" class="layui-form-label"></label>
        <div class="layui-input-inline">
            <input type="checkbox" name="isHot" <?=isset($article['isHot']) && $article['isHot'] == \app\models\db\BArticle::YES ? 'checked' : ''?> value="<?=$article['isHot'] ?? ''?>" title="是否热门" lay-skin="primary" lay-filter="isHot">
        </div>
    </div>

    <?= $form->field($redactor, 'content')->widget(\yii\redactor\widgets\Redactor::className(),[
        'clientOptions' => [
            'lang' => 'zh_cn',
            'plugins' => ['clips', 'fontcolor','imagemanager'],
            'minHeight'=>'800px'
        ],
        'options'=>['value'=>$article['content'] ?? '']
    ])?>
    <input type="hidden" name="picture" value="<?=$article['picture'] ?? ''?>">
    <button lay-submit lay-filter="save" class="layui-btn" >提交</button>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>
<script>

    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        form.on('checkbox(isHot)', function(data){
            var ischecked = data.elem.checked;
            if(ischecked == true)
            {
                data.elem.value = 1;
            }else{
                data.elem.value = 0;
            }
            form.render('checkbox');
        });

        $('#uploadform-imagefile').fileupload({
            dataType: 'json',
            url: 'index.php?r=web/upload/upload',
            success: function (json) {
                if(json.code == 0){
                    $(".picture img").attr('src',"<?=Yii::$app->params['imagePath']?>"+json.data.url);
                    $("input[name=picture]").val(json.data.url);
                }else{
                    layer.msg(json.msg);
                }
            }
        });

        form.on('submit(save)', function(data){

            if($("#type").val() == 0)
            {
                layer.msg('请选择文章类型');
                return false;
            }

            if($("input[name=picture]").val().length == 0)
            {
                layer.msg('请上传文章图片');
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
