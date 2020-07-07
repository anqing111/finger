<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\db\BUserbaseinfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="buserbaseinfo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sPhone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sMail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sPassWord')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pid')->textInput() ?>

    <?= $form->field($model, 'sNick')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iCurPrice')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iTotalPrice')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'userStatus')->textInput() ?>

    <?= $form->field($model, 'iUserSourceID')->textInput() ?>

    <?= $form->field($model, 'unionid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'xcxopenid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'userLevel')->textInput() ?>

    <?= $form->field($model, 'dVIPBeginTime')->textInput() ?>

    <?= $form->field($model, 'dVIPEndTime')->textInput() ?>

    <?= $form->field($model, 'dUpdateTime')->textInput() ?>

    <?= $form->field($model, 'dCreatTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
