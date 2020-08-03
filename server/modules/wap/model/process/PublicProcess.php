<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2020/7/3
 * Time: 9:27
 */

namespace app\modules\wap\model\process;

use yii\helpers\Url;

class PublicProcess
{
    function __construct()
    {
    }
    function __destruct()
    {
    }
    /**
     * 有效字段过滤（过滤有效的字段列表）
     *
     * @param array[] $inputFields	输入的字段列表
     * @param array[] $defFields 数据库字段列表
     * @return array[] 过滤后的字段列表
     */
    private function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    public static function TopWeb()
    {
        $top = '<header>
        <div class="container flex-box">
            <a href="index.php?r=wap/site"><img src="'.\Yii::$app->params['imagePath'].'/wap/images/logo.png" alt="" class="logo"></a>
            <div class="filler"></div>
            <a href="index.php?r=wap/site/certificateindex">
                <div class="searcher flex-box">
                    <img src="'.\Yii::$app->params['imagePath'].'/wap/images/searcher-icon.png" alt="" class="icon">
                    <input type="text" placeholder="证书查询" class="filler">
                </div>
            </a>
            <img src="'.Url::to('images/nav.png').'" alt="" class="nav-img">
        </div>
        <div class="nav-list">
            <a href="index.php?r=wap/site" class="flex-box"><img src="'.Url::to('images/home.png').'" alt="" style="width: 2.5rem;height: 2.3125rem"><span>首页</span></a>
            <a href="index.php?r=wap/site/courseindex" class="flex-box"><img src="'.Url::to('images/book.png').'" alt="" style="width: 2.5rem;height: 2.25rem"><span>课程</span></a>
            <a class="flex-box"><img src="'.Url::to('images/teach.png').'" alt="" style="width: 2.625rem;height: 2rem"><span>继续教育</span></a>
            <a href="index.php?r=wap/site/certificatelist" class="flex-box"><img src="'.\Yii::$app->params['imagePath'].'/wap/images/cert.png'.'" alt="" style="width: 2.625rem;height: 2rem"><span>我的证书</span></a>
        </div>
    </header>';
        return $top;
    }

    public static function TopWebL(){

        $top = '<header class="shadow">
        <div class="container flex-box">
            <div class="filler flex-box">
                <img src="'.\yii\helpers\Url::to('images/logo.png').'" alt="" class="logo" style="background: rgba(0,0,0,0);">
            </div>
            <div class="options">
                <div class="options1">
                <a href="index.php?r=web/site/login" style="color:rgba(255,157,42,1);">登录</a>
                </div>
                <div class="options2">
                <a href="index.php?r=web/site/register" style="color: #fff">注册</a>
                </div>
            </div>
        </div>
    </header>';
        return $top;
    }

    public static function MiddleWeb()
    {
        $middler = '<div class="container">
            <div class="slogan">科技成就未来，知识改变命运</div>
            <hr>
            <div class="map">
                <div class="line flex-box">
                    <a href="index.php?r=wap/site/college" class="filler">校企合作</a>
                    <a href="index.php?r=wap/site/join" class="filler">申请加盟</a>
                    <a href="" class="filler">我要加入</a>
                </div>
                <div class="line flex-box">
                    <a class="filler" style="margin-top: 1rem;font-size: 1rem">京ICP备20028411号-1</a>
                </div>
            </div>
        </div>';
        return $middler;
    }

    //判断是否为微信访客
    public static function is_WeiChat(){
        //是否为微信访客
        return FALSE !== strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') ? 1 : 0;
    }

    //判断是否为移动设备
    public static function isMobile() {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger');
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }
    //获取今天星期几
    public static function week()
    {
        $weekarray=["星期日","星期一","星期二","星期三","星期四","星期五","星期六"];

        return $weekarray[date("w",time())];
    }
}