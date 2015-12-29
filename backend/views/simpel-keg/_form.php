<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\HelperUnit;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\SimpelKeg */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="simpel-keg-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'mak')->textInput(['readonly'=>true]) ?>

            <?= $form->field($model, 'nama_keg')->textInput(['readonly'=>true,'maxlength' => true]) ?>

             <?php
                $data = ArrayHelper::map(\backend\models\DafKota::find()->asArray()->all(), 'kab_id', 'nama');
                echo $form->field($model, 'berangkat_asal')->widget(Select2::classname(), [
                    'data' => $data,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['id' => 'brkota',  'placeholder' => 'Pilih Kota Keberangkatan'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]);
                ?>
              <?php
            echo $form->field($model, 'tgl_mulai')->widget(DatePicker::classname(), [
                'options' => ['value' => $result['renc_tgl_mulai'], 'placeholder' => 'Pilih Tanggal'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-m-d',
                ]
            ])->label('Tanggal Keberangkatan');
            ?>

           <?php
                echo $form->field($model, 'tgl_penugasan')->widget(DatePicker::classname(), [
                    'options' => [ 'placeholder' => 'Pilih Tanggal'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-m-d',
                    ]
                ])->label('Tanggal Penugasan');
                ?>

            <div class="form-group field-simpelkeg-unit_id required">
            <label class="control-label" for="simpelkeg-unit_id">Unit Kerja</label><br/>
            <?= HelperUnit::unit($model->unit_id) ?>

            <div class="help-block"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group field-simpelkeg-unit_id required">
            <label class="control-label" for="simpelkeg-unit_id">Nama PPK</label><br/>
            <?= HelperUnit::Pegawai($model->nip_ppk) ?>

            <div class="help-block"></div>
            </div>

            <?= $form->field($model, 'no_spd')->textInput(['readonly'=>true,'maxlength' => true]) ?>

             <?php
                $data = ArrayHelper::map(\backend\models\DafKota::find()->asArray()->all(), 'kab_id', 'nama');
                echo $form->field($model, 'tujuan')->widget(Select2::classname(), [
                    'data' => $data,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['id' => 'jk',  'placeholder' => 'Pilih Kota Keberangkatan'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]);
                ?>
            <?php
            echo $form->field($model, 'tgl_selesai')->widget(DatePicker::classname(), [
                'options' => ['value' => $result['renc_tgl_mulai'], 'placeholder' => 'Pilih Tanggal'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-m-d',
                ]
            ])->label('Tanggal Kembali');
            ?>


            <?php
            $data = ArrayHelper::map(\common\models\Pegawai::find()->asArray()->all(), 'nip', 'nama_cetak');
            echo $form->field($model, 'nip_bpp')->widget(Select2::classname(), [
                'data' => $data,
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Pilih Nama BPP'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Pilih Nama BPP');
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update Data Perjadin'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
