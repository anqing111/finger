<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\db\BUserbaseinfo */

$this->title = Yii::t('app', 'Update B Userbaseinfo: {name}', [
    'name' => $model->iUserID,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'B Userbaseinfos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iUserID, 'url' => ['view', 'id' => $model->iUserID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="buserbaseinfo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
