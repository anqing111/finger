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
        <label for="L_phone" class="layui-form-label">课程图片：</label>
        <?php $form=\yii\widgets\ActiveForm::begin([
            'id'=>'upload',
            'enableAjaxValidation' => false,
            'options'=>['enctype'=>'multipart/form-data']
        ]);
        ?>
        <?=$form->field($model, 'imageFile')->label(false)->fileInput(['style'=>'display:inline;']) ?>
        <?php \yii\widgets\ActiveForm::end(); ?>
        <div class="sCourseImg">
            <img src="<?=isset($course['sCourseImg']) ? Yii::$app->params['imagePath'].$course['sCourseImg'] : ''?>" alt="" style="margin-bottom: 10px">
        </div>
    </div>
    <form class="layui-form" method="post" action="">
        <input type="hidden" value="<?=$course['id'] ?? '' ?>" name="id">

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">课程名称：</label>
            <div class="layui-input-inline">
                <input type="text" id="sCourseName" value="<?=$course['sCourseName'] ?? ''?>"  name="sCourseName" lay-verify="required" autocomplete="off" class="layui-input" maxlength="100">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_mail" class="layui-form-label">作  者：</label>
            <div class="layui-input-inline">
                <input type="text" id="author" value="<?=$course['author'] ?? ''?>"  name="author" lay-verify="required" autocomplete="off" class="layui-input" maxlength="50">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">课  时：</label>
            <div class="layui-input-inline">
                <input type="text" id="classhour" value="<?=$course['classhour'] ?? ''?>"  name="classhour" lay-verify="required|classhour" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">课程分类：</label>
            <div class="layui-input-inline">
                <select id="type" name="type" lay-filter="type" lay-verify="required">
                    <option value = 0 >课程分类</option>
                    <?php foreach(\app\models\db\BCourse::$_type as $kc => $pre){?>
                        <option value = <?=$kc?> <?=isset($course->type) && $course->type == $kc ? 'selected' : ''?> ><?=$pre?></option>
                    <?php }?>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">课程简介：</label>
            <div class="layui-input-inline">
                <textarea name="sCourseInfo" id="sCourseInfo" cols="30" rows="10"><?=$course['sCourseInfo'] ?? ''?></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">录制时间：</label>
            <div class="layui-input-inline">
                <input type="text" id="dRecordingTime" value="<?=$course['dRecordingTime'] ?? ''?>"  name="dRecordingTime" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <input type="hidden" name="sCourseImg" value="<?=$course['sCourseImg'] ?? ''?>">
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
            elem: '#dRecordingTime',
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
                    $(".sCourseImg img").attr('src',"<?=Yii::$app->params['imagePath']?>"+json.data.url);
                    $("input[name=sCourseImg]").val(json.data.url);
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

            if($("#type").val() == 0)
            {
                layer.msg('请选择课程分类');
                return false;
            }

            if($("input[name=sCourseImg]").val().length == 0)
            {
                layer.msg('请上传课程图片');
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
