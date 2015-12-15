<?php

namespace backend\controllers;

use Yii;
use backend\models\SimpelPersonil;
use backend\models\SimpelKeg;
use backend\models\SimpelRekapSeacrh;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \mPDF;
use kartik\mpdf\Pdf;
use yii\data\Pagination;
use yii\base\DynamicModel;
/**
 * SimpelRekapController implements the CRUD actions for SimpelKeg model.
 */
class SimpelRekapController extends Controller {

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

        public function actionExportPdf($unit_id,$tgl_mulai,$tgl_kembali)
        {    
            $find_query = "SELECT a.* FROM simpel_personil as a LEFT JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan LEFT JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id WHERE b.status=4 and b.tgl_mulai between '".$tgl_mulai."' and '".$tgl_kembali."' and c.unit_parent_id='".$unit_id."' ";
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' => $countQuery]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
            $html = $this->renderAjax('/cetak/rekap_keg',['models'=>$models,'pages'=>$pages]);
            $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->AddPage('L', '', '', '', '', 15, 15, 5, 1, 5, 5);
            $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
            $mpdf->WriteHTML($html);
            $mpdf->Output('cetak.pdf', D);
            exit;
        }

      public function actionExport($unit_id,$tgl_mulai,$tgl_kembali)
        {    
            $find_query = "SELECT a.* FROM simpel_personil as a LEFT JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan LEFT JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id WHERE b.status=4 and b.tgl_mulai between '".$tgl_mulai."' and '".$tgl_kembali."' and c.unit_parent_id='".$unit_id."' ";
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' => $countQuery]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
         $html = $this->renderAjax('/cetak/rekap_perjadin',['models'=>$models,'pages'=>$pages]);
        $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->AddPage('L', '', '', '', '', 15, 15, 5, 1, 5, 5);
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        $mpdf->WriteHTML($html);
        $mpdf->Output('cetak.pdf', D);
        exit;
    }

    public function actionLists($id) {
        $countKokab = \common\models\DaftarUnit::find()
                ->where(['unit_parent_id' => $id])
                ->count();

        $Kokab = \common\models\DaftarUnit::find()
                ->where(['unit_parent_id' => $id])
                ->all();

        if ($countKokab > 0) {
            echo "<option ><center>- Pilih -  </center></option>";
            foreach ($Kokab as $kota) {
                echo "<option value='" . $kota->unit_id . "'>" . $kota->nama . "</option>";
            }
        } else {
            echo "<option>-</option>";
        }
    }

    

    public function actionIndex() {
        if (!empty($_GET['unit_id'])) {
            $find_query = "SELECT a.* FROM simpel_personil as a LEFT JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan LEFT JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id WHERE b.status=4 and b.tgl_mulai between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$_GET['unit_id']."' ";
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' => $countQuery]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
         

        } else {
           
            $unit = SimpelPersonil::find()->joinWith('keg')->where('simpel_keg.status = 4');
            $count = count($unit->all());
            $pages = new Pagination(['totalCount' => $count]);
            $models = $unit->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
        }

        return $this->render('index', [
                    'pages' => $pages,
                    'models' => $models,
        ]);
    }

    public function actionKeg() {
        if (!empty($_GET['unit_id'])) {
           $find_query = "SELECT a.* FROM simpel_personil as a LEFT JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan LEFT JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id WHERE b.status=4 and b.tgl_mulai between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$_GET['unit_id']."' ";
            //  echo $find_query;
            // die();
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' => $countQuery]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
        } else {
            $unit = SimpelPersonil::find()->joinWith('keg')->where('simpel_keg.status = 4');
            $count = count($unit->all());
            $pages = new Pagination(['totalCount' => $count]);
            $models = $unit->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
        }
        return $this->render('keg', [
                    'pages' => $pages,
                    'models' => $models,
        ]);
    }
    public function actionMonikeg() {

        // get your HTML raw content without any layouts or scripts
        if (!empty($_GET['unit_id'])) {
            $find_query = "SELECT c.* FROM simpel_keg as a
                            LEFT JOIN pegawai.daf_unit b ON  a.unit_id = b.unit_id
                            LEFT JOIN simpel_personil c ON  a.id_kegiatan = c.id_kegiatan
                          WHERE (unit_parent_id='" . $_GET['unit_id'] . "') and tgl_berangkat='" . $_GET['tgl_mulai'] . "' or tgl_kembali='" . $_GET['tgl_kembali'] . "' and c.status=4 group by pegawai_id";
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' => $countQuery]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
        } else {
            $unit = SimpelPersonil::find()->joinWith('keg')->where('simpel_keg.status = 4')->groupBy('pegawai_id');
            $count = count($unit->all());
            $pages = new Pagination(['totalCount' => $count]);
            $models = $unit->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
        }
        return $this->render('monikeg', [
                    'pages' => $pages,
                    'models' => $models,
        ]);
    }
  
   
}
