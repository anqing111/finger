<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\db\BCclive;
use app\models\InterfaceForm;
use app\modules\web\controllers\BaseController;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Exception;
use yii\helpers\Json;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class InterfaceController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }
    //cc直播
    public function actionCclive($type)
    {
        switch ($type){
            case 'roominfo':
            {
                $roomInfo = InterfaceForm::GetSelectedRoomInfo(\Yii::$app->params['interface']['cclive']);
                if(empty($roomInfo))
                {
                    break;
                }

                try{
                    foreach ($roomInfo as &$r)
                    {
                        $cclive = BCclive::find()->where(['id'=>$r['id']])->one();
                        if(!$cclive)
                        {
                            //添加
                            $id = BCclive::insertCclive($r);
                            if(!$id)
                            {
                                BaseController::log('Fail Add:'.Json::encode($r),'cclive');
                            }
                            continue;
                        }

                        if($cclive->md5sign == $r['md5sign'])
                        {
                            continue;
                        }

                        //编辑
                        $r['cid'] = $cclive->cid;
                        $id = BCclive::updateCclive($r);
                        if(!$id)
                        {
                            BaseController::log('Fail Edit:'.Json::encode($r),'cclive');
                        }
                    }
                }catch (\Exception $e)
                {
                    BaseController::log(Json::encode($e->getMessage()),'cclive');
                }

            }
                break;
            default:
                break;
        }
    }
}
