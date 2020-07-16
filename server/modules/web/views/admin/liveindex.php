<?php
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>

<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">直播管理</a>
        <a>
            <cite>直播列表</cite></a>
      </span>
</div>
<div class="x-body">
    <table class="layui-table">
        <thead>
        <tr>
            <th>序号</th>
            <th>直播间id</th>
            <th>直播间名称</th>
            <th>直播开始时间</th>
            <th>模版</th>
            <th>状态</th>
            <th>推流类型</th>
            <th>操作</th>
        </thead>
        <tbody class="for" align="center">
        <?php foreach($cclive as $k => $r){?>
            <tr>
                <td><?=($k+1)?></td>
                <td><?=$r['id']?></td>
                <td><?=$r['name']?></td>
                <td><?=$r['liveStartTime']?></td>
                <td><?=\app\models\db\BCclive::$_templateType[$r['templateType']]?></td>
                <td><?=\app\models\db\BCclive::$_status[$r['status']]?></td>
                <td>客户端推流</td>
                <td class="td-manage">
                    <a title="详情" onclick="x_admin_show('详情','index.php?r=web/admin/liveinfo&cid=<?=$r['cid']?>')" href="javascript:;">【详情】
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
