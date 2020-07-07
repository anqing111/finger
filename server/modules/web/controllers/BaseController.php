<?php
namespace app\modules\web\controllers;
use yii\log\FileTarget;
use yii\web\Controller;
class BaseController extends Controller{

    //终端类型
    public $_clients = ['web'=>1,'wap'=>2,'miniapp'=>3];
    //渠道编号   fingertip
    const merCode = 'fingertip';
    //秘钥 md5("fingertip")
    const KEY = 'a7976b01a29bf6f1a261a69583c4df5e';

    public $userid=0;

    public $arrPara;

    public $method;

    public $_filter = ['login','register','banding','registerSucc'];
    /**
     *  登录统一验证    (每次动作先执行本方法)
     */
    public function beforeAction( $action )
    {
        $arPara = array('merCode','timestamp','signMsg','client');
        $this->method = $action->id;
        switch ($this->method)
        {

            default:
                break;
        }
//        $this->arrPara = self::verifyParam($arPara,$this->method);
//        self::verifySign($this->arrPara,$this->method);
        /**
         * 验证登录信息
         */
//        AuthTrait::beforeAction();
//        if(! in_array($this->method,$this->_filter))
//        {
//            $this->AuthAction();
//        }else{
//            $session = \Yii::$app->session;
//            if ($session->isActive)
//            {
//                $this->redirect(array('/site/index'));
//            }
//        }

        return true;
    }

    public function AuthAction()
    {
        $session = \Yii::$app->session;
        if ($session->isActive)
        {
            $this->userid = $session->get('iUserID');
        }else{
            $this->redirect(array('/site/login'));
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
            if(empty($_REQUEST[$field])){
                $msg = sprintf("%s不能为空",$field);
                self::getFailInfo($msg,$method);
            }

            if($field == 'merCode' && $_REQUEST[$field] != self::merCode){
                self::getFailInfo("渠道编号错误",$method);
            }

            if($field == 'mobile' && !preg_match("/^1[3456789]{1}\d{9}$/",$_REQUEST[$field])){
                self::getFailInfo("手机号格式错误",$method);
            }

            $arrPara[$field] = $_REQUEST[$field];
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
        $str .= 'key='.self::KEY;
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