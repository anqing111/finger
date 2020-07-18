<?php
namespace app\models\lib;
use app\models\db\BCclive;
use app\models\InterfaceForm;
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
                    'liveStatus' => BCclive::UNBEGIN, //默认直播未开始
                    //......未完待续
                ];

                //获取该直播间状态
                $roomPublishing = InterfaceForm::GetSelectedRoomPublishing(\Yii::$app->params['interface']['cclive'],$data['id']);
                if(!empty($roomPublishing))
                {
                    $arRetSeat[$key1]['liveStatus'] = $roomPublishing[0]['liveStatus'];
                }

                $arStr = array();

                foreach ($arRetSeat[$key1] as $key => $v) {
                    $arStr[] = $key . "=" . $v;
                }

                $arRetSeat[$key1]['md5sign'] = md5(implode('&',$arStr));
            }
        }

        return $arRetSeat;
    }
    /**
     * 获取直播间直播列表
     * @param $jsonData
     * @return array
     */
    public static function FillBookSeatingRoomPublishing($jsonData)
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
                    'roomId' => $data['roomId'],
                    'liveStatus' => $data['liveStatus'],
                ];
            }
        }

        return $arRetSeat;
    }
}