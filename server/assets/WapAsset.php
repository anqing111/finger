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
        'css/swiper.min.css',
        'css/default.css',
        'css/main.css',
        'assets/509f2668/redactor.css',
    ];
    public $js = [
        'js/jquery.min.js',
        'js/swiper.min.js',
        'js/dplayer.min.js',
        'js/default.js',
        'js/md5v1.js',
        'js/public.js',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];

    public $cssOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}
