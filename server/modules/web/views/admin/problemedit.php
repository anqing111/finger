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
        <input type="hidden" value="<?=$problem['id'] ?? '' ?>" name="id">

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">题目名称：</label>
            <div class="layui-input-inline">
                <input type="text" id="sProblemName" value="<?=$problem['sProblemName'] ?? ''?>"  name="sProblemName" lay-verify="required" autocomplete="off" class="layui-input" maxlength="100">
            </div>
        </div>

        <input type="hidden" id="sIndustryName" value="<?=$problem['sIndustryName'] ?? ''?>"  name="sIndustryName">

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">所属类型：</label>
            <div class="layui-input-inline">
                <select name="tid" id="tid" lay-filter="tid">
                    <option value = 0 >选择行业类型</option>
                    <?php foreach($industr as $kc => $pre){?>
                        <option value = <?=$pre->id?> <?=isset($problem['tid']) && $problem['tid'] == $pre->id ? 'selected' : ''?>><?=$pre->sIndustryName?></option>
                    <?php }?>
                </select>
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

        form.on('select(tid)', function(data){
            $("#sIndustryName").val(data.elem[data.elem.selectedIndex].text);
            form.render('select');
        });

        form.on('submit(save)', function(data){
            if($("#tid").val() == 0)
            {
                layer.msg('请选择行业类型');
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
