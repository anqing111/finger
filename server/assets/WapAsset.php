<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class WapAsset extends AssetBundle
{
    public function __construct(array $config = [])
    {
        foreach ($this->css as &$r)
        {
            $r = \Yii::$app->params['imagePath'].'/wap/'.$r;
        }
        foreach ($this->js as &$r2)
        {
            $r2 = \Yii::$app->params['imagePath'].'/wap/'.$r2;
        }
        parent::__construct($config);
    }

    public $basePath = '@waproot';
    public $css = [
        'css/font.css',
        'css/swiper.min.css',
        'css/default-v1.0.css',
        'css/main-v1.0.css',
        'assets/509f2668/redactor.css',
        'layui/css/layui.css',
    ];
    public $js = [
        'js/jquery.min.js',
        'layui/layui.js',
        'js/swiper.min.js',
        'js/dplayer.min.js',
        'js/default-v1.0.js',
        'js/md5v1.js',
        'js/public.js',
        'js/xadmin.js',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];

    public $cssOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}
