<?php

namespace app\modules\web\controllers;

use app\models\RedactorForm;
use YII;
use yii\web\Controller;
use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * Default controller for the `web` module
 */
class UploadController extends BaseController
{
    //actions的作用主要是共用功能相同的方法
    public function actions()
    {
        return [
            'test' => [
                'class' => 'app\modules\web\common\TestAction',
                'param1' => 'hello',
                'param2' => 'world',
                'param3' => '!!!',
            ],
        ];
    }
    //上传文件
    public function actionUpload()
    {
        $model = new UploadForm();
        if (\Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, "imageFile");
            //文件上传存放的目录
            $dir = \Yii::$app->basePath."/common/image/".date("Ymd").'/';
            if (!is_dir($dir))
                mkdir($dir, 0777);
            if ($model->upload($dir)) {
                //文件上传成功
            }else{
                var_dump($model->getErrors());
            }
        }
        return $this->render('upload', ['model' => $model]);
    }
    //批量上传文件
    public function actionUploads()
    {
        $model = new UploadForm();
        if (\Yii::$app->request->isPost) {
            $model->imagesFile = UploadedFile::getInstances($model, "imagesFile");
            //文件上传存放的目录
            $dir = \Yii::$app->basePath."/common/image/".date("Ymd").'/';
            if (!is_dir($dir))
                mkdir($dir, 0777);
            if ($model->uploads($dir)) {
                //文件上传成功
            }else{
                var_dump($model->getErrors());
            }
        }
        return $this->render('upload', ['model' => $model]);
    }

    //上传视频
    public function actionVideo()
    {
        $model = new UploadForm();
        if (\Yii::$app->request->isPost) {
            $model->videoFile = UploadedFile::getInstance($model, "videoFile");
            //文件上传存放的目录
            $dir = \Yii::$app->basePath."/common/video/".date("Ymd").'/';
            if (!is_dir($dir))
                mkdir($dir, 0777);
            if ($model->uploadVideo($dir)) {
                //文件上传成功
            }else{
                var_dump($model->getErrors());
            }
        }
        return $this->render('video', ['model' => $model]);
    }
    //批量上传视频
    public function actionVideos()
    {
        $model = new UploadForm();
        if (\Yii::$app->request->isPost) {
            $model->videosFile = UploadedFile::getInstances($model, "videosFile");
            //文件上传存放的目录
            $dir = \Yii::$app->basePath."/common/video/".date("Ymd").'/';
            if (!is_dir($dir))
                mkdir($dir, 0777);
            if ($model->uploadsVideo($dir)) {
                //文件上传成功
            }else{
                var_dump($model->getErrors());
            }
        }
        return $this->render('video', ['model' => $model]);
    }

    //富文本编辑器
    public function actionText()
    {
        $model = new RedactorForm();
        if (\Yii::$app->request->isPost) {
            var_dump(\Yii::$app->request->post());
        }
        return $this->render('text', ['model' => $model]);
    }
}
