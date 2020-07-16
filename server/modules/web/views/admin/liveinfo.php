<?php
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>
<style>
    h1{
        font-size: 20px;padding: 1rem;font-weight: 900;
    }
</style>
<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">直播间列表详情</a>
      </span>
</div>
<div class="x-body">
    <h1>基础信息</h1>
    <table class="layui-table">
        <thead>
        <th>直播间id</th>
        <th>直播间名称</th>
        <th>直播开始时间</th>
        <th>模版</th>
        <th>状态</th>
        <th>推流类型</th>
        </thead>
        <tbody>
        <tr>
            <td><?=$cclive['id']?></td>
            <td><?=$cclive['name']?></td>
            <td><?=$cclive['liveStartTime']?></td>
            <td><?=\app\models\db\BCclive::$_templateType[$cclive['templateType']]?></td>
            <td><?=\app\models\db\BCclive::$_status[$cclive['status']]?></td>
            <td>客户端推流</td>
        </tr>
        </tbody>
        <thead>
        <th>直播间描述</th>
        <th>播放端密码</th>
        <th>助教密码</th>
        <th>验证类型</th>
        <th>是否开启弹幕</th>
        <th>播放器提示语</th>
        </thead>
        <tbody>
        <tr>
            <td><?=$cclive['desc']?></td>
            <td><?=$cclive['playPass']?></td>
            <td><?=$cclive['assistantPass']?></td>
            <td><?=\app\models\db\BCclive::$_authType[$cclive['authType']]?></td>
            <td><?=\app\models\db\BCclive::$_barrage[$cclive['barrage']]?></td>
            <td><?=$cclive['playerBackgroundHint']?></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
<?php
$this->endContent();
?>
