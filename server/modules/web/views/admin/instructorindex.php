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
        <a href="">讲师秀</a>
      </span>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="" method="post" id="form">
            <input type="text" class="layui-input" placeholder="姓名" name="sName" id="sName" value="<?=$post['sName'] ?? ''?>">
            <input type="submit" class="layui-btn" value="查询" id="search">
        </form>
    </div>
    <xblock>
        <button class="layui-btn" data-title="添加" onclick="x_admin_show('添加','index.php?r=web/admin/instructoredit')"><i class="layui-icon"></i>添加</button>
        <button class="layui-btn" id="start">发布到首页</button>
        <button class="layui-btn" id="stop">取消发布到首页</button>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th><input type="checkbox" id="checkboxall" class="layui-unselect header layui-form-checkbox" lay-skin="primary">全选</th>
            <th>序号</th>
            <th>姓名</th>
            <th>工作经验</th>
            <th>简介</th>
            <th>发布到首页</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody class="for" align="center">
        <?php foreach($instructor as $k => $r){?>
            <tr>
                <td><input type="checkbox" name="isRec" lay-skin="primary" value="<?=$r['id']?>" lay-filter="isRec"></td>
                <td><?=($k+1)?></td>
                <td><?=$r['sName']?></td>
                <td><?=$r['year']?>年</td>
                <td><?=mb_substr($r['info'],0,30)?>......</td>
                <td><?=\app\models\db\EInstructor::$_isRec[$r['isRec']]?></td>
                <td class="td-manage">
                    <a title="编辑" onclick="x_admin_show('编辑','index.php?r=web/admin/instructoredit&id=<?=$r['id']?>')" href="javascript:;">【编辑】
                    </a>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
</body>
<script>

    $("#checkboxall").click(function(){
        if($(this).is(':checked')){
            $("input[name=isRec]").each(function(){
                this.checked=true;
            })
        }else{
            $("input[name=isRec]").each(function(){
                this.checked=false;
            })
        }
    });

    $('#start').on('click',function(){
        var arr = new Array()
        $("input:checkbox[name=isRec]:checked").each(function(i){
            arr[i] = $(this).val();
        });
        var ids = arr.join(",");
        $.post('index.php?r=web/admin/releaseindex',{ids:ids,isRec:<?=\app\models\db\EInstructor::YES?>,type:'instructor'},function(data){
            var dataObj = JSON.parse(data);
            if(dataObj.code == 0){
                layer.alert('发布到首页成功', function(index){
                    location.reload();
                    layer.close(index);
                });
            }else{
                layer.alert(dataObj.msg);
            }
        })
    })

    $('#stop').on('click',function(){
        var arr = new Array()
        $("input:checkbox[name=isRec]:checked").each(function(i){
            arr[i] = $(this).val();
        });
        var ids = arr.join(",");
        $.post('index.php?r=web/admin/releaseindex',{ids:ids,isRec:<?=\app\models\db\EInstructor::NO?>,type:'instructor'},function(data){
            var dataObj = JSON.parse(data);
            if(dataObj.code == 0){
                layer.alert('取消发布到首页成功', function(index){
                    location.reload();
                    layer.close(index);
                });
            }else{
                layer.alert(dataObj.msg);
            }
        })
    })
</script>
<?php
$this->endContent();
?>
