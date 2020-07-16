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
        <label for="L_phone" class="layui-form-label">头像：</label>
        <?php $form=\yii\widgets\ActiveForm::begin([
            'id'=>'upload',
            'enableAjaxValidation' => false,
            'options'=>['enctype'=>'multipart/form-data']
        ]);
        ?>
        <?=$form->field($model, 'imagesHead')->label(false)->fileInput(['style'=>'display:inline;']) ?>
        <?php \yii\widgets\ActiveForm::end(); ?>
        <div class="image">
            <img src="<?=isset($instructor['headportrait']) ? Yii::$app->params['imagePath'].$instructor['headportrait'] : ''?>" alt="" style="margin-bottom: -11rem;">
            <img src="<?=isset($instructor['bigheadportrait']) ? Yii::$app->params['imagePath'].$instructor['bigheadportrait'] : ''?>" alt="" style="margin-bottom: 1rem">
        </div>
    </div>
    <form class="layui-form" method="post" action="">
        <input type="hidden" value="<?=$instructor['id'] ?? '' ?>" name="id">

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">姓  名：</label>
            <div class="layui-input-inline">
                <input type="text" value="<?=$instructor['sName'] ?? ''?>"  name="sName" lay-verify="required" autocomplete="off" class="layui-input" maxlength="100">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">个人简介：</label>
            <div class="layui-input-inline">
                <textarea name="info" id="info" cols="80" rows="10"><?=$instructor['info'] ?? ''?></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_remarks" class="layui-form-label">著  作：</label>
            <div id="book" class="layui-input-inline" style="border: 1px solid #e2e2e2;width: 50%">
                <br>
                <xblock style="background-color:#fff;text-align: right"><button type="button" class="layui-btn" data-title="添加" onclick="insertClass()"><i class="layui-icon"></i>添加</button></xblock>
                <?php if(!empty($instructor['instructorbook'])){?>
                    <?php foreach($instructor['instructorbook'] as $k => $r){?>

                        <?php if($k == 0){?>
                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">书  名：</label>
                                <div class="layui-input-inline" style="width: 80%">
                                    <input type="hidden" value="<?=$r['tid']?>" name="book[tid][0]">
                                    <input type="text" value="<?=$r['sBookName']?>" name="book[sBookName][0]" lay-verify="required" autocomplete="off" class="layui-input" style="float: left;width: 80%">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">图  片：</label>
                                <div class="layui-input-inline" style="width: 80%">
                                    <input type="hidden" name="UploadForm[imageFile]" value="">
                                    <input type="hidden" name="book[sBookImg][0]" value="<?=$r['sBookImg']?>" class="sBookImg0">
                                    <input type="file" name="UploadForm[imageFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'image',0)">
                                    <img src="<?=Yii::$app->params['imagePath'].$r['sBookImg']?>" alt="" style="margin-bottom: 10px;width: 24%;height: 200px;" class="images0">
                                </div>
                            </div>
                        <?php }else{?>
                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">书  名：</label>
                                <div class="layui-input-inline" style="width: 80%">
                                    <input type="hidden" value="<?=$r['tid']?>" name="book[tid][<?=$k?>]">
                                    <input type="text" value="<?=$r['sBookName']?>" name="book[sBookName][<?=$k?>]" lay-verify="required" autocomplete="off" class="layui-input" style="float: left;width: 80%">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">图  片：</label>
                                <div class="layui-input-inline" style="width: 80%">
                                    <input type="hidden" name="UploadForm[imageFile]" value="">
                                    <input type="hidden" name="book[sBookImg][<?=$k?>]" value="<?=$r['sBookImg']?>" class="sBookImg<?=$k?>">
                                    <input type="file" name="UploadForm[imageFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'image',<?=$k?>)">
                                    <img src="<?=Yii::$app->params['imagePath'].$r['sBookImg']?>" alt="" style="margin-bottom: 10px;width: 24%;height: 200px;" class="images<?=$k?>">
                                    <button type="button" class="layui-btn" data-title="删除" onclick="deleteClass(this)" style="margin-left: 1rem"><i class="layui-icon"></i>删除</button>
                                </div>
                            </div>
                        <?php }?>

                    <?php }?>
                <?php }else{?>
                    <div class="layui-form-item">
                        <label for="L_phone" class="layui-form-label">书  名：</label>
                        <div class="layui-input-inline" style="width: 80%">
                            <input type="hidden" value="" name="book[tid][0]">
                            <input type="text" value="" name="book[sBookName][0]" lay-verify="required" autocomplete="off" class="layui-input" style="float: left;width: 80%">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_phone" class="layui-form-label">图  片：</label>
                        <div class="layui-input-inline" style="width: 80%">
                            <input type="hidden" name="UploadForm[imageFile]" value="">
                            <input type="hidden" name="book[sBookImg][0]" value="" class="sBookImg0">
                            <input type="file" name="UploadForm[imageFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'image',0)">
                            <img src="" alt="" style="margin-bottom: 10px;width: 24%;height: 200px;display: none" class="images0">
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_remarks" class="layui-form-label">视  频：</label>
            <div id="video" class="layui-input-inline" style="border: 1px solid #e2e2e2;width: 50%">
                <br>
                <xblock style="background-color:#fff;text-align: right"><button type="button" class="layui-btn" data-title="添加" onclick="insertClassVideo()"><i class="layui-icon"></i>添加</button></xblock>
                <?php if(!empty($instructor['instructorvideo'])){?>
                    <?php foreach($instructor['instructorvideo'] as $k1 => $r1){?>

                        <?php if($k1 == 0){?>
                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">作品介绍：</label>
                                <div class="layui-input-inline" style="width: 80%">
                                    <input type="hidden" value="<?=$r1['tid']?>" name="video[tid][<?=$k1?>]">
                                    <textarea name="video[sOpusInfo][]" id="" cols="75" rows="10" lay-verify="required"><?=$r1['sOpusInfo']?></textarea>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">视  频：</label>
                                <div class="layui-input-inline" style="width: 80%">
                                    <input type="hidden" name="UploadForm[videoFile]" value="">
                                    <input type="hidden" name="video[sTrainUrl][<?=$k1?>]" value="<?=$r1['sTrainUrl']?>" class="sTrainUrl<?=$k1?>">
                                    <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'video',<?=$k1?>)">
                                    <span class="videos<?=$k1?>"><?=$r1['sTrainUrl']?></span>
                                </div>
                            </div>
                        <?php }else{?>
                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">作品介绍：</label>
                                <div class="layui-input-inline" style="width: 80%">
                                    <input type="hidden" value="<?=$r1['tid']?>" name="video[tid][<?=$k1?>]">
                                    <textarea name="video[sOpusInfo][<?=$k1?>]" id="" cols="75" rows="10" lay-verify="required"><?=$r1['sOpusInfo']?></textarea>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">视  频：</label>
                                <div class="layui-input-inline" style="width: 80%">
                                    <input type="hidden" name="UploadForm[videoFile]" value="">
                                    <input type="hidden" name="video[sTrainUrl][<?=$k1?>]" value="<?=$r1['sTrainUrl']?>" class="sTrainUrl<?=$k1?>">
                                    <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'video',<?=$k1?>)">
                                    <span class="videos<?=$k1?>"><?=$r1['sTrainUrl']?></span>
                                    <button type="button" class="layui-btn" data-title="删除" onclick="deleteClassVideo(this)" style="margin-left: 1rem"><i class="layui-icon"></i>删除</button>
                                </div>
                            </div>
                        <?php }?>

                    <?php }?>
                <?php }else{?>
                    <div class="layui-form-item">
                        <label for="L_phone" class="layui-form-label">作品介绍：</label>
                        <div class="layui-input-inline" style="width: 80%">
                            <input type="hidden" value="" name="video[tid][0]">
                            <textarea name="video[sOpusInfo][0]" id="" cols="75" rows="10" lay-verify="required"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_phone" class="layui-form-label">视  频：</label>
                        <div class="layui-input-inline" style="width: 80%">
                            <input type="hidden" name="UploadForm[videoFile]" value="">
                            <input type="hidden" name="video[sTrainUrl][0]" value="" class="sTrainUrl0">
                            <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'video',0)">
                            <span class="videos0" style="display:none"></span>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
        <input type="hidden" name="headportrait" value="<?=$instructor['headportrait'] ?? ''?>">
        <input type="hidden" name="bigheadportrait" value="<?=$instructor['bigheadportrait'] ?? ''?>">
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

        $('#uploadform-imageshead').fileupload({
            dataType: 'json',
            url: 'index.php?r=web/upload/head',
            success: function (json) {
                if(json.code == 0){
                    $(".image img:first").attr('src',"<?=Yii::$app->params['imagePath']?>"+json.data.url[0]);
                    $(".image img:last").attr('src',"<?=Yii::$app->params['imagePath']?>"+json.data.url[1]);
                    $("input[name=headportrait]").val(json.data.url[0]);
                    $("input[name=bigheadportrait]").val(json.data.url[1]);
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

    var bookindex = 0;
    function insertClass() {
        if(bookindex == 0 && $('#book').find('.layui-form-item').length > 2)
        {
            var len = $('#book').find('.layui-form-item').length / 2;
            bookindex = len - 1;
        }
        bookindex++;
        var str = '<div class="layui-form-item">\n' +
            '                    <label for="L_phone" class="layui-form-label">书  名：</label>\n' +
            '                    <div class="layui-input-inline" style="width: 80%">\n' +
            '                        <input type="hidden" value="" name="book[tid]['+bookindex+']">\n' +
            '                        <input type="text" value="" lay-verify="required" name="book[sBookName]['+bookindex+']" autocomplete="off" class="layui-input" style="float: left;width: 80%">\n' +
            '                    </div>\n' +
            '                </div>';
        str += '<div class="layui-form-item">\n' +
            '                        <label for="L_phone" class="layui-form-label">图  片：</label>\n' +
            '                        <div class="layui-input-inline" style="width: 80%">\n' +
            '                            <input type="hidden" name="UploadForm[imageFile]" value="">\n' +
            '                            <input type="hidden" name="book[sBookImg]['+bookindex+']" value="" class="sBookImg'+bookindex+'">\n' +
            '                            <input type="file" name="UploadForm[imageFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,\'image\','+bookindex+')">\n' +
            '                            <img src="" alt="" style="margin-bottom: 10px;width: 24%;height: 200px;display: none" class="images'+bookindex+'">\n' +
            '                            <button type="button" class="layui-btn" data-title="删除" onclick="deleteClass(this)" style="margin-left: 1rem"><i class="layui-icon"></i>删除</button>\n' +
            '                        </div>\n' +
            '                    </div>';
        $("#book").append(str);
    }

    function deleteClass(that) {
        $(that).parent().parent().prev('.layui-form-item').remove();
        $(that).parent().parent().remove();
    }

    var videoindex = 0;
    function insertClassVideo() {
        if(videoindex == 0 && $('#video').find('.layui-form-item').length > 0)
        {
            var len = $('#video').find('.layui-form-item').length / 2;
            videoindex = len - 1;
        }
        videoindex++;
        var str = '<div class="layui-form-item">\n' +
            '                    <label for="L_phone" class="layui-form-label">作品介绍：</label>\n' +
            '                    <div class="layui-input-inline" style="width: 80%">\n' +
            '                        <input type="hidden" value="" name="video[tid]['+videoindex+']">\n' +
            '                        <textarea name="video[sOpusInfo]['+videoindex+']" id="" cols="75" rows="10" lay-verify="required"></textarea>\n' +
            '                    </div>\n' +
            '                </div>';
        str += '<div class="layui-form-item">\n' +
            '                        <label for="L_phone" class="layui-form-label">视  频：</label>\n' +
            '                        <div class="layui-input-inline" style="width: 80%">\n' +
            '                            <input type="hidden" name="UploadForm[videoFile]" value="">\n' +
            '                            <input type="hidden" name="video[sTrainUrl]['+videoindex+']" value="" class="sTrainUrl'+videoindex+'">\n' +
            '                            <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,\'video\','+videoindex+')">\n' +
            '                            <span class="videos'+videoindex+'" style="display:none"></span>\n' +
            '                            <button type="button" class="layui-btn" data-title="删除" onclick="deleteClassVideo(this)" style="margin-left: 1rem;margin-bottom: 3rem"><i class="layui-icon"></i>删除</button>\n' +
            '                        </div>\n' +
            '                    </div>';
        $("#video").append(str);
    }

    function deleteClassVideo(that) {
        $(that).parent().parent().prev('.layui-form-item').remove();
        $(that).parent().parent().remove();
    }

    function uploadFile(that,file,index)
    {
        var url = 'index.php?r=web/upload/upload';
        if(file == 'video')
        {
            var url = 'index.php?r=web/upload/video';
        }

        $(that).fileupload({
            dataType: 'json',
            url: url,
            success: function (json) {
                if(json.code == 0){
                    if(file == 'video')
                    {
                        $(".sTrainUrl"+index).val(json.data.url);
                        $(".videos"+index).text(json.data.url);
                        $(".videos"+index).css('display','block');
                    }else{
                        $(".sBookImg"+index).val(json.data.url);
                        $(".images"+index).attr('src',"<?=Yii::$app->params['imagePath']?>"+json.data.url);
                        $(".images"+index).css('display','block');
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
