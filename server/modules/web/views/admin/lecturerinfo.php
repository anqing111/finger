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
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">个人简介</a>
      </span>
</div>
<div class="x-body">
    <h1>基础信息</h1>
    <?php if(!empty($lecturer)){?>
        <table class="layui-table">
            <thead>
            <th>姓名</th>
            <th>性别</th>
            <th>证书</th>
            <th>审核状态</th>
            </thead>
            <tbody>
            <tr>
                <td><?=$lecturer['sName']?></td>
                <td><?=\app\models\db\ELecturer::$_sex[$lecturer['sex']]?></td>
                <td><a href="<?=Yii::$app->params['imagePath'].$lecturer['certificate']?>" target="_blank">查看证书</a></td>
                <?php if($lecturer['status'] == \app\models\db\ELecturer::UNRELEASED){?>
                    <td><a href="" onclick="optionStatus(<?=$lecturer['id']?>,<?=\app\models\db\ELecturer::PUBLISHED?>)"><i class="layui-icon">[通过]</i></a>|
                        <a title="驳回" onclick="x_admin_show('驳回原因','index.php?r=web/admin/authregect&id=<?=$lecturer["id"]?>&param=lecturer',($(window).width()*0.5),($(window).height() - 200))" href="javascript:;">
                            <i class="layui-icon">[不通过]</i>
                        </a>
                <?php }else{?>
                    <td><?=\app\models\db\ELecturer::$_status[$lecturer['status']]?></td>
                <?php }?>

            </tr>

            </tbody>
        </table>
        <hr>
        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">头  像：</label>
            <div class="layui-input-inline" style="width: 80%">
                <img class="headportrait" src="<?=Yii::$app->params['imagePath'].$lecturer['headportrait']?>" alt="" style="margin-bottom: 10px;width: 24%;height: 200px">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_mail" class="layui-form-label">个人简介：</label>
            <div class="layui-input-inline">
                <textarea name="info" id="" cols="75" rows="10" lay-verify="required"><?=$lecturer['info'] ?? ''?></textarea>
            </div>
        </div>
        <?php if($lecturer['status'] == \app\models\db\ELecturer::OFFTHESHELF){?>
            <div class="layui-form-item">
                <label for="L_mail" class="layui-form-label">审核未通过原因：</label>
                <div class="layui-input-inline">
                    <textarea name="cause" id="" cols="75" rows="10" lay-verify="required"><?=$lecturer['cause'] ?? ''?></textarea>
                </div>
            </div>
        <?php }?>

    <?php }?>
</div>
</body>
<script>
    function optionStatus(id,status) {
        $.ajax({
            url:'index.php?r=web/lecturer/lectureredit',
            type:'POST',
            data: {id:id,status:status},
            dataType:'json',
            success:function(jsonObj){
                if(jsonObj.code == 0){
                    location.reload();
                }else{
                    layer.msg(jsonObj.msg);

                }
            }
        })
    }
</script>
<?php
$this->endContent();
?>
