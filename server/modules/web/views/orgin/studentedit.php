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
        <input type="hidden" value="<?=$user['iUserID'] ?? '' ?>" name="iUserID">
        <input type="hidden" value="<?=$baseinfo['oid'] ?? '' ?>" name="oid">
        <input type="hidden" value="<?=$baseinfo['gid'] ?? '' ?>" name="gid">

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">姓  名：</label>
            <div class="layui-input-inline">
                <input type="text" id="sNick" value="<?=$user['sNick'] ?? ''?>"  name="sNick" lay-verify="required" autocomplete="off" class="layui-input" maxlength="30">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_mail" class="layui-form-label">邮  箱：</label>
            <div class="layui-input-inline">
                <input type="text" id="sMail" value="<?=$user['sMail'] ?? ''?>"  name="sMail" lay-verify="required|mail" autocomplete="off" class="layui-input" maxlength="30">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">手 机 号：</label>
            <div class="layui-input-inline">
                <input type="text" id="sPhone" value="<?=$user['sPhone'] ?? ''?>"  name="sPhone" lay-verify="required|phone" autocomplete="off" class="layui-input" maxlength="11">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">身份证号：</label>
            <div class="layui-input-inline">
                <input type="text" id="idcard" value="<?=$user['idcard'] ?? ''?>"  name="idcard" lay-verify="required" autocomplete="off" class="layui-input" maxlength="18">
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

        //自定义验证规则
        form.verify({
            password: [/^$|[\S]{6,12}$/, '长度为6-12位字符'],
            mail: [/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i, '邮箱格式不正确'],
            phone: [/^1[23456789]{1}\d{9}$/, '请输入正确手机号']
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
