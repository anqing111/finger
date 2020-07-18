<?php
/**
 * InterfaceForm
 * @author anqing
 * @version V1.0
 */
namespace app\models;
use app\models\lib\CCliveProviderProcess;
use Yii;
use yii\base\Model;
class InterfaceForm extends Model
{
    private static $instance;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new InterfaceForm();
        }

        return self::$instance;
    }

    public static function TryCreateBSObjectProvider($iTicketID)
    {
        switch ($iTicketID)
        {
            case Yii::$app->params['interface']['cclive']:
                return CCliveProviderProcess::getInstance();
            default:
                break;
        }
        return NULL;
    }
    //获取CC直播间列表
    public static function GetSelectedRoomInfo($iTicketID)
    {
        $bsObjectProvider = InterfaceForm::TryCreateBSObjectProvider($iTicketID);
        if ($bsObjectProvider === NULL)
        {
            return array();
        }
        return $bsObjectProvider->GetBookSeatingRoomInfo();
    }
    //获取CC直播间直播状态
    public static function GetSelectedRoomPublishing($iTicketID,$roomids)
    {
        $bsObjectProvider = InterfaceForm::TryCreateBSObjectProvider($iTicketID);
        if ($bsObjectProvider === NULL)
        {
            return array();
        }
        return $bsObjectProvider->GetBookSeatingRoomPublishing($roomids);
    }
}