<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\db\BUserbaseinfo */

$this->title = Yii::t('app', 'Create B Userbaseinfo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'B Userbaseinfos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buserbaseinfo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
