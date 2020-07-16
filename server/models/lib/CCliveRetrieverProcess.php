<?php
namespace app\models\lib;
use app\modules\web\controllers\BaseController;

date_default_timezone_set('PRC');
class CCliveRetrieverProcess
{
    //接口请求地址
    const ccliveApiUrl = "http://api.csslcloud.net/api/";
    //CC直播apikey
    const apikey = '9OoN1arrjXCjRcVoHHv7iAvNy9phLzry';
    //CC直播用户id
    const userid = '943DACA690744F67';

    /**
     * 发送post请求
     * @param $methodName
     * @param array $arPara
     * @return mixed|string
     */
    private static function getJsonFromHttp($methodName, $isWriteLog = 0, $arPara = array()) {
        try {
            //密钥验证
            $param = self::getSign($arPara);
            $apiUrl = self::ccliveApiUrl.$methodName.'?'.$param;
//            echo $apiUrl;die;
            $jsonString = self::MyHttpGet($apiUrl, $arPara,'utf-8',90,$isWriteLog);
        } catch (Exception $e) {
            $jsonString = '';
        }
        return $jsonString;
    }

    /**
     * 发送请求get
     * @param $url
     * @param $postDataStr
     * @param string $encoding
     * @param int $timeout
     * @param int $WriteLog
     * @return mixed
     */
    public static function MyHttpGet($url, $postDataStr,$encoding = "utf-8",$timeout=30,$WriteLog=0)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $response = curl_exec($ch);
        curl_close($ch);
        if ($WriteLog)
        {
            BaseController::log('请求地址：'.$url.',请求参数：'.$postDataStr.',接口响应：'.$response,'interface');
        }
        return $response;
    }

    /**
     * 返回签名
     * @param array $arPara
     * @return string
     */
    public static function getSign($arPara = array()){

        $arPara['userid'] = self::userid;

        ksort($arPara);

        $arStr = array();

        foreach ($arPara as $key => $v) {
            $arStr[] = $key . "=" . $v;
        }

        $url = implode('&',$arStr);
        $time = time();
        $signMsg = md5($url.'&time='.$time.'&salt='.self::apikey);

        return $url.'&time='.$time.'&hash='.$signMsg;
    }

    /**
     * 获取直播间列表
     * @param $ShowIndex 影讯id
     * @return string
     */
    public static function Get_Base_RoomInfo($pagenum,$pageindex) {
        $arPara = [
            'pagenum' => $pagenum,
            'pageindex' => $pageindex,
        ];
        $jsonString = self::getJsonFromHttp("room/info",0, $arPara);
        return $jsonString;
    }
}


        
       

     
       