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

class UploadForm extends Model{
    public $imageFile = null;
    public $imagesFile = null;
    public $videoFile = null;
    public $videosFile = null;
    public $imagesHead = null;

    public function __construct(array $config = [])
    {
        $this->imageFile = null;
        $this->imagesFile = null;
        $this->videoFile = null;
        $this->videosFile = null;
        $this->imagesHead = null;
        parent::__construct($config);
    }

    public function rules()
    {
        /*
         * maxFiles
         * 指定的属性可最多持有的文件数量。 默认为1，代表上传单文件。设置为 0 意味着同时上传的文件数目没有限制。 >
         * 注意：同时上传的最大文件数量同样受 max_file_uploads 限制， 其默认值为 20。
         * */
        $_imageRules = [['imageFile'],
            'file', 'extensions' => 'jpg,png,gif',
            'mimeTypes' => 'image/jpeg,image/pjpeg,image/png,image/gif',
//            'skipOnEmpty'=>false, //是否为空
            'maxSize'=>'2048000', //最大字节数 2M
//            'uploadRequired'=>'请上传{attribute}',
            'tooBig'=>'{attribute}最大不能超过{formattedLimit}',
            'wrongExtension'=>"{attribute}只能是{extensions}类型"
        ];

        if(!empty($this->imagesFile))
        {
            $_imageRules = [['imagesFile'],//批量上传
                'file', 'extensions' => 'jpg,png,gif',
                'mimeTypes' => 'image/jpeg,image/pjpeg,image/png,image/gif',
                'skipOnEmpty'=>false, //是否为空
                'maxSize'=>'2048000', //最大字节数 2M
                'uploadRequired'=>'请上传{attribute}',
                'tooBig'=>'{attribute}最大不能超过{formattedLimit}',
                'wrongExtension'=>"{attribute}只能是{extensions}类型",
                'maxFiles'=>4
            ];
        }

        if(!empty($this->imagesHead))
        {
            $_imageRules = [['imagesHead'],
                'file', 'extensions' => 'jpg,png,gif',
                'mimeTypes' => 'image/jpeg,image/pjpeg,image/png,image/gif',
//            'skipOnEmpty'=>false, //是否为空
                'maxSize'=>'2048000', //最大字节数 2M
//            'uploadRequired'=>'请上传{attribute}',
                'tooBig'=>'{attribute}最大不能超过{formattedLimit}',
                'wrongExtension'=>"{attribute}只能是{extensions}类型"
            ];
        }

        if(!empty($this->videoFile))
        {
            $_imageRules = [['videoFile'],
                'file', 'extensions' => 'mp4,avi,rmvb,wmv,mkv,qsv',
                'skipOnEmpty'=>false, //是否为空
                'maxSize'=>'2048000000', //最大字节数 2G
                'uploadRequired'=>'请上传{attribute}',
                'tooBig'=>'{attribute}最大不能超过{formattedLimit}',
                'wrongExtension'=>"{attribute}只能是{extensions}类型"
            ];
        }

        if(!empty($this->videosFile))
        {
            $_imageRules = [['videosFile'],//批量上传
                'file', 'extensions' => 'mp4,avi,rmvb,wmv,mkv,qsv',
                'skipOnEmpty'=>false, //是否为空
                'maxSize'=>'2048000000', //最大字节数 2G
                'uploadRequired'=>'请上传{attribute}',
                'tooBig'=>'{attribute}最大不能超过{formattedLimit}',
                'wrongExtension'=>"{attribute}只能是{extensions}类型",
                'maxFiles'=>4
            ];
        }

        return [
            $_imageRules
        ];
    }

    public function attributeLabels(){
        return [
            'imageFile'=>'图片上传',
            'imagesFile'=>'批量图片上传',
            'videoFile'=>'视频上传',
            'videosFile'=>'批量视频上传'
        ];
    }

    public function nameRules()
    {
        $charid = strtolower(substr(md5(uniqid(mt_rand(), true)),8,24));
        $hyphen = '';   //chr(45);
        $uuid = substr($charid, 0, 8).substr($charid, 8, 4).$hyphen.substr($charid,12, 4).$hyphen.substr($charid,16, 4).$hyphen.substr($charid,20,12);
        $today = date("Ymd").$uuid;
        return $today;
    }

    public function upload($dir)
    {
        $today = $this->nameRules();
        $imagePath = $today.'.'.$this->imageFile->extension;
        $path = $dir.'/'.$imagePath; //图片的完整路径
        if ($this->validate()) {
            $this->imageFile->saveAs($path);
            return $imagePath;
        }
        return false;
    }

    public function uploads($dir)
    {
        if ($this->validate()) {

            foreach($this->imagesFile as $file)
            {
                $today = $this->nameRules();
                $path = $dir.'/'.$today.'.'.$file->extension; //图片的完整路径
                $file->saveAs($path);
            }

            return true;
        }
        return false;
    }

    public function uploadVideo($dir)
    {
        $today = $this->nameRules();
        $imagePath = $today.'.'.$this->videoFile->extension;
        $path = $dir.'/'.$imagePath; //图片的完整路径
        if ($this->validate()) {
            $this->videoFile->saveAs($path);
            return $imagePath;
        }

        return false;
    }

    public function uploadsVideo($dir)
    {
        if ($this->validate()) {

            foreach($this->videosFile as $file)
            {
                $today = $this->nameRules();
                $path = $dir.'/'.$today.'.'.$file->extension; //视频的完整路径
                $file->saveAs($path);
            }

            return true;
        }
        return false;
    }

    public function uploadHead($dir)
    {
        $imagePath = [];
        $width = [100,200];
        $height = [120,240];
        $size = [100,200];
        for($i = 0;$i <= 1;$i++)
        {
            $today = $this->nameRules();
            $imagePath[$i] = $today.'.'.$this->imagesHead->extension;
            $path = $dir.'/'.$imagePath[$i]; //图片的完整路径
            if (!$this->validate()) {
                return false;
            }
            //生成一张裁剪模式100 x 100 的缩略图
            \yii\imagine\Image::thumbnail($this->imagesHead->tempName, $width[$i] , $height[$i])

                ->save(Yii::getAlias($path),

                    ['quality' => $size[$i]]);//生成缩略图的质量
        }

        return $imagePath;
    }
}