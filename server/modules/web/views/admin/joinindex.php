<?php
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>
<style>
    .layui-table thead tr th{
        text-align: center;
    }
</style>
<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">审核管理</a>
          <a>
            <cite>申请加盟审核</cite></a>
      </span>
</div>
<div class="x-body">
    <table class="layui-table">
        <thead>
        <tr>
            <th>序号</th>
            <th>加盟编号</th>
            <th>单位名称</th>
            <th>负责人</th>
            <th>手机号</th>
            <th>加盟方向</th>
            <th>邮箱</th>
            <th>默认密码</th>
            <th>城市名称</th>
            <th>状态</th>
            <th>审核</th>
        </thead>
        <tbody class="for" align="center">
        <?php foreach($join as $k => $r){

            if(!empty($r->sPassWord))
            {
                $sPassWord = base64_decode($r->sPassWord);
                $r->sPassWord = \Yii::$app->getSecurity()->decryptByPassword($sPassWord, \Yii::$app->params['secretKey']);
            }

            ?>
            <tr>
                <td><?=($k+1)?></td>
                <td><?=$r['joinNum']?></td>
                <td><?=$r['sUnitName']?></td>
                <td><?=$r['person']?></td>
                <td><?=$r['sPhone']?></td>
                <td><?=$r['direction']?></td>
                <td><?=$r['sMail']?></td>
                <td><?=$r['sPassWord']?></td>
                <td><?=$r['sCityName']?></td>
                <?php if($r['status'] == \app\models\db\BJoin::FILED){?>
                    <td title="<?=$r['cause']?>"><?=\app\models\db\BJoin::$_status[$r['status']]?></td>
                <?php }else{?>
                    <td><?=\app\models\db\BJoin::$_status[$r['status']]?></td>
                <?php }?>
                <td><a href="" onclick="optionStatus(<?=$r['id']?>,<?=\app\models\db\BJoin::PASSED?>)"><i class="layui-icon">[通过]</i></a>|
                    <a title="驳回" onclick="x_admin_show('驳回原因','index.php?r=web/admin/authregect&id=<?=$r["id"]?>&param=joinindex',($(window).width()*0.5),($(window).height() - 200))" href="javascript:;">
                        <i class="layui-icon">[不通过]</i>
                    </a>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
</body>
<script>
    function optionStatus(id,status) {
        $.ajax({
            url:'index.php?r=web/admin/joinedit',
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
