<?php
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>

<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">学员管理</a>
        <a>
            <cite>学员列表</cite></a>
      </span>
</div>
<div class="x-body">
    <xblock>
        <button class="layui-btn" data-title="添加" onclick="x_admin_show('添加','index.php?r=web/orgin/useredit')"><i class="layui-icon"></i>添加</button>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>序号</th>
            <th>用户名</th>
            <th>邮箱</th>
            <th>手机号</th>
            <th>操作</th>
        </thead>
        <tbody class="for" align="center">
        <?php foreach($user as $k => $r){?>
            <tr>
                <td><?=($k+1)?></td>
                <td><?=$r['sNick']?></td>
                <td><?=$r['sMail']?></td>
                <td><?=$r['sPhone']?></td>
                <td class="td-manage">
                    <a title="详情" onclick="x_admin_show('详情','index.php?r=web/admin/userinfo&iUserID=<?=$r['iUserID']?>')" href="javascript:;">【详情】
                    </a>
                    <a title="编辑" onclick="x_admin_show('编辑','index.php?r=web/orgin/useredit&iUserID=<?=$r['iUserID']?>')" href="javascript:;">【编辑】
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
