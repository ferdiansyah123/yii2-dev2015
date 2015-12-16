<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\administrator\models\User */


?>
<div class="user-view">
<div class="container">
<?= Html::a('Ubah Data', ['profile', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
<br/>
<br/>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
           
            'email:email',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>
    </div>
    </div>
       