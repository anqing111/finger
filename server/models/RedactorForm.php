<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2020/7/6
 * Time: 19:03
 */

namespace app\models;

use app\modules\web\controllers\BaseController;
use Yii;
use yii\base\Model;

class RedactorForm extends Model{

    public $content = null;

    public function rules()
    {
        return [];
    }

    public function attributeLabels(){
        return [
            'content'=>'文章'
        ];
    }
}