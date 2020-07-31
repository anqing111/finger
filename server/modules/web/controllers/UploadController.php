<?php

namespace app\modules\web\controllers;

use app\models\RedactorForm;
use app\models\VideoForm;
use YII;
use yii\web\Controller;
use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * Default controller for the `web` module
 */
class UploadController extends BaseController
{
    //上传文件
    public function actionUpload()
    {
        $model = new UploadForm();
        if (\Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, "imageFile");
            //文件上传存放的目录
            $path = "/common/image/".date("Ymd").'/';
            $dir = \Yii::$app->basePath.$path;
            if (!is_dir($dir))
                mkdir($dir, 0777);
            $imagePath = $model->upload($dir);
            if (false != $imagePath) {
                //文件上传成功
                self::getSucInfo(['url'=>$path.$imagePath],$this->method);
            }else{
                self::getFailInfo($model->getErrors()['imageFile'][0],$this->method);
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
            $client = VideoForm::initVodClient();
            $model->videoFile = UploadedFile::getInstance($model, "videoFile");
            //文件上传存放的目录
            $path = "/common/video/".date("Ymd").'/';
            $dir = \Yii::$app->basePath.$path;
            if (!is_dir($dir))
                mkdir($dir, 0777);
            $imagePath = $model->uploadVideo($dir);
            if (false != $imagePath) {
                BaseController::log($imagePath,'video');
                self::getSucInfo(['url'=>Yii::$app->params['imagePath'].$path.$imagePath],$this->method);
            }else{
                self::getFailInfo($model->getErrors()['videoFile'][0],$this->method);
            }

            $url = $dir.$imagePath;
            //上传到远端阿里云
            $today = $model->nameRules();
            $imagePath = $today.'.'.$model->videoFile->extension;

            $VideoId = VideoForm::uploadLocalVideo($imagePath,$url);
//            $uploadVideo = VideoForm::createUploadVideo($client,$imagePath,$url);
            //文件上传成功，获取源文件地址
            $playAuth = VideoForm::getPlayInfo($client, $VideoId);

            self::getSucInfo(['url'=>$playAuth->PlayInfoList->PlayInfo[0]->PlayURL],$this->method);

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
        return $this->renderPartial('text', ['model' => $model]);
    }

    //上传头像 生成一张大图一张小图
    public function actionHead()
    {
        $model = new UploadForm();
        if (\Yii::$app->request->isPost) {
            $model->imagesHead = UploadedFile::getInstance($model, "imagesHead");
            //文件上传存放的目录
            $path = "/common/head/".date("Ymd").'/';
            $dir = \Yii::$app->basePath.$path;
            if (!is_dir($dir))
                mkdir($dir, 0777);
            $imagePath = $model->uploadHead($dir);
            if (is_array($imagePath)) {
                foreach($imagePath as &$r)
                {
                    $r = $path.$r;
                }
                //文件上传成功
                self::getSucInfo(['url'=>$imagePath],$this->method);
            }else{
                self::getFailInfo($model->getErrors()['imagesHead'][0],$this->method);
            }
        }
        return $this->render('upload', ['model' => $model]);
    }
}
