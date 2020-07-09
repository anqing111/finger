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
        <input type="hidden" value="<?=$industr[0]['id'] ?? '' ?>" name="id">

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">行业名称：</label>
            <div class="layui-input-inline">
                <input type="text" value="<?=$industr[0]['sIndustryName'] ?? ''?>"  name="sIndustryName" lay-verify="required" autocomplete="off" class="layui-input" maxlength="100">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_remarks" class="layui-form-label">子类名称：</label>
            <div id="sIndustryName" class="layui-input-inline" style="border: 1px solid #e2e2e2;width: 50%">
                <br>
                <xblock style="background-color:#fff;text-align: right"><button type="button" class="layui-btn" data-title="添加" onclick="insertClass()"><i class="layui-icon"></i>添加</button></xblock>
                <?php if(!empty($industr)){?>
                    <?php foreach($industr as $k => $r){?>

                        <?php if($k == 0){?>
                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">行业名称：</label>
                                <div class="layui-input-inline" style="width: 80%">
                                    <input type="hidden" value="<?=$r['cid']?>" name="child[industryID][]">
                                    <input type="text" value="<?=$r['cName']?>" name="child[sIndustryName][]" lay-verify="required" autocomplete="off" class="layui-input" style="float: left;width: 80%">
                                </div>
                            </div>
                        <?php }else{?>
                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">行业名称：</label>
                                <div class="layui-input-inline" style="width: 80%">
                                    <input type="hidden" value="<?=$r['cid']?>" name="child[industryID][]">
                                    <input type="text" value="<?=$r['cName']?>" name="child[sIndustryName][]" lay-verify="required" autocomplete="off" class="layui-input" style="float: left;width: 80%">
                                    <button type="button" class="layui-btn" data-title="删除" onclick="deleteClass(this)" style="margin-left: 1rem"><i class="layui-icon"></i>删除</button>
                                </div>
                            </div>
                        <?php }?>

                    <?php }?>
                <?php }else{?>
                    <div class="layui-form-item">
                        <label for="L_phone" class="layui-form-label">行业名称：</label>
                        <div class="layui-input-inline" style="width: 80%">
                            <input type="hidden" value="" name="child[industryID][]">
                            <input type="text" value="" name="child[sIndustryName][]" lay-verify="required" autocomplete="off" class="layui-input" style="float: left;width: 80%">
                        </div>
                    </div>
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

    function insertClass() {
        var str = '<div class="layui-form-item">\n' +
            '                    <label for="L_phone" class="layui-form-label">行业名称：</label>\n' +
            '                    <div class="layui-input-inline" style="width: 80%">\n' +
            '                        <input type="hidden" value="" name="child[industryID][]">\n' +
            '                        <input type="text" value="" lay-verify="required" name="child[sIndustryName][]" autocomplete="off" class="layui-input" style="float: left;width: 80%">\n' +
            '                        <button type="button" class="layui-btn" data-title="删除" onclick="deleteClass(this)" style="margin-left: 1rem"><i class="layui-icon"></i>删除</button>\n' +
            '                    </div>\n' +
            '                </div>';
        $("#sIndustryName").append(str);
    }

    function deleteClass(that) {
        $(that).parent().parent().remove();
    }

</script>
<?php
$this->endContent();
?>
