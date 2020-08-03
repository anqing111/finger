<?php
use yii\helpers\Html;
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo"><a href="<?=Yii::$app->params['baseUrl']?>">
<!--                <img src="--><?//=Url::to('images/logo.png');?><!--" alt="">-->
                LOGO
            </a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>
        <ul class="layui-nav right">
            <li class="layui-nav-item">
                <a href="#" style="color: red" target="myFrameName"><?=\Yii::$app->session->get('sNick')?></a>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:if(confirm('确认退出？'))location='index.php?r=web/site/logout'">退出</a>
            </li>
        </ul>
        <!-- 顶部结束 -->
        <!-- 中部开始 -->
        <!-- 左侧菜单开始 -->
        <div class="left-nav">
            <div id="side-nav">
                <ul id="nav">
                    <?php foreach($menu as $menuloop){?>
                        <li>
                            <?php if(empty($menuloop['sURL'])){?>
                            <a href="javascript:;">
                                <?php }else{?>
                                <a _href="<?=$menuloop['sURL']?>" title="<?=$menuloop['sMenuName']?>">
                                    <?php }?>
                                    <i class="iconfont">&#xe723;</i>
                                    <cite><?=$menuloop['sMenuName']?></cite>
                                    <i class="iconfont nav_right">&#xe697;</i>
                                </a>
                                <?php foreach($menuloop['cMenus'] as $sonMenu){?>
                                    <ul class="sub-menu">
                                        <li>
                                            <a _href="<?=$sonMenu['sURL']?>">
                                                <i class="iconfont">&#xe6a7;</i>
                                                <cite><?=$sonMenu['sMenuName']?></cite>
                                            </a>
                                        </li>
                                    </ul>
                                <?php }?>
                        </li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <!-- <div class="x-slide_left"></div> -->
        <!-- 左侧菜单结束 -->
        <!-- 右侧主体开始 -->
        <div class="page-content">
            <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false" >
                <ul class="layui-tab-title" style="display:none;">
                    <li>欢迎</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <iframe src="index.php?r=web/admin/welcome" frameborder="0"  name="myFrameName" scrolling="yes" class="x-iframe"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content-bg"></div>
        <!-- 右侧主体结束 -->
        <!-- 中部结束 -->
        <!-- 底部开始 -->
        <div class="footer">
            <div class="copyright"><a href="<?=Yii::$app->params['baseUrl']?>" style="color: #fff">京ICP备20028411号-1</a></div>
        </div>
<?php
$this->endContent();
?>