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
        <a href="">学习视频管理</a>
        <a>
            <cite>学习视频列表</cite></a>
      </span>
</div>
<div class="x-body">
    <xblock>
        <button class="layui-btn" data-title="添加" onclick="x_admin_show('添加','index.php?r=web/admin/videoedit')"><i class="layui-icon"></i>添加</button>
        <button class="layui-btn" id="start">发布到首页</button>
        <button class="layui-btn" id="stop">取消发布到首页</button>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th><input type="checkbox" id="checkboxall" class="layui-unselect header layui-form-checkbox" lay-skin="primary">全选</th>
            <th>学员</th>
            <th>标题</th>
            <th>视频</th>
            <th>是否发布到首页</th>
            <th>操作</th>
        </thead>
        <tbody class="for" align="center">
        <?php foreach($video as $k => $r){?>
            <tr>
                <td><input type="checkbox" name="isRec" lay-skin="primary" value="<?=$r['id']?>" lay-filter="isRec"></td>
                <td><?=$r['sNick']?></td>
                <td><?=$r['sProblemName']?></td>
                <td><?=$r['sVideoUrl']?></td>
                <td><?=\app\models\db\BVideo::$_isRec[$r['isRec']]?></td>
                <td class="td-manage">
                    <a title="编辑" onclick="x_admin_show('编辑','index.php?r=web/admin/videoedit&id=<?=$r['id']?>')" href="javascript:;">【编辑】
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
        $.post('index.php?r=web/admin/releaseindex',{ids:ids,isRec:<?=\app\models\db\BVideo::YES?>,type:'video'},function(data){
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
        $.post('index.php?r=web/admin/releaseindex',{ids:ids,isRec:<?=\app\models\db\BVideo::NO?>,type:'video'},function(data){
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
