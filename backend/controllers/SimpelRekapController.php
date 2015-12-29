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
use yii\data\SqlDataProvider;
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
            $find_query = "SELECT a.* FROM simpel_personil as a
             INNER JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             INNER JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
              WHERE b.status in(2,3,4) and b.tgl_mulai between '".$tgl_mulai."' and '".$tgl_kembali."' and c.unit_parent_id='".$unit_id."' ";
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' => $countQuery]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
            $html = $this->renderAjax('/cetak/rekap/rekap_keg',['models'=>$models,'pages'=>$pages]);
            $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
            
            $mpdf->SetDisplayMode('fullpage');
           
            $mpdf->setFooter('Dokumen Digital Versi Elektronik dari SIMPEL - BAPETEN Tanggal'.date('d-m-Y H:is  ').'Hal.   {PAGENO}  / {nb}');
            $mpdf->AddPage('L', '', '', '', '', 15, 15, 20, 10, 50, 5);
            $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
            $mpdf->WriteHTML($html);
            $mpdf->Output('cetak.pdf', I);
            exit;
        }
         public function actionExportLuar($unit_id,$tgl_mulai,$negara, $tgl_kembali)
        {    
            $find_query = "SELECT a.*, b.tujuan FROM simpel_personil as a INNER JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan INNER JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id WHERE b.status in(2,3,4) and b.tgl_mulai between '".$tgl_mulai."' and '".$tgl_kembali."' and c.unit_parent_id='".$unit_id."' ";
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' => $countQuery]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
            $html = $this->renderAjax('/cetak/rekap/rekap_kegiatan_luar',['models'=>$models,'pages'=>$pages]);
            $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
            
            $mpdf->SetDisplayMode('fullpage');
           
            $mpdf->setFooter('Dokumen Digital Versi Elektronik dari SIMPEL - BAPETEN Tanggal'.date('d-m-Y H:is  ').'Hal.   {PAGENO}  / {nb}');
            $mpdf->AddPage('L', '', '', '', '', 15, 15, 20, 10, 50, 5);
            $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
            $mpdf->WriteHTML($html);
            $mpdf->Output('cetak.pdf', I);
            exit;
        }

    //export pimpinan2 
     public function actionExportPdfd($unit_id,$tgl_mulai,$tgl_kembali)
        {    
            $find_query = "SELECT a.* FROM simpel_personil as a INNER JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan INNER JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id WHERE b.status in(2,3,4) and b.tgl_mulai between '".$tgl_mulai."' and '".$tgl_kembali."' and c.unit_id='".$unit_id."' ";
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' => $countQuery]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
            $html = $this->renderAjax('/cetak/rekap/rekap_keg',['models'=>$models,'pages'=>$pages]);
            $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->setHeader('Hello');
            $mpdf->setFooter('Dokumen Digital Versi Elektronik dari SIMPEL - BAPETEN Tanggal'.date('d-m-Y H:is  ').'Hal.   {PAGENO}  / {nb}');
           
            $mpdf->AddPage('L', '', '', '', '', 15, 15, 5, 1, 5, 5);
            $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list

            $mpdf->WriteHTML($html);
            $mpdf->Output('cetak.pdf', D);
            exit;
        }

      public function actionExport($unit_id,$tgl_mulai,$tgl_kembali)
        {    
            $find_query = "SELECT a.* FROM simpel_personil as a INNER JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan INNER JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id WHERE b.status in(2,3,4) and b.tgl_mulai between '".$tgl_mulai."' and '".$tgl_kembali."' and c.unit_parent_id='".$unit_id."' ";
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' => $countQuery]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
         $html = $this->renderAjax('/cetak/rekap/rekap_perjadin',['models'=>$models,'pages'=>$pages]);
        $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->AddPage('L', '', '', '', '', 15, 15, 20, 10, 50, 5);
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
      $mpdf->setFooter('Dokumen Digital Versi Elektronik dari SIMPEL - BAPETEN Tanggal'.date('d-m-Y H:is  ').'Hal.   {PAGENO}  / {nb}');
        
        $mpdf->WriteHTML($html);
        $mpdf->Output('cetak.pdf', I);
        exit;
    }

    //export pimpinan2
        public function actionExportd($unit_id,$tgl_mulai,$tgl_kembali)
        {    
            $find_query = "SELECT a.* FROM simpel_personil as a
              INNER JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan
              INNER JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id 
              WHERE b.status in(2,3,4) and b.tgl_mulai between '".$tgl_mulai."' and '".$tgl_kembali."' and c.unit_id='".$unit_id."'  ";
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' => $countQuery]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
         $html = $this->renderAjax('/cetak/rekap/rekap_perjadin',['models'=>$models,'pages'=>$pages]);
        $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->AddPage('L', '', '', '', '', 15, 15, 5, 1, 5, 5);
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        $mpdf->setFooter('Dokumen Digital Versi Elektronik dari SIMPEL - BAPETEN Tanggal'.date('d-m-Y H:is').'Hal {PAGENO}');

        $mpdf->WriteHTML($html);
        $mpdf->Output('cetak.pdf', D);
        exit;
    }

     //export User
        public function actionExportuser($unit,$tgl_mulai,$tgl_kembali)
        {    
            $find_query = "SELECT a.* FROM simpel_personil as a INNER JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan INNER JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id WHERE b.status in(2,3,4) and b.tgl_mulai between '".$tgl_mulai."' and '".$tgl_kembali."' and c.unit_id='".$unit."' ";
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' => $countQuery]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
         $html = $this->renderAjax('/cetak/rekap/user',['models'=>$models,'pages'=>$pages]);
        $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->AddPage('L', '', '', '', '', 15, 15, 5, 1, 5, 5);
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        $mpdf->setFooter('Dokumen Digital Versi Elektronik dari SIMPEL - BAPETEN Tanggal'.date('d-m-Y H:is').'Hal {PAGENO}');
        $mpdf->WriteHTML($html);
        $mpdf->Output('cetak.pdf', D);
        exit;
    }

      //export User keg
        public function actionExportuserkeg($unit,$tgl_mulai,$tgl_kembali)
        {    
            $find_query = "SELECT a.* FROM simpel_personil as a INNER JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan INNER JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id WHERE b.status in(2,3,4) and b.tgl_mulai between '".$tgl_mulai."' and '".$tgl_kembali."' and c.unit_id='".$unit."' ";
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
        $mpdf->setFooter('Dokumen Digital Versi Elektronik dari SIMPEL - BAPETEN Tanggal'.date('d-m-Y H:is').'Hal {PAGENO}');
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
             $sql ="SELECT a.*, b.tujuan FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$_GET['unit_id']."'";
            
             $hitung = "SELECT count(*) as jml FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$_GET['unit_id']."'";
            
             $c = Yii::$app->db->createCommand($hitung)->queryScalar();
             $count = Yii::$app->db->createCommand($sql)->queryScalar();
             $dataAdmin = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => intval($c),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        }

        return $this->render('/simpel-rekap/admin/index', [
                    'dataAdmin' => $dataAdmin,
        ]);
    }

    public function actionKeg() {
       
        if (!empty($_GET['unit_id'])) {
             $sql ="SELECT a.*, b.tujuan, b.negara_tujuan, b.kota_negara FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and b.negara=".$_GET['negara']." and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$_GET['unit_id']."'";
            
             $hitung = "SELECT count(*) as jml FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and b.negara=".$_GET['negara']." and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$_GET['unit_id']."'";
            
             $c = Yii::$app->db->createCommand($hitung)->queryScalar();
             $count = Yii::$app->db->createCommand($sql)->queryScalar();
             $dataAdmin = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => intval($c),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        }

        return $this->render('/simpel-rekap/admin/render_keg', [
                    'dataAdmin' => $dataAdmin,
        ]);
    }
    public function actionMonikeg() {
       
        if (!empty($_GET['unit_id'])) {
             $sql ="SELECT a.*, b.tujuan FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$_GET['unit_id']."' ";
            
             $hitung = "SELECT count(*) as jml FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$_GET['unit_id']."'";
            
             $c = Yii::$app->db->createCommand($hitung)->queryScalar();
             $count = Yii::$app->db->createCommand($sql)->queryScalar();
             $dataAdmin = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => intval($c),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        }

        return $this->render('/simpel-rekap/admin/monikeg', [
                    'dataAdmin' => $dataAdmin,
        ]);
    }

    //rekapitulasi untuk pimpinan1

    public function actionPimpinan() {
       
        if (!empty($_GET['unit_id'])) {
             $sql ="SELECT a.*, b.tujuan FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$_GET['unit_id']."'";
            
             $hitung = "SELECT count(*) as jml FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$_GET['unit_id']."'";
            
             $c = Yii::$app->db->createCommand($hitung)->queryScalar();
             $count = Yii::$app->db->createCommand($sql)->queryScalar();
             $dataAdmin = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => intval($c),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        }

        return $this->render('/simpel-rekap/pimpinan1/index', [
                    'dataAdmin' => $dataAdmin,
        ]);
    }
    public function actionPimpinankeg() {
       
        if (!empty($_GET['unit_id'])) {
             $sql ="SELECT a.*, b.tujuan FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$_GET['unit_id']."'";
            
             $hitung = "SELECT count(*) as jml FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$_GET['unit_id']."'";
            
             $c = Yii::$app->db->createCommand($hitung)->queryScalar();
             $count = Yii::$app->db->createCommand($sql)->queryScalar();
             $dataAdmin = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => intval($c),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        }

        return $this->render('/simpel-rekap/pimpinan1/keg', [
                    'dataAdmin' => $dataAdmin,
        ]);
    }
    public function actionPimpinanmonikeg() {

        
        if (!empty($_GET['unit_id'])) {
             $sql ="SELECT distinct(a.nip), a.*, b.tujuan FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$_GET['unit_id']."' ";
            
             $hitung = "SELECT count(distinct(a.nip)) as jml FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$_GET['unit_id']."' ";
            
             $c = Yii::$app->db->createCommand($hitung)->queryScalar();
             $count = Yii::$app->db->createCommand($sql)->queryScalar();
             $dataAdmin = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => intval($c),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        }

        return $this->render('/simpel-rekap/pimpinan1/monikeg', [
                    'dataAdmin' => $dataAdmin,
        ]);
    }

    //untuk pimpinan2
      public function actionPimd() {
       
        
        if (!empty($_GET['unit_id'])) {
             $sql ="SELECT distinct(a.nip), a.*, b.tujuan, b.nama_keg FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_id='".$_GET['unit_id']."'";
            
             $hitung = "SELECT count(distinct(a.nip)) as jml FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_id='".$_GET['unit_id']."' ";
            
             $c = Yii::$app->db->createCommand($hitung)->queryScalar();
             $count = Yii::$app->db->createCommand($sql)->queryScalar();
             $dataAdmin = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => intval($c),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        }
        return $this->render('/simpel-rekap/pimpinan2/index', [
                      'dataAdmin' => $dataAdmin,
        ]);
    }

        public function actionPimdkeg() {
       if (!empty($_GET['unit_id'])) {
             $sql ="SELECT distinct(a.nip), a.*, b.tujuan FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_id='".$_GET['unit_id']."' ";
            
             $hitung = "SELECT count(distinct(a.nip)) as jml FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_id='".$_GET['unit_id']."' ";
            
             $c = Yii::$app->db->createCommand($hitung)->queryScalar();
             $count = Yii::$app->db->createCommand($sql)->queryScalar();
             $dataAdmin = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => intval($c),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        }
        return $this->render('/simpel-rekap/pimpinan2/keg', [
                      'dataAdmin' => $dataAdmin,
        ]);
    }

    public function actionPimdmonikeg() {

         if (!empty($_GET['unit_id'])) {
             $sql ="SELECT distinct(a.nip), a.*, b.tujuan FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_id='".$_GET['unit_id']."' ";
            
             $hitung = "SELECT count(distinct(a.nip)) as jml FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_id='".$_GET['unit_id']."' ";
            
             $c = Yii::$app->db->createCommand($hitung)->queryScalar();
             $count = Yii::$app->db->createCommand($sql)->queryScalar();
             $dataAdmin = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => intval($c),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        }

        return $this->render('/simpel-rekap/pimpinan2/monikeg', [
                    'dataAdmin' => $dataAdmin,
        ]);
    }



    //untuk user
    public function actionUser() {

      if (!empty($_GET['unit'])) {
             $sql ="SELECT distinct(a.nip), a.*, b.tujuan, b.nama_keg FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_id='".$_GET['unit']."'";
            
             $hitung = "SELECT count(distinct(a.nip)) as jml FROM simpel_personil as a
             JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan 
             JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id
             WHERE b.status in(2,3,4) and a.tgl_berangkat between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_id='".$_GET['unit']."' ";
            
             $c = Yii::$app->db->createCommand($hitung)->queryScalar();
             $count = Yii::$app->db->createCommand($sql)->queryScalar();
             $dataAdmin = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => intval($c),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        }
        return $this->render('/simpel-rekap/user/index', [
                    'dataAdmin' => $dataAdmin,
                    
        ]);
    }

    public function actionUserkeg() {
        if (!empty($_GET['unit_id'])) {
           //$find_query = "SELECT a.* FROM simpel_personil as a INNER JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan INNER JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id WHERE b.status in(2,3,4) and b.tgl_mulai between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_id='".$_GET['unit_id']."' ";
            
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
        return $this->render('/simpel-rekap/user/userkeg', [
                    'pages' => $pages,
                    'models' => $models,
        ]);
    }
    public function actionUsermonikeg() {

        // get your HTML raw content without any layouts or scripts
        if (!empty($_GET['unit_id'])) {
            $find_query = "SELECT c.* FROM simpel_keg as a
                            INNER JOIN pegawai.daf_unit b ON  a.unit_id = b.unit_id
                            INNER JOIN simpel_personil c ON  a.id_kegiatan = c.id_kegiatan
                          WHERE (unit_id='" . $_GET['unit_id'] . "') and tgl_berangkat='" . $_GET['tgl_mulai'] . "' or tgl_kembali='" . $_GET['tgl_kembali'] . "' and c.status=4 ";
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
        return $this->render('/simpel-rekap/user/usermonikeg', [
                    'pages' => $pages,
                    'models' => $models,
        ]);
    }
  
   
}
