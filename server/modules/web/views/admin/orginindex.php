<?php
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>

<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">机构管理</a>
        <a>
            <cite>机构列表</cite></a>
      </span>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="" method="post" id="form">
            <input type="text" class="layui-input" placeholder="机构名称" name="sOrginName" id="sOrginName" value="<?=$post['sOrginName'] ?? ''?>">
            <input type="submit" class="layui-btn" value="查询" id="search">
        </form>
    </div>
    <xblock>
        <button class="layui-btn" data-title="添加" onclick="x_admin_show('添加','index.php?r=web/admin/orginedit')"><i class="layui-icon"></i>添加</button>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>序号</th>
            <th>角色</th>
            <th>机构名称</th>
            <th>操作</th>
        </thead>
        <tbody class="for" align="center">
        <?php foreach($orgin as $k => $r){?>
            <tr>
                <td><?=($k+1)?></td>
                <td><?=\app\models\db\BUserbaseinfo::$_preconf[$r['pid']]?></td>
                <td><?=$r['sOrginName']?></td>
                <td class="td-manage">
                    <a title="编辑" onclick="x_admin_show('编辑','index.php?r=web/admin/orginedit&id=<?=$r['id']?>')" href="javascript:;">【编辑】
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
