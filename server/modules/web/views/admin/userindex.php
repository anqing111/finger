<?php
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>

<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">用户管理</a>
        <a>
            <cite>用户列表</cite></a>
      </span>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="" method="post" id="form">
            <input type="text" class="layui-input" placeholder="邮箱" name="sMail" id="sMail" value="<?=$post['sMail'] ?? ''?>">
            <input type="text" class="layui-input" placeholder="手机号" name="sPhone" id="sPhone" value="<?=$post['sPhone'] ?? ''?>">
            <input type="submit" class="layui-btn" value="查询" id="search">
        </form>
    </div>
    <xblock>
        <button class="layui-btn" data-title="添加" onclick="x_admin_show('添加','index.php?r=web/admin/useredit')"><i class="layui-icon"></i>添加</button>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>序号</th>
            <th>用户名</th>
            <th>邮箱</th>
            <th>手机号</th>
            <th>用户类型</th>
            <th>用户角色</th>
            <th>所属机构</th>
            <th>操作</th>
        </thead>
        <tbody class="for" align="center">
        <?php foreach($user as $k => $r){

            $orginL = \app\models\db\EOrgin::find()->where(['id'=>$r->oid])->one();

            ?>
            <tr>
                <td><?=($k+1)?></td>
                <td><?=$r['sNick']?></td>
                <td><?=$r['sMail']?></td>
                <td><?=$r['sPhone']?></td>
                <td><?=\app\models\db\BUserbaseinfo::$_userLevel[$r['userLevel']]?></td>
                <td><?=\app\models\db\BUserbaseinfo::$_preconf[$r['pid']]?></td>
                <td><?=$orginL->sOrginName?></td>
                <td class="td-manage">
                    <a title="详情" onclick="x_admin_show('详情','index.php?r=web/admin/userinfo&iUserID=<?=$r['iUserID']?>')" href="javascript:;">【详情】
                    </a>
                    <a title="编辑" onclick="x_admin_show('编辑','index.php?r=web/admin/useredit&iUserID=<?=$r['iUserID']?>')" href="javascript:;">【编辑】
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
