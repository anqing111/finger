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
            <th>姓名</th>
            <th>身份证号</th>
            <th>邮箱</th>
            <th>手机号</th>
            <th>状态</th>
            <th>操作</th>
        </thead>
        <tbody class="for" align="center">
        <?php foreach($profile as $k => $r){?>
            <tr>
                <td><?=($k+1)?></td>
                <td><?=$r['name']?></td>
                <td><?=$r['idcard']?></td>
                <td><?=$r['sMail']?></td>
                <td><?=$r['sPhone']?></td>
                <td><?=\app\models\db\EStudentprofile::$_status[$r['status']]?></td>
                <td class="td-manage">
                    <a title="详情" onclick="x_admin_show('详情','index.php?r=web/orgin/studentprofileinfo&id=<?=$r['id']?>')" href="javascript:;">【详情】
                    </a>
                    <a title="编辑" onclick="x_admin_show('编辑','index.php?r=web/orgin/studentprofileedit&id=<?=$r['id']?>')" href="javascript:;">【编辑】
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
