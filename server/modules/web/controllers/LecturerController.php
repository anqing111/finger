<?php

namespace app\modules\web\controllers;

use app\models\db\ELecturer;
use yii\helpers\Json;
use yii\web\Controller;
/**
 * Default controller for the `web` module
 */
class LecturerController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     * 专家讲师-个人介绍
     */
    public function actionLecturerindex()
    {
        /*
         * 获取专家讲师-个人介绍
         * */
        //$this->userid
        $lecturer = ELecturer::find()->where(['iUserID' => $this->userid])->one();
        return $this->renderPartial('lecturerindex',['lecturer'=>$lecturer]);
    }
    /**
     * Renders the index view for the module
     * @return string
     * 专家讲师-个人介绍 - 编辑
     */
    public function actionLectureredit()
    {
        $lecturer = [];
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            if(empty($post))
            {
                self::getFailInfo('姓名不得为空',$this->method);
            }

            if(\Yii::$app->request->post('id'))
            {
                //编辑
                if(empty($post['status'])){
                    $post['status'] = ELecturer::UNRELEASED;
                }

                if(false == ELecturer::updateLecturer($post))
                {
                    self::getFailInfo('个人介绍编辑失败',$this->method);
                }
            }else{
                //添加
                if(false == ELecturer::insertLecturer($post))
                {
                    self::getFailInfo('个人介绍添加失败',$this->method);
                }
            }

            self::getSucInfo(['ok'=>true],$this->method);

        }else{

            $id = \Yii::$app->request->get('id');
            if ($id)
            {
                $lecturer = ELecturer::findOne($id);
                if(!$lecturer)
                {
                    self::getFailInfo('参数错误',$this->method);
                }
            }
        }
        return $this->renderPartial('lectureredit',['lecturer'=>$lecturer]);
    }
}
