<?php
use app\assets\AppAsset;
use yii\helpers\Url;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>
<style>
    h1{
        font-size: 20px;padding: 1rem;font-weight: 900;
    }
    h5{
        font-size: 14px;padding: 1rem;
    }
</style>
<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">用户详情页</a>
      </span>
</div>
<div class="x-body">
    <h1>基础信息</h1>
    <?php if(!empty($userBaseInfo)){?>
        <table class="layui-table">
            <thead>
            <th>用户名</th>
            <th>用户角色</th>
            <th>身份证号</th>
            <th>邮箱</th>
            <th>手机号</th>
            <th>密码</th>
            </thead>
            <tbody>
            <tr>
                <td><?=$userBaseInfo['sNick']?></td>
                <td><?=\app\models\db\BUserbaseinfo::$_preconf[$userBaseInfo['pid']]?></td>
                <td><?=$userBaseInfo['idcard']?></td>
                <td><?=$userBaseInfo['sMail']?></td>
                <td><?=$userBaseInfo['sPhone']?></td>
                <td><?=$userBaseInfo['sPassWord']?></td>
            </tr>
            </tbody>
        </table>
    <?php }?>
</div>
</body>
<?php
$this->endContent();
?>
