<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use \common\models\DaftarUnit;
use \common\components\HelperUnit;

/* @var $this yii\web\View */
/* @var $model backend\models\SimpelPaguSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="simpel-pagu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-4">
       
            <?php
            $data = ArrayHelper::map(\common\models\DaftarUnit::find()->asArray()->all(), 'unit_id', 'nama');
            ?>

            <?php
            echo Select2::widget([
                'name' => 'unit',
                'data' => $data,
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'options' => [
                    'id' => 'test',
                    'placeholder' => 'Pilih Unit Kerja',
                    'onchange' => '$.post( "' . Yii::$app->urlManager->createUrl('simpel-rekap/lists?id=') . '"+$(this).val(), function( data ) {
                             $("select#ids").html( data );
                             $("#hidden_div").show();
                             $("#hidden").show();
                        });',
                ]
            ]);
            ?>
        </div>
       
        <div class="col-md-2">
        <input type="text" id="sub_mak_id" class="form-control" name="sub_mak_id">
        </div>
        <div class="col-md-2">
        <input type="text" id="sub_mak_id" class="form-control" name="sub_mak_id">
        </div>
         <div class="col-md-2">
         <?php
            $thisYear = date('Y', time());
            if ($thisYear = '2015'){
                for ($yearNum = $thisYear; $yearNum >= 2015; $yearNum--) {
                $years[$yearNum] = $yearNum;
            }
            }
           
            ?>

            <select name="tahun" onchange="this.form.submit()" class="form-control">
                <?php
                foreach ($years as $key) {
                    echo '<option value="' . $key . '">' . $key . '</option>';
                }
                ?>

            </select>
        </div>
        <div class="col-md-2">
       <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>
        </div>
    </div>
    

    

    <?php ActiveForm::end(); ?>

</div>
