<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2020/7/6
 * Time: 18:10
 */

//注意这里的命名空间，要跟你的目录对应
namespace app\modules\web\common;

use Yii;
use yii\base\Action;
use yii\web\UploadedFile;
use app\models\Upload;
use app\modules\web\controllers\UploadController;


//我们需要继承yii\base\Action类
class TestAction extends Action {

    //这里面的三个参数的值是通过控制器actions中配置而来的
    public $param1 = null;
    public $param2 = null;
    public $param3 = null;

    //实现run方法
    public function run()
    {
        $model = new Upload();
        if (\Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, "imageFile");
            //文件上传存放的目录
            $dir = \Yii::$app->basePath."/common/image/".date("Ymd").'/';
            if (!is_dir($dir))
                mkdir($dir, 0777);
            if ($model->upload($dir)) {
                //文件上传成功
            }
        }
    }

}