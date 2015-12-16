<?php

use yii\helpers\Html;
use yii\grid\GridView;
use hscstudio\mimin\components\Mimin;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\administrator\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
		if ((Mimin::filterRoute($this->context->id.'/create'))){
     echo Html::a('Create Note', ['create'], ['class' => 'btn btn-success']);


}
	?>
    </p>
<div class="block">
<div class="block-title">
<h2><?= Html::encode($this->title) ?></h2>
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
              'attribute' => 'roles',
              'format' => 'raw',
              'value' => function($data){
                $roles = [];
                foreach ($data->roles as $role) {
                  $roles[]= $role->item_name;
                }
                return Html::a(implode(', ',$roles),['view','id'=>$data->user_id]);
              }
            ],
            [
              'attribute' => 'status',
              'format' => 'raw',
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
              'header'=>'Unit Kerja',
              'filter' => Html::activeDropDownList($searchModel, 'unit_id', ArrayHelper::map(\common\models\DaftarUnit::find()->asArray()->all(), 'unit_id', 'nama'),['class'=>'form-control','prompt' => 'Select Category']),
              'value'=>'unit.nama',
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
