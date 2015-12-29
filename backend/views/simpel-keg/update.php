<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SimpelKeg */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Simpel Keg',
]) . ' ' . $model->id_kegiatan;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Simpel Kegs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_kegiatan, 'url' => ['view', 'id' => $model->id_kegiatan]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="simpel-keg-update">

<?php
	switch ($model->negara) {
		case 1: 
		echo $this->render('_form', [
        'model' => $model,
    	]);
			break;
		
		case 2:
			echo $this->render('_form_luar', [
        'model' => $model,
    	]);
			break;
		
	}
	?>
    

</div>
