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

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">用 户 名：</label>
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
                <input type="text" id="sPhone" value="<?=$user['sPhone'] ?? ''?>"  name="sPhone" lay-verify="required|phone" autocomplete="off" class="layui-input" maxlength="30">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">用户角色：</label>
            <div class="layui-input-inline">
                <select id="pid" name="pid" lay-filter="pid" lay-verify="required">
                    <option value = 0 >用户角色</option>
                    <?php foreach(\app\models\db\BUserbaseinfo::$_preconf as $kc => $pre){?>
                        <option value = <?=$kc?> <?=isset($user->pid) && $user->pid == $kc ? 'selected' : ''?> ><?=$pre?></option>
                    <?php }?>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">所属机构：</label>
            <div class="layui-input-inline">
                <select id="oid" name="oid" lay-filter="oid" lay-verify="required">
                    <option value = 0>所属机构</option>
                    <?php if(!empty($orginL)){?>
                        <?php foreach($orginL as $ko => $ol){?>
                            <option value = <?=$ol->id?> <?=isset($user->oid) && $user->oid == $ol->id ? 'selected' : ''?> ><?=$ol->sOrginName?></option>
                        <?php }?>
                    <?php }?>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_role" class="layui-form-label">用户类型：</label>
            <div class="layui-input-inline layui-input-inline-distable-mode" style="width: 50%">
                <?php foreach(\app\models\db\BUserbaseinfo::$_userLevel as $kl => $level){?>
                    <input type="radio" value="<?=$kl?>" lay-filter="userLevel" <?=isset($user['userLevel']) && $user['userLevel'] == $kl ? 'checked' : (!isset($user['userLevel']) && $kl == \app\models\db\BUserbaseinfo::COMMON ? 'checked' : '')?> name="userLevel" title="<?=$level?>" >
                <?php }?>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">初始密码：</label>
            <?php if(!empty($user)){?>
                <div class="layui-input-inline">
                    <input type="password" id="sPassWord" name="sPassWord"
                           autocomplete="off" class="layui-input" maxlength="12">
                </div>
                <label class="layui-form-tips">*为空则不修改</label>
            <?php }else{?>
                <div class="layui-input-inline">
                    <input type="password" id="sPassWord" name="sPassWord"  lay-verify="required|password"
                           autocomplete="off" class="layui-input" maxlength="12">
                </div>
                <label class="layui-form-tips">*长度为6-12位字符</label>
            <?php }?>
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

        form.on('select(pid)', function(data){
            var orgin = <?=\yii\helpers\Json::encode($orgin)?>;
            var str = '<option value = 0>所属机构</option>';
            $(orgin).each(function (ids,items) {
                if(parseInt(items.pid) == parseInt(data.value))
                {
                    str += '<option value = '+items.id+'>'+items.sOrginName+'</option>';
                }
            });
            $('#oid').html(str);
            form.render('select');
        });

        //自定义验证规则
        form.verify({
            password: [/^$|[\S]{6,12}$/, '长度为6-12位字符'],
            mail: [/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i, '邮箱格式不正确'],
            phone: [/^1[23456789]{1}\d{9}$/, '请输入正确手机号']
        });

        form.on('submit(save)', function(data){

            if($("#pid").val() == 0)
            {
                layer.msg('请选择用户角色');
                return false;
            }

            if($("#oid").val() == 0)
            {
                layer.msg('请选择所属机构');
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
