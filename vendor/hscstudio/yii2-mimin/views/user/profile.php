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
    <div class="row">
        
<div class="col-sm-6 col-md-6">
        <div class="widget">
            <div class="widget-simple ">
                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
 
    <?= $form->field($model, 'status')->radioList(array('0'=>'Tidak Aktif',10=>'Aktif')); ?>
    <?= $form->field($model, 'unit_id')->hiddenInput(['maxlength' => true])->label(false) ?>
    <?= $form->field($model, 'nip')->hiddenInput(['maxlength' => true])->label(false) ?>
     
             

            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-md-6">
        <div class="widget">
            <div class="widget-simple ">
             <?php if (!$model->isNewRecord){ ?>
      <strong> Biarkan kosong jika tidak ingin mengubah password</strong>
      <div class="ui divider"></div>
      <?= $form->field($model, 'password') ?>
     

    <?php } ?>
            </div>
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
