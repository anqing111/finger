<?php
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>

<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">学员档案信息管理</a>
        <a>
            <cite>学员档案信息列表</cite></a>
      </span>
</div>
<div class="x-body">
    <xblock>
        <button class="layui-btn" data-title="添加" onclick="x_admin_show('添加','index.php?r=web/orgin/studentprofileedit')"><i class="layui-icon"></i>添加</button>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>序号</th>
            <th>企业或机构名称</th>
            <th>姓名</th>
            <th>身份证号</th>
            <th>邮箱</th>
            <th>手机号</th>
            <th>状态</th>
            <th>审核</th>
            <th>操作</th>
        </thead>
        <tbody class="for" align="center">
        <?php foreach($profile as $k => $r){?>
            <tr>
                <td><?=($k+1)?></td>
                <td><?=$r['sOrginName']?></td>
                <td><?=$r['name']?></td>
                <td><?=$r['idcard']?></td>
                <td><?=$r['sMail']?></td>
                <td><?=$r['sPhone']?></td>
                <td><?=\app\models\db\EStudentprofile::$_status[$r['status']]?></td>
                <td><a href="" onclick="optionStatus(<?=$r['id']?>,<?=\app\models\db\EStudentprofile::PASSED?>)"><i class="layui-icon">[通过]</i></a>|
                    <a href="" onclick="optionStatus(<?=$r['id']?>,<?=\app\models\db\EStudentprofile::PASSEDREADY?>)"><i class="layui-icon">[审核通过-制证状态]</i></a>|
                    <a href="" onclick="optionStatus(<?=$r['id']?>,<?=\app\models\db\EStudentprofile::PASSEDSEND?>)"><i class="layui-icon">[审核通过-证书已发出]</i></a>|
                    <a title="驳回" onclick="x_admin_show('驳回原因','index.php?r=web/admin/authregect&id=<?=$r["id"]?>&param=studentprofile',($(window).width()*0.5),($(window).height() - 200))" href="javascript:;">
                        <i class="layui-icon">[不通过]</i>
                    </a>
                </td>
                <td class="td-manage">
                    <a title="详情" onclick="x_admin_show('详情','index.php?r=web/admin/studentprofileedit&id=<?=$r['id']?>')" href="javascript:;">【详情】
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
            url:'index.php?r=web/admin/studentprofileedit',
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
