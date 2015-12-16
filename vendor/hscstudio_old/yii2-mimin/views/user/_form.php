<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\modules\administrator\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
       <?php
        $data9 = ArrayHelper::map(\common\models\DaftarUnit::find()->asArray()->all(), 'unit_id', 'nama');
        echo $form->field($model, 'unit_id')->widget(Select2::classname(), ['data' => $data9, 'options' => ['id' => 'data2', 'placeholder' => 'Pilih Nama Unit Kerja'], 'pluginOptions' => ['allowClear' => true], ])->label('Pilih Unit Kerja');
                          ?>
    <?= $form->field($model, 'status')->widget(SwitchInput::classname(), [
  		'pluginOptions' => [
  			'onText' => 'Aktif',
  			'offText' => 'Banned',
  		]
  	]) ?>
 
    <?php if (!$model->isNewRecord){ ?>
      <strong> Biarkan kosong jika tidak ingin mengubah password</strong>
      <div class="ui divider"></div>
      <?= $form->field($model, 'new_password') ?>
      <?= $form->field($model, 'repeat_password') ?>
      <?= $form->field($model, 'old_password') ?>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
