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
        <input type="hidden" value="<?=$orgin['id'] ?? '' ?>" name="id">

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">机构名称：</label>
            <div class="layui-input-inline">
                <input type="text" id="sOrginName" value="<?=$orgin['sOrginName'] ?? ''?>"  name="sOrginName" lay-verify="required" autocomplete="off" class="layui-input" maxlength="100">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">所属角色：</label>
            <div class="layui-input-inline">
                <select name="pid" lay-filter="pid">
                    <option value = 0 >所属角色</option>
                    <?php foreach(\app\models\db\BUserbaseinfo::$_preconf as $kc => $pre){?>
                        <option value = <?=$kc?> <?=isset($orgin['pid']) && $orgin['pid'] == $kc ? 'selected' : ''?>><?=$pre?></option>
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
