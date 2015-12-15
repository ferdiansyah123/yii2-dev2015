<?php

namespace backend\controllers;

class SimpelLaporanController extends \yii\web\Controller {

    public $layout = 'admin';

    public function actionIndex() {
        return $this->render('index');
    }
    public function actionMak() {
        return $this->render('max');
    }
    // Awal Pimpinan1
    public function actionPim() {
        return $this->render('pimpinan1_real');
    }
    public function actionPimmak() {
        return $this->render('pimpinan1_real_mak');
    }
    //Akhir Pimpinan1

    // Awal Pimpinan12
    public function actionPimd() {
        return $this->render('index');
    }
    public function actionPimdmak() {
        return $this->render('max');
    }
    //Akhir Pimpinan2

    // Awal User
    public function actionUser() {
        return $this->render('index');
    }
    public function actionUsermak() {
        return $this->render('max');
    }
    //Akhir User
}
