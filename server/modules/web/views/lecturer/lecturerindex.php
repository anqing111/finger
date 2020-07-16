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
    <xblock>
        <?php if(!empty($lecturer['id'])){?>
            <button class="layui-btn" data-title="编辑" onclick="x_admin_show('编辑','index.php?r=web/lecturer/lectureredit&id=<?=$lecturer['id']?>')"><i class="layui-icon"></i>编辑</button>
        <?php }else{?>
            <button class="layui-btn" data-title="添加" onclick="x_admin_show('添加','index.php?r=web/lecturer/lectureredit')"><i class="layui-icon"></i>添加</button>
        <?php }?>
    </xblock>
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
                <td><?=\app\models\db\ELecturer::$_status[$lecturer['status']]?></td>
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
<?php
$this->endContent();
?>
