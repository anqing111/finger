<?php
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>

<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">文章管理</a>
          <a>
            <cite>
            <?php if($type == \app\models\db\BArticle::INFORMATION_TYPE){?>
                网站资讯类文章
            <?php }else if($type == \app\models\db\BArticle::TECHNICAL_TYPE){?>
                技能薪酬类文章
            <?php }else{?>
                全部文章
            <?php }?>
            </cite></a>
      </span>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="" method="post" id="form">
            <input type="text" class="layui-input" placeholder="标题" name="title" id="title" value="<?=$post['title'] ?? ''?>">
            <div class="layui-input-inline">
                <select id="type" name="type" lay-filter="type" lay-verify="required">
                    <option value = 0 >文章类型</option>
                    <?php foreach(\app\models\db\BArticle::$_type as $kc => $pre){?>
                        <option value = <?=$kc?> <?=$type == $kc ? 'selected' : ''?> ><?=$pre?></option>
                    <?php }?>
                </select>
            </div>

            <div class="layui-input-inline">
                <select id="status" name="status" lay-filter="status" lay-verify="required">
                    <option value = 0 >发布状态</option>
                    <?php foreach(\app\models\db\BArticle::$_status as $ks => $ps){?>
                        <option value = <?=$ks?> <?=isset($post['status']) && $post['status'] == $ks ? 'selected' : ''?> ><?=$ps?></option>
                    <?php }?>
                </select>
            </div>
            <input type="submit" class="layui-btn" value="查询" id="search">
        </form>
    </div>
    <xblock>
        <button class="layui-btn" data-title="添加" onclick="x_admin_show('添加','index.php?r=web/admin/articleedit')"><i class="layui-icon"></i>添加</button>
        <button class="layui-btn" id="start">发布到首页</button>
        <button class="layui-btn" id="stop">取消发布到首页</button>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th><input type="checkbox" id="checkboxall" class="layui-unselect header layui-form-checkbox" lay-skin="primary">全选</th>
            <th>序号</th>
            <th>标题</th>
            <th>作者</th>
            <th>点击量</th>
            <th>发布时间</th>
            <th>状态</th>
            <th>是否发布到首页</th>
            <th>是否热门</th>
            <th>操作</th>
        </thead>
        <tbody class="for" align="center">
        <?php foreach($article as $k => $r){?>
            <tr>
                <td><input type="checkbox" name="isRec" lay-skin="primary" value="<?=$r['id']?>" lay-filter="isRec"></td>
                <td><?=($k+1)?></td>
                <td><?=$r['title']?></td>
                <td><?=$r['author']?></td>
                <td><?=$r['click']?></td>
                <td><?=$r['dReleaseTime']?></td>
                <td><?=\app\models\db\BArticle::$_status[$r['status']]?></td>
                <td><?=\app\models\db\BArticle::$_isRec[$r['isRec']]?></td>
                <td><?=\app\models\db\BArticle::$_isHot[$r['isHot']]?></td>
                <td class="td-manage">
                    <?php if($r['status'] == \app\models\db\BArticle::UNRELEASED || $r['status'] == \app\models\db\BArticle::OFFTHESHELF){?>
                        <a title="发布" onclick="optionStatus(<?=$r['id']?>,<?=\app\models\db\BArticle::PUBLISHED?>,<?=$r['type']?>)" href="javascript:;">【发布】
                        </a>
                    <?php }else{?>
                        <a title="下架" onclick="optionStatus(<?=$r['id']?>,<?=\app\models\db\BArticle::OFFTHESHELF?>,<?=$r['type']?>)" href="javascript:;">【下架】
                        </a>
                    <?php }?>

                    <a title="编辑" onclick="x_admin_show('编辑','index.php?r=web/admin/articleedit&id=<?=$r['id']?>')" href="javascript:;">【编辑】
                    </a>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
</body>
<script>
    function optionStatus(id,status,type) {
        $.ajax({
            url:'index.php?r=web/admin/articleedit',
            type:'POST',
            data: {id:id,status:status,type:type},
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
        $.post('index.php?r=web/admin/releaseindex',{ids:ids,isRec:<?=\app\models\db\BArticle::YES?>,type:'article'},function(data){
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
        $.post('index.php?r=web/admin/releaseindex',{ids:ids,isRec:<?=\app\models\db\BArticle::NO?>,type:'article'},function(data){
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
