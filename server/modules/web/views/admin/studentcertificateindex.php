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
        <a href="">证书管理</a>
      </span>
</div>
<div class="x-body">
    <xblock>
        <button class="layui-btn" data-title="添加" onclick="x_admin_show('添加','index.php?r=web/admin/cateedit')"><i class="layui-icon"></i>添加</button>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>学员</th>
            <th>类别</th>
            <th>证书名称</th>
            <th>证书编号</th>
            <th>获得时间</th>
            <th>所属机构</th>
            <th>状态</th>
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
                <td><?=\app\models\db\EStudentcertificate::$_status[$r['status']]?></td>
                <td class="td-manage">
                    <a title="编辑" onclick="x_admin_show('编辑','index.php?r=web/admin/cateedit&id=<?=$r['id']?>')" href="javascript:;">【编辑】
                    </a>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
</body>
<?php
$this->endContent();
?>
