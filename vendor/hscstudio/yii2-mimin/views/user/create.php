<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\administrator\models\User */

$this->title = 'Tambah Pengguna';
$this->params['breadcrumbs'][] = ['label' => 'Daftar User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
         'authAssignment' => $authAssignment,
                        'authItems' => $authItems,
    ]) ?>

</div>
