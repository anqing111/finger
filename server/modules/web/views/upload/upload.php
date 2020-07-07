<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文件上传</title>
</head>
<body>
<?php if(Yii::$app->session->hasFlash('success')):?>
    <div class="alert alert-danger">
        <?=Yii::$app->session->getFlash('success')?>
    </div>
<?php endif ?>

<?php $form=ActiveForm::begin([
    'id'=>'upload',
    'enableAjaxValidation' => false,
    'options'=>['enctype'=>'multipart/form-data']
]);
?>
<?=$form->field($model, 'imageFile')->fileInput();?>
<?=Html::submitButton('提交', ['class'=>'btn btn-primary','name' =>'submit-button']) ?>
<?php ActiveForm::end(); ?>

<!--批量上传-->
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'imagesFile[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

<?=Html::submitButton('提交', ['class'=>'btn btn-primary','name' =>'submit-button']) ?>

<?php ActiveForm::end() ?>


</body>
</html>