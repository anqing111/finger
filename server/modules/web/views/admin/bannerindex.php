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
        <a href="">Banner管理</a>
        <a>
            <cite>Banner列表</cite></a>
      </span>
</div>
<div class="x-body">
    <xblock>
        <button class="layui-btn" data-title="添加" onclick="x_admin_show('添加','index.php?r=web/admin/banneredit')"><i class="layui-icon"></i>添加</button>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>序号</th>
            <th>标题</th>
            <th>PCUrl</th>
            <th>WapURL</th>
            <th>开始日期</th>
            <th>结束日期</th>
            <th>状态</th>
            <th>操作</th>
        </thead>
        <tbody class="for" align="center">
        <?php foreach($banner as $k => $r){?>
            <tr>
                <td><?=($k+1)?></td>
                <td><?=$r['name']?></td>
                <td><?=$r['url']?></td>
                <td><?=$r['wapUrl']?></td>
                <td><?=$r['date_from']?></td>
                <td><?=$r['date_to']?></td>
                <td><?=\app\models\db\BBanner::$_status[$r['status']]?></td>
                <td class="td-manage">
                    <?php if($r['status'] == \app\models\db\BBanner::UNRELEASED || $r['status'] == \app\models\db\BBanner::OFFTHESHELF){?>
                        <a title="发布" onclick="optionStatus(<?=$r['id']?>,<?=\app\models\db\BBanner::PUBLISHED?>)" href="javascript:;">【发布】
                        </a>
                    <?php }else{?>
                        <a title="下架" onclick="optionStatus(<?=$r['id']?>,<?=\app\models\db\BBanner::OFFTHESHELF?>)" href="javascript:;">【下架】
                        </a>
                    <?php }?>
                    <a title="编辑" onclick="x_admin_show('编辑','index.php?r=web/admin/banneredit&id=<?=$r['id']?>')" href="javascript:;">【编辑】
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
            url:'index.php?r=web/admin/banneredit',
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
