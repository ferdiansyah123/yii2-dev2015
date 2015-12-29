<?php

namespace backend\controllers;

use Yii;
use backend\models\SimpelPersonil;
use backend\models\SimpelPersonilSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\SimpelRincianBiaya;
use dosamigos\qrcode\QrCode;

/**
 * SimpelPersonilController implements the CRUD actions for SimpelPersonil model.
 */
class SimpelPersonilController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all SimpelPersonil models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SimpelPersonilSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SimpelPersonil model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SimpelPersonil model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new SimpelPersonil();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_personil]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SimpelPersonil model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_personil]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SimpelPersonil model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        Yii::$app->db->createCommand('DELETE FROM simpel_rincian_biaya WHERE  personil_id=' . $id)->execute();
        $this->findModel($id)->delete();

        return $this->redirect(['./simpel-keg/create', 'id' => $model->id_kegiatan]);
    }

    public function actionVqrcode($id) {
        $model2 = SimpelPersonil::find()->where('id_personil=' . $id)->all();
        return $this->renderAjax('v_qrcode', [
                    'model' => $this->findModel($id),
                    'model2' => $model2,
        ]);
    }

    public function actionVqrcod($id) {
        $model2 = SimpelPersonil::find()->where('id_personil=' . $id)->all();
        return $this->renderAjax('v_qrcode_luar', [
                    'model' => $this->findModel($id),
                    'model2' => $model2,
        ]);
    }

    public function actionQrcode($id) {
        $model = $this->findModel($id); //untuk membaca id daftar kegiatan
        $model2 = SimpelPersonil::find()->where('id_kegiatan=' . $id)->all();
        $uri = Yii::$app->urlManagerr->createUrl(['simpel-personil/vqrcode', 'id' => $id]);
        return QRcode::png($uri);
    }

    public function actionQrcod($id) {
        $model = $this->findModel($id); //untuk membaca id daftar kegiatan
        $model2 = SimpelPersonil::find()->where('id_kegiatan=' . $id)->all();
        $uri = Yii::$app->urlManagerr->createUrl(['simpel-personil/vqrcod', 'id' => $id]);
        return QRcode::png($uri);
    }

    public function actionEdit($id) {
        $model = $this->findModel($id);
        $model2 = \backend\models\SimpelKeg::find()->where('id_kegiatan=' . $model->id_kegiatan)->one();
        if ($_POST) {
            //print_r($_POST);
            //die();
                $model->id_kegiatan = $model2->id_kegiatan;
             if(!empty($_POST['SimpelPersonil']['pegawai_id'])){
                $model->pegawai_id = $_POST['SimpelPersonil']['pegawai_id'];
                
                $model->pejabat = $_POST['SimpelPersonil']['pejabat'];
                $model->tingkat_id = $_POST['SimpelPersonil']['tingkat_id'];
                $model->nama = 0;
                $model->nip = 0;
                $model->gol = 0;
                $model->jab = 0;
                $model->instansi = 0;
                $model->pnama = 0;
                $model->pnip = 0;
                $model->pjab = 0;
            }else{
                $model->pegawai_id = 0;
               
                $model->pejabat = 0;
                $model->tingkat_id = 0;
                $model->nama = $_POST['SimpelPersonil']['nama'];
                $model->nip = $_POST['SimpelPersonil']['nip'];
                $model->gol = $_POST['SimpelPersonil']['gol'];
                $model->jab = $_POST['SimpelPersonil']['jab'];
                $model->instansi = $_POST['SimpelPersonil']['instansi'];
            
                $model->pnama = $_POST['SimpelPersonil']['nama'];
                $model->pnip = $_POST['SimpelPersonil']['pnip'];
                $model->pjab = $_POST['SimpelPersonil']['pjab'];

            }
            $model->no_sp = $_POST['SimpelPersonil']['no_sp'];
            $model->tgl_penugasan = $_POST['SimpelPersonil']['tgl_penugasan'];
            $model->tgl_berangkat = $_POST['SimpelKeg']['tgl_mulai'];
            $model->tgl_kembali = $_POST['SimpelKeg']['tgl_selesai'];
            $model->uang_makan = $_POST['SimpelPersonil']['uang_makan'];
            $model->angkutan = $_POST['SimpelPersonil']['angkutan'];
            
            if ($model->save()) {

                $data = count($_POST['rows']);
                for ($i = 1; $i <= $data; $i++) {
                    $model3 = SimpelRincianBiaya::findOne($_POST['id_rincian_biaya' . $i]);
                   // print_r($_POST['bukti_kwitansi' . $i]);
                    $model3->id_kegiatan = $model2->id_kegiatan;
                    $model3->kat_biaya_id = $model3->kat_biaya_id;
                    $model3->harga_satuan = $_POST['satuan' . $i];
                    $model3->bukti_kwitansi = $_POST['bukti_kwitansi' . $i];
                    $model3->volume = $_POST['volume' . $i];
                    $model3->jml = $_POST['jml' . $i];
                    $model3->uraian_rincian = $_POST['uraian_rincian' . $i];
                    $model3->save();
                }
                //die();
            }

            return $this->redirect(['/simpel-keg/create', 'id' => $model->id_kegiatan]);
        } else {
            switch ($model2->negara) {
                case "1":
                    return $this->renderAjax('input', [
                                'model' => $model,
                                'model2' => $model2,
                    ]);
                case "2":
                    return $this->renderAjax('input_luar', [
                                'model' => $model,
                                'model2' => $model2,
                    ]);
                    break;
            }
        }
    }

    public function actionLuar($id) {
        $model = $this->findModel($id);
        $model2 = \backend\models\SimpelKeg::find()->where('id_kegiatan=' . $model->id_kegiatan)->one();
        if ($_POST) {
            // print_r($_POST);
            // die();
                $model->id_kegiatan = $model2->id_kegiatan;
             if(!empty($_POST['SimpelPersonil']['pegawai_id'])){
                $model->pegawai_id = $_POST['SimpelPersonil']['pegawai_id'];
                
                $model->pejabat = $_POST['SimpelPersonil']['pejabat'];
                $model->tingkat_id = $_POST['SimpelPersonil']['tingkat_id'];
                $model->nama = 0;
                $model->nip = 0;
                $model->gol = 0;
                $model->jab = 0;
                $model->instansi = 0;
                $model->pnama = 0;
                $model->pnip = 0;
                $model->pjab = 0;
            }else{
                $model->pegawai_id = 0;
               
                $model->pejabat = 0;
                $model->tingkat_id = 0;
                $model->nama = $_POST['SimpelPersonil']['nama'];
                $model->nip = $_POST['SimpelPersonil']['nip'];
                $model->gol = $_POST['SimpelPersonil']['gol'];
                $model->jab = $_POST['SimpelPersonil']['jab'];
                $model->instansi = $_POST['SimpelPersonil']['instansi'];
            
                $model->pnama = $_POST['SimpelPersonil']['nama'];
                $model->pnip = $_POST['SimpelPersonil']['pnip'];
                $model->pjab = $_POST['SimpelPersonil']['pjab'];

            }
            $model->no_sp = $_POST['SimpelPersonil']['no_sp'];
            $model->tgl_penugasan = $_POST['SimpelPersonil']['tgl_penugasan'];
            $model->tgl_berangkat = $_POST['SimpelKeg']['tgl_mulai'];
            $model->tgl_kembali = $_POST['SimpelKeg']['tgl_selesai'];
            $model->uang_makan = $_POST['SimpelPersonil']['uang_makan'];
            $model->angkutan = $_POST['SimpelPersonil']['angkutan'];
            
            if ($model->save()) {

                $data = count($_POST['rows']);
                for ($i = 1; $i <= $data; $i++) {
                    $model3 = SimpelRincianBiaya::findOne($_POST['id_rincian_biaya' . $i]);
                    $model3->id_kegiatan = $model2->id_kegiatan;
                    $model3->kat_biaya_id = $model3->kat_biaya_id;
                    $model3->harga_satuan = $_POST['satuan' . $i];
                    $model3->bukti_kwitansi = $_POST['bukti_kwitansi' . $i];
                    $model3->volume = $_POST['volume' . $i];
                    $model3->jml = $_POST['jml' . $i];
                    $model3->pagu = $_POST['pagu' . $i];
                    $model3->persen = $_POST['persen' . $i];
                    $model3->uraian_rincian = $_POST['uraian_rincian' . $i];
                    $model3->save();
                }
                // die();
            }

            return $this->redirect(['/simpel-keg/create', 'id' => $model->id_kegiatan]);
        } else {
            switch ($model2->negara) {
                case "1":
                    return $this->renderAjax('input', [
                                'model' => $model,
                                'model2' => $model2,
                    ]);
                case "2":
                    return $this->renderAjax('input_luar', [
                                'model' => $model,
                                'model2' => $model2,
                    ]);
                    break;
            }
        }
    }

    /**
     * Finds the SimpelPersonil model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SimpelPersonil the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SimpelPersonil::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
