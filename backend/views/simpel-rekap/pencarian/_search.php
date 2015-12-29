<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use \common\components\MyHelper;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SimpelRekapSeacrh */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
         <form class="FormAjax" method="get" action="">
                <div class="simpel-keg-search">

                    <div class="block">
                        <div class="block-title">
                            <h2>Pencarian</h2>
                        </div>
                        <div class="wp-posts-index">
                            <div class="container-fluid">
                                        <div class="row">
                                    <div class="col-md-4">
                                        Satuan Kerja
                                    </div>
                                    <div class="col-md-8">
                                        <?= \common\components\HelperUnit::Unit(Yii::$app->user->identity->unit_id); ?><br/>
                                       <input type="hidden" name="unit" value="<?= Yii::$app->user->identity->unit_id; ?>">
                                    </div>
                                </div>
                                <hr/>
                                <div class="row"  >
                                    <div class="col-md-4">
                                        Unit Kerja Mak
                                    </div>
                                    <div class="col-md-8">
                                        <?php
                                        $data = ArrayHelper::map(\common\models\DaftarUnit::find()->where('unit_parent_id='.Yii::$app->user->identity->unit_id)->asArray()->all(), 'unit_id', 'nama');
                                        ?>
                                        <?php
                                        echo Select2::widget([
                                            'name' => 'unit_id',
                                            'data' => $data,
                                            'options' => [
                                                'id' => 'ids',
                                                'placeholder' => 'Pilih Unit Kerja Kerja',
                                            ],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'format' => 'yyyy-m-d'
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div>
                                <hr/>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-4">
                                        Bulan / Tahun
                                    </div>
                                    <div class="col-md-8">
                                        <table>
                                            <tr>
                                                <td>
                                                    <?php
                                                    echo DatePicker::widget([
                                                        'name' => 'tgl_mulai',
                                                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'yyyy-mm-dd'
                                                        ]
                                                    ]);
                                                    ?>

                                                </td>
                                                <td align="center" width="50">s/d</td>
                                                <td>
                                                    <?php
                                                    echo DatePicker::widget([
                                                        'name' => 'tgl_kembali',
                                                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'yyyy-mm-dd'
                                                        ]
                                                    ]);
                                                    ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <hr/>
                               <!--  <div class="row">
                                    <div class="col-md-4">
                                        Tahun
                                    </div>
                                    <div class="col-md-8">
                                        <?php
                                        $thisYear = date('Y', time());
                                        for ($yearNum = $thisYear; $yearNum >= 2010; $yearNum--) {
                                            $years[$yearNum] = $yearNum;
                                        }
                                        ?>
                                        <select name="tahun" onchange="this.form.submit()" class="form-group">
                                            <?php
                                            foreach ($years as $key) {
                                                echo '<option value="' . $key . '">' . $key . '</option>
                                                            ';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div> -->
                            </div>

                            <?php echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?></div>
                    </div>
                </div>

            </form>
