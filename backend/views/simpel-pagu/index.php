<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\SqlDataProvider;
use yii\widgets\ActiveForm;
use common\components\HelperUnit;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SimpelPaguSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pengaturan');
$this->params['breadcrumbs'][] = $this->title;

$this->params['breadcrumbs'][] = 'Pagu Mak';
?>
<div class="simpel-pagu-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
    </p>
  
        
    </table>
<div class="block">
    <div class="block-title">
        <h2>Pengaturan Pagu Anggaran BAPETEN <?= date('Y') ?></h2>
        <div class="block-options pull-right">
        
        </div>
    </div>
    <div class="wp-posts-index">

 <?php echo $this->render('_search', ['model' => $dataProvider->getModels()]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

                'tahun',
                'kd_satker',
                'nas_prog_id',
                'nas_keg_id',
                'kdoutput',
                'kdsoutput',
                'kdkmpnen',
                'kdskmpnen',
                'kode_mak',
                'alokasi_sub_mak',
                
                 
                 [
                            'attribute' => 'Unit Kerja',
                            'headerOptions' => ['width' => '200'],

                            'value' => function($data) {
                        return HelperUnit::unit($data->unit_id);
                    }
                        ,
                        ],
        ],
    ]); ?>

</div>
</div>
</div>
</div>
