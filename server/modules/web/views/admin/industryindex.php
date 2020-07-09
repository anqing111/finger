<?php
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>

<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">专业管理</a>
        <a>
            <cite>行业类别</cite></a>
      </span>
</div>
<div class="x-body">
    <xblock>
        <button class="layui-btn" data-title="添加" onclick="x_admin_show('添加','index.php?r=web/admin/industryedit')"><i class="layui-icon"></i>添加</button>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>序号</th>
            <th>行业名称</th>
            <th>子行业名称</th>
            <th>操作</th>
        </thead>
        <tbody class="for" align="center">
        <?php foreach($industr as $k => $r){?>
            <tr>
                <td><?=($k+1)?></td>
                <td><?=$r['sIndustryName']?></td>
                <td><?=$r['cName']?></td>
                <td class="td-manage">
                    <a title="编辑" onclick="x_admin_show('编辑','index.php?r=web/admin/industryedit&id=<?=$r['id']?>')" href="javascript:;">【编辑】
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
