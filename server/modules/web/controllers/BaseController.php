<?php
namespace app\modules\web\controllers;
use yii\log\FileTarget;
use yii\web\Controller;
date_default_timezone_set("PRC");
class BaseController extends Controller{

    //终端类型
    public $_clients = ['web'=>1,'wap'=>2,'miniapp'=>3];

    public $userid=0;

    public $arrPara;

    public $method;

    public $_filter = ['login','register','banding','error','success','forgetmail','forgetphone','forgetsuccess','join']; //不用登录就显示的文件

    public $_check = ['login','sendcode','getmesvalidate','register','banding','forgetmail','forgetphone','certificateindex','join','courseindex'];//验证的文件

    public $_indexfilter = ['banding','success','forgetsuccess','error','join']; //登录成功也可以显示的页面
    /**
     *  登录统一验证    (每次动作先执行本方法)
     */
    public function beforeAction( $action )
    {
        $this->getView()->title = "八泽职业技术鉴定协会";
        $arPara = array('merCode','timestamp','signMsg','client');
        $this->method = $action->id;
        switch ($this->method)
        {
            case "login": //登录
                $arPara = array_merge($arPara,['account','sPassWord']);
                break;
            case "sendcode": //发送验证码
                $arPara = array_merge($arPara,['account','source']);
                break;
            case "getmesvalidate": //获取短信/邮箱验证码
                $arPara = array_merge($arPara,['source']);
                break;
            case "register": //注册
                $arPara = array_merge($arPara,['sNick','sMail','sPassWord','code','source']);
                break;
            case "banding": //绑定手机号
                $arPara = array_merge($arPara,['iUserID','sMail','sPhone','code','source']);
                break;
            case "forgetmail": //忘记密码邮箱找回
                $arPara = array_merge($arPara,['sPassWord','sMail','word','code','source']);
                break;
            case "forgetphone": //忘记密码手机号找回
                $arPara = array_merge($arPara,['sPassWord','word','sPhone','code','source']);
                break;
            case "certificateindex": //证书查询
                $arPara = array_merge($arPara,['idcard','sCertificateNum']);
                break;
            case "join": //申请加盟
                $arPara = array_merge($arPara,['sUnitName','person','direction','iCityID','sMail','sPhone']);
                break;
            case "courseindex": //选择课程
                $arPara = array_merge($arPara,['tid']);
                break;
            default:
                break;
        }

        if(\Yii::$app->request->isPost && in_array($this->method,$this->_check))
        {
            $this->arrPara = self::verifyParam($arPara,$this->method);
            self::verifySign($this->arrPara,$this->method);
        }
        /**
         * 验证登录信息
         */
        if(! in_array($this->method,$this->_filter))
        {
            $this->AuthAction();
        }else{
            $session = \Yii::$app->session;
            if ($session['iUserID'] && !in_array($this->method,$this->_indexfilter))
            {
                $this->redirect(array('/web/site/index'));
            }
        }

        return true;
    }

    public function AuthAction()
    {
        $session = \Yii::$app->session;
        if ($session['iUserID'])
        {
            $this->userid = $session['iUserID'];
        }else{
            $this->redirect(array('/web/site/login'));
        }
    }

    /**
     * 参数校验
     * @param $arPara
     * @param $method
     * @return array
     */
    public static function verifyParam($arPara,$method){
        $arrPara = array();

        foreach($arPara as $field)
        {
            if(empty(\Yii::$app->request->post($field))){
                $msg = sprintf("%s不能为空",$field);
                self::getFailInfo($msg,$method);
            }

            if($field == 'merCode' && \Yii::$app->request->post($field) != \Yii::$app->params['MERCODE']){
                self::getFailInfo("渠道编号错误",$method);
            }

            if($field == 'mobile' && !preg_match("/^1[3456789]{1}\d{9}$/",\Yii::$app->request->post($field))){
                self::getFailInfo("手机号格式错误",$method);
            }

            $arrPara[$field] = \Yii::$app->request->post($field);
        }
//        $arrPara['api'] = $method;
        return $arrPara;
    }

    /**
     * 成功返回
     * @param $arData
     * @param $method
     */
    public static function getSucInfo($arData,$method){
        $arRet = array(
            'api'=>$method,
            'code'=>0,
            'msg'=>'success',
            'data'=>$arData
        );

//        GeneralFunc::writeLog($method.'返回结果：'.json_encode($arData,JSON_UNESCAPED_UNICODE), Yii::app()->getRuntimePath().'/output/');

        self::getJson($arRet);
    }

    /**
     * 失败返回
     * @param $msg
     * @param $method
     */
    public static function getFailInfo($msg,$method,$code=1){
        $arRet = array(
            'api'=>$method,
            'code'=>$code,
            'msg'=>$msg
        );
        self::getJson($arRet);
    }

    /**
     * 验证签名
     * @param $arrPara
     * @param $method
     */
    public static function verifySign($arrPara,$method){
        $sign = self::createSign($arrPara);
//        echo $sign;die;
        if($sign != $_REQUEST['signMsg']){
            self::getFailInfo("签名错误",$method);
        }
    }

    /**
     * 创建签名
     * @param $arrPara
     * @return string
     */
    public static function createSign($arrPara){
//        $arrPara["key"] = self::KEY;
        unset($arrPara['signMsg']);
        unset($arrPara['reason']);
        ksort($arrPara);
        $str = '';
        foreach($arrPara as $key=>$val){
            $str .= $key.'='.$val.'&';
        }
        $str .= 'key='.\Yii::$app->params['KEY'];
//        echo substr($str,0,-1);die;
        $sign = md5($str);
        return $sign;
    }

    public static function getJson($ret)
    {
        echo json_encode($ret);
        exit();
    }

    /**
     * 记录日志
     *
     * @param type $msg
     * @time 2020年7月7日
     * @author rentingshuang <tingshuang@rrkd.cn>
     */
    public static function log($msg = '', $fileName = '', $dir = '')
    {
        date_default_timezone_set('PRC');
        $directory = date ( 'Y-m-d' );
        $fileName = ! empty ( $fileName ) ? ($fileName . '.log') : ($directory . 'app.log');
        if (! empty ( $dir )) {
            $directory .= DIRECTORY_SEPARATOR . $dir;
        }

        if (! empty ( \Yii::$app->params ['LogDir'] )) {
            $path = \Yii::$app->params ['LogDir'] . DIRECTORY_SEPARATOR . $directory;
        } else {
            $path = \Yii::$app->getRuntimePath() . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . $directory;
        }

        if(!is_dir($path))
        {
            mkdir($path,0777);
        }

        $path .= DIRECTORY_SEPARATOR . $fileName;

        $tempStrLog = date('H:i:s').' '.$msg."\n";
        $f = fopen($path, 'a');
        fwrite($f, $tempStrLog);
        fclose($f);

        unset($tempStrLog);
        return true;

    }
}
?>