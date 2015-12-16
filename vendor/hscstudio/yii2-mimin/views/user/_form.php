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
<div class="col-sm-6 col-md-12">
        <div class="widget">
            <div class="widget-simple ">
                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
       <?php
        $data9 = ArrayHelper::map(\common\models\Pegawai::find()->asArray()->all(), 'nip', 'nama_cetak');
        echo $form->field($model, 'nip')->widget(Select2::classname(), ['data' => $data9, 'options' => ['id' => 'nip', 'placeholder' => 'Nama Lengkap'], 'pluginOptions' => ['allowClear' => true], ])->label('Pilih Nama Lengkap');
                          ?>
    <?= $form->field($model, 'status')->radioList(array('0'=>'Tidak Aktif',10=>'Aktif')); ?>
      <?php
        $data9 = ArrayHelper::map(\common\models\DaftarUnit::find()->asArray()->all(), 'unit_id', 'nama');
        echo $form->field($model, 'unit_id')->widget(Select2::classname(), ['data' => $data9, 'options' => ['id' => 'data2', 'placeholder' => 'Pilih Nama Unit Kerja'], 'pluginOptions' => ['allowClear' => true], ])->label('Pilih Unit Kerja');
                          ?>
            
    <?php
    echo $form->field($authAssignment, 'item_name')->widget(Select2::classname(), [
      'data' => $authItems,
      'options' => [
        'placeholder' => 'Pilih role ...',
      ],
      'pluginOptions' => [
        'allowClear' => true,
        //'multiple' => true,
      ],
    ])->label('Hak Akses'); ?>
  
            
            </div>
        </div>
    </div>
    
    
    

    
    <div class="form-group">
    <div class="pull-left">
      <?= Html::a('Batal', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>
    <div class="pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
