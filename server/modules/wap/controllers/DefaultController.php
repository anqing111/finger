<?php

namespace app\modules\wap\controllers;

use yii\web\Controller;

/**
 * Default controller for the `wap` module
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
}
