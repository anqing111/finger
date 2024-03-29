<?php
namespace app\models\lib;

class CCliveProviderProcess
{
    private static $instance;

    public function __construct()
    {

    }
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new CCliveProviderProcess();
        }

        return self::$instance;
    }

    /**
     * 获取直播间列表
     * @param $pagenum 可选，系统默认值为50
     * @param $pageindex 可选，系统默认值为1
     * @return array
     */
    public function  GetBookSeatingRoomInfo($pagenum = 50,$pageindex = 1)
    {
        $rawData = CCliveRetrieverProcess::Get_Base_RoomInfo($pagenum,$pageindex);
        return CCliveDataAdapterProcess::FillBookSeatingRoomInfo($rawData);
    }

    /*
     * 获取直播间直播状态
     * @param $roomids 直播间id（以英文逗号,区分)，批量查询直播间数量不能超过100个
     * @return array
     * */
    public function  GetBookSeatingRoomPublishing($roomids)
    {
        $rawData = CCliveRetrieverProcess::Get_Base_RoomPublishing($roomids);
        return CCliveDataAdapterProcess::FillBookSeatingRoomPublishing($rawData);
    }
}
