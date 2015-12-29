<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\components\MyHelper;
use yii\helpers\ArrayHelper;
use hscstudio\mimin\components\Mimin;
use common\components\HelperUnit;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SimpelKegSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', ' Perjalanan Dinas');
$this->params['breadcrumbs'][] = 'Proses';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="simpel-keg-index">
<div class="block">
<div class="block-title">
   <ul class="nav nav-tabs ">
            <li >
                <a href="<?= Url::to(['simpel-keg/index']) ?>" >
                    Daftar Permohonan Dinas</a>
            </li>
            <li class="active">
                <a href="<?= Url::to(['simpel-keg/dinas']) ?>" >
                    Daftar Perjalanan Dinas</a>
            </li>
            <li>
                <a href="<?= Url::to(['simpel-keg/vcetak']) ?>" >
                    Cetak </a>
            </li>
            <li>
                <a href="<?= Url::to(['simpel-keg/bendahara']) ?>" >
                    Bendahara </a>
            </li>
            <li >
                <a href="<?= Url::to(['simpel-keg/varsip']) ?>" >
                    Arsip </a>
            </li>
            <?php if ((Mimin::filterRoute($this->context->id . '/log'))) { ?>
                <li >
                    <a href="<?= Url::to(['simpel-keg/log']) ?>" >
                        Log Proses </a>
                </li>
                       <?php } ?>
        </ul>
</div>
 <?php
Pjax::begin(['id' => 'dinasSearch']);
$url_search = Url::to(['simpel-keg/search-dinas']);
$js =<<<js
$("#searchQuery").keyup(function(){
    $("#datadinasGridview").load("{$url_search}"+"?search="+$(this).val());
});


 
js;
$this->registerJS($js);
?>
<div class="wp-posts-index">

<div class="row">
    <div class="col-lg-6">
         <form class="FormAjax" method="get" action="">
            <div class="input-group">
                 
                       <select   name="limit" class="form-control" onchange="this.form.submit()">
                      
                         <option value="1">10</option>
                         <option value="2">20</option>
                         <option value="3">30</option>
                         <option value="">40</option>
                         <option value="">50</option>
                         <option value="">100</option>
                    
                                
                    </select>
            </div>
        </form>

    </div>
    <div class="col-lg-6">
        <form class="FormAjax" method="get" action="">
            <div class="input-group">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                <input id="searchQuery" type="text" class="form-control" placeholder="masukkan Tgl,Akun Mak Nama Kegiatan">
                  
                <span class="input-group-btn">
                    <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
        </form>
    </div>
</div>
   <h3 align="center">Daftar Kegiatan Berdasarkan Unit Kerja </h3>
 <h3 align="center"><?= HelperUnit::unit($_GET['unit']) ?> </h3>
<br/>
<div id="datadinasGridview">
   <?= GridView::widget([
        'dataProvider' => $dataDinas,
        'rowOptions'=>function($model){
                                             if($model['status_edit'] == 1){

                                                    return ['class' => 'danger'];
                                             }else{

                                             }
                                        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
             [
                'attribute' => 'Tanggal',
                'headerOptions' => ['width' => '200'],
                'value' => function($data) {
            return substr($data['tgl_mulai'], 8, 2) . ' -  ' . substr($data['tgl_selesai'], 8, 2) . '  ' . \common\components\MyHelper::BacaBulan(substr($data['tgl_mulai'], 5, 2)) . '  ' . substr($data['tgl_mulai'], 0, 4);
                }
            ],
            'mak',
           [
                                            'header' => 'Maksud',
                                            'format' => 'html',
                                            'contentOptions' => ['style' => 'width:490px; z-index:200;'],
                                            'value' => function($data) {
                                        return Html::a($data['nama_keg'], Yii::$app->urlManager->createUrl(['simpel-keg/create', 'id' => $data['id_kegiatan']]), [
                                                    'title' => Yii::t('yii', 'Proses'),
                                        ]);
                                    }
                                        ],
             [
                                            'header' => 'Negara',
                                            'format' => 'html',
                                            'value'=>function($data){
                                                if($data['negara'] == 1){
                                                    return 'Dalam Negri';
                                                }else{
                                                    return 'Luar Negri' ;
                                                }
                                            }
                                        ],
                                        [
                                            'header' => 'Anggaran (Rp)/
                                                         Jum Personil',
                                            'contentOptions' => ['style' => 'width:140px; z-index:200;'],
                                            'format' => 'html',
                                            'value' => function($data) {
                                         return MyHelper::CountAng($data['id_kegiatan']);

                                    }
                                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'contentOptions' => ['style' => 'width:90px; z-index:20;'],
                            'header' => 'Actions',
                            'template' => Mimin::filterTemplateActionColumn(['view','delete'], $this->context->route),
                            'buttons' => [

                                'view' => function ($url, $model) {
                                        switch ($model['negara']) {
                                            case 1:
                                                return Html::button('<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> ', ['value' =>
                                                Url::to(['update', 'id' => $model['id_kegiatan']]), 'class' => 'modalButton btn btn-info', 'title' => 'Lanjut Proses']);
                                                break;
                                           case 2:
                                                return Html::button('<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> ', ['value' =>
                                                Url::to(['update', 'id' => $model['id_kegiatan']]), 'class' => 'modalButton btn btn-danger', 'title' => 'Lanjut Proses']);
                                                break;
                                         
                                        }
                                           
                                        
                                    },
                                'delete'=> function ($url, $model){

                                    return  Html::a('<img src="' . Url::to(['/images/delete.png']) . '" alt="Hapus" title="Hapus" width="25" height="25"/>', ['/simpel-keg/delete', 'id' => $model->id_kegiatan], [
                                            
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this item?',
                                                'method' => 'post',
                                            ],
                                        ]);
                                }

                                    ],
                                ],
        ],
    ]); ?>
</div>

</div>
</div>
</div>
<?php
Pjax::end();
?>
<style type="text/css">
    .danger{
        background-color: blue;
    }
</style>
<?php
$js = <<<Modal
$(function () {
    $('.modalButton').click(function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });

})
Modal;
$this->registerJs($js);

?>

<?php
Modal::begin([
    'header' => 'Ubah Perjalanan Dinas',
    'options' => [
        'id' => 'modal',
        'tabindex' => false // important for Select2 to work properly
    ],
    'id' => 'modal',
    'size' => 'bigModal',
]);
echo "<div id='modalContent'></div>";

Modal::end();

?> 

