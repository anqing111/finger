<?php
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>

<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">课程管理</a>
        <a>
            <cite>课程列表</cite></a>
      </span>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="" method="post" id="form">
            <input type="text" class="layui-input" placeholder="课程名称" name="sCourseName" id="sCourseName" value="<?=$post['sCourseName'] ?? ''?>">
            <input type="text" class="layui-input" placeholder="作者" name="author" id="author" value="<?=$post['author'] ?? ''?>">
            <input type="submit" class="layui-btn" value="查询" id="search">
        </form>
    </div>
    <xblock>
        <button class="layui-btn" data-title="添加" onclick="x_admin_show('添加','index.php?r=web/admin/courseedit')"><i class="layui-icon"></i>添加</button>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>序号</th>
            <th>课程名称</th>
            <th>作者</th>
            <th>课时</th>
            <th>录制时间</th>
            <th>类别</th>
            <th>状态</th>
            <th>操作</th>
        </thead>
        <tbody class="for" align="center">
        <?php foreach($course as $k => $r){?>
            <tr>
                <td><?=($k+1)?></td>
                <td><?=$r['sCourseName']?></td>
                <td><?=$r['author']?></td>
                <td><?=$r['classhour']?></td>
                <td><?=$r['dRecordingTime']?></td>
                <td><?=\app\models\db\BCourse::$_type[$r['type']]?></td>
                <td><?=\app\models\db\BCourse::$_status[$r['status']]?></td>
                <td class="td-manage">
                    <?php if($r['status'] == \app\models\db\BCourse::UNRELEASED || $r['status'] == \app\models\db\BCourse::OFFTHESHELF){?>
                        <a title="发布" onclick="optionStatus(<?=$r['id']?>,<?=\app\models\db\BCourse::PUBLISHED?>)" href="javascript:;">【发布】
                        </a>
                    <?php }else{?>
                        <a title="下架" onclick="optionStatus(<?=$r['id']?>,<?=\app\models\db\BCourse::OFFTHESHELF?>)" href="javascript:;">【下架】
                        </a>
                    <?php }?>
                    <a title="详情" href="index.php?r=web/admin/courseinfo&id=<?=$r['id']?>">【详情】
                    </a>
                    <a title="编辑" onclick="x_admin_show('编辑','index.php?r=web/admin/courseedit&id=<?=$r['id']?>')" href="javascript:;">【编辑】
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
            url:'index.php?r=web/admin/courseedit',
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
