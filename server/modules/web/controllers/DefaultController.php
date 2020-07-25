<?php

namespace app\modules\web\controllers;

use app\models\db\BMsg;
use app\models\SMSForm;
use app\models\VideoForm;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Default controller for the `web` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->redirect(array('/web/site/error'));
    }
    public function actionTest(){
//        $randStr = str_shuffle('1234567890');
//        $code = substr($randStr,0,6);
//        $arPara = array('code'=>$code);
//        $sTemplate = 'SMS_196643077';
//        $sPhone = '18618494733';
//        $res = SMSForm::sendDayuTextMsg($sPhone,$arPara,$sTemplate);
//        print_r($res);

        try {
            $client = VideoForm::initVodClient(VideoForm::AccessKeyId, VideoForm::AccessKeySecret);
            $playInfo = VideoForm::getPlayInfo($client, '43d9d99e54d445aa93f30b1554e1e9dd');
            print_r($playInfo->PlayInfoList->PlayInfo);
            var_dump($playInfo);
        } catch (Exception $e) {
            print $e->getMessage()."\n";
        }
    }
}
