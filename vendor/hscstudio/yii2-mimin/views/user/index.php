<?php

use yii\helpers\Html;
use yii\grid\GridView;
use hscstudio\mimin\components\Mimin;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\administrator\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    
<div class="block">
<div class="block-title">
<h2><?= Html::encode($this->title) ?></h2>
  
    <div class="block-options pull-right">
     <?php
        if ((Mimin::filterRoute($this->context->id.'/create'))){ ?>
<?= Html::a(Yii::t('app', 'Tambah User'), ['create'], ['class' => 'btn btn-alt btn-sm btn-default', 'data-toggle'=>'tooltip', 'title'=>'','data-original-title'=>'Tambah User']) ?>


<?php } ?>
</div>
</div>
<div class="wp-posts-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
              [
              'header'=>'Unit Kerja',
              'filter' => Html::activeDropDownList($searchModel, 'unit_id', ArrayHelper::map(\common\models\DaftarUnit::find()->asArray()->all(), 'unit_id', 'nama'),['class'=>'form-control','prompt' => 'Select Category']),
              'value'=>'unit.nama',
            ],
            [
              'attribute' => 'roles',
              'format' => 'raw',
              
              'value' => function($data){
                $roles = [];
                foreach ($data->roles as $role) {
                  $roles[]= $role->item_name;
                }
                return Html::a(implode(', ',$roles),['view','id'=>$data->id]);
              }
            ],

            [
              'attribute' => 'status',
              'format' => 'raw',
              'filter' => [10 => 'Aktif', 2 => 'Banned'],
              'options' => [
                'width' => '80px',
              ],
              'value' => function($data){
                if(!$data=='0')
                  return "<span class='label label-primary'>".'Active'."</span>";
                else
                  return "<span class='label label-danger'>".'Banned'."</span>";
              }
            ],
            [
              'attribute' => 'created_at',
              'format' => ['date','php:d M Y H:i:s'],
              'options' => [
                'width' => '120px',
              ],
            ],
            [
              'attribute' => 'updated_at',
              'format' => ['date','php:d M Y H:i:s'],
              'options' => [
                'width' => '120px',
              ],
            ],
           [
          'class' => 'yii\grid\ActionColumn',
          'template' => Mimin::filterTemplateActionColumn(['update','delete','view'],$this->context->route),
      
        ]
        ],
    ]); ?>
   
                    </div>
                    </div>


</div>
