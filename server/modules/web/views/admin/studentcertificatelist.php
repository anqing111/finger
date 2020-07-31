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
            <cite>学员录入证书审核</cite></a>
      </span>
</div>
<div class="x-body">
    <table class="layui-table">
        <thead>
        <tr>
            <th>学员</th>
            <th>类别</th>
            <th>证书名称</th>
            <th>证书编号</th>
            <th>获得时间</th>
            <th>所属机构</th>
            <th title="">状态</th>
            <th>审核</th>
            <th>操作</th>
        </thead>
        <tbody class="for" align="center">
        <?php foreach($cate as $k => $r){?>
            <tr>
                <td><?=$r['sNick']?></td>
                <td><?=$r['subjectName']?></td>
                <td><?=$r['sName']?></td>
                <td><?=$r['sCertificateNum']?></td>
                <td><?=$r['dGetDate']?></td>
                <td><?=$r['sOrganName']?></td>
                <?php if($r['status'] == \app\models\db\EStudentcertificate::FILED){?>
                    <td title="<?=$r['cause']?>"><?=\app\models\db\EStudentcertificate::$_status[$r['status']]?></td>
                <?php }else{?>
                    <td><?=\app\models\db\EStudentcertificate::$_status[$r['status']]?></td>
                <?php }?>
                <td><a href="" onclick="optionStatus(<?=$r['id']?>,<?=\app\models\db\EStudentcertificate::PASSED?>)"><i class="layui-icon">[通过]</i></a>|
                    <a title="驳回" onclick="x_admin_show('驳回原因','index.php?r=web/admin/authregect&id=<?=$r["id"]?>&param=studentcertificateindex',($(window).width()*0.5),($(window).height() - 200))" href="javascript:;">
                        <i class="layui-icon">[不通过]</i>
                    </a>
                </td>
                <td><a href="<?=Yii::$app->params['imagePath'].$r['sCertificateImg']?>" target="_blank">查看证书</a></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
</body>
<script>
    function optionStatus(id,status) {
        $.ajax({
            url:'index.php?r=web/admin/cateedit',
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
