<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\assets\AppAsset;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文件上传</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
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
<?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className(),[
    'clientOptions' => [
        'lang' => 'zh_cn',
        'plugins' => ['clips', 'fontcolor','imagemanager'],
        'minHeight'=>'800px'
    ]
]) ?>
<?=Html::submitButton('提交', ['class'=>'btn btn-primary','name' =>'submit-button']) ?>
<?php ActiveForm::end(); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>