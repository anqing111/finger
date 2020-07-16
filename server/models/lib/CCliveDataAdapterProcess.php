<?php
namespace app\models\lib;
use yii\helpers\Json;

class CCliveDataAdapterProcess
{
    /**
     * 获取直播间列表
     * @param $jsonData
     * @return array
     */
    public static function FillBookSeatingRoomInfo($jsonData)
    {
        $arRetSeat = array();
        $jsonData = Json::decode($jsonData);
//print_r($jsonData);die;
        if(strtolower($jsonData['result']) == 'ok') {

            $dataArray = $jsonData['rooms'];

            if (!is_array($dataArray) || empty($dataArray)) {
                return $arRetSeat;
            }

            foreach($dataArray as $key1=>$data)
            {
                $arRetSeat[$key1] = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'desc' => $data['desc'],
                    'status' => $data['status'], //直播间状态，10：正常； 20：关闭； 40：已封禁
                    'playPass' => $data['playPass'], //播放端密码
                    'assistantPass' => $data['id'], //助教密码 主持人模式开启后即为主持人密码
                    'publisherPass' => $data['publisherPass'], //讲师登录密码
                    'authType' => $data['authType'], //验证类型
                    'barrage' => $data['barrage'], //是否开启弹幕，0：不开启；1：开启
                    'templateType' => $data['templateType'], //模板类型
                    'liveStartTime' => $data['liveStartTime'], //直播开始时间
                    'playerBackgroundHint' => $data['playerBackgroundHint'], //播放器提示语
                    //......未完待续
                ];

                $arStr = array();

                foreach ($arRetSeat[$key1] as $key => $v) {
                    $arStr[] = $key . "=" . $v;
                }

                $arRetSeat[$key1]['md5sign'] = md5(implode('&',$arStr));
            }
        }

        return $arRetSeat;
    }
}