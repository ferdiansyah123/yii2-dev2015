<?php

namespace backend\controllers;
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
class SimpelLaporanController extends \yii\web\Controller {

    public $layout = 'admin';

    public function actionIndex() {
        return $this->render('index');
    }
    public function actionMak() {
        return $this->render('max');
    }
    // Awal Pimpinan1
    public function actionPimpinan() {
        return $this->render('pimpinan1_real');
    }
    public function actionPimmak() {
        return $this->render('pimpinan1_real_mak');
    }
    //Akhir Pimpinan1

    // Awal Pimpinan12
    public function actionPimd() {
        return $this->render('pimpinan2_real');
    }
    public function actionPimdmak() {
        return $this->render('pimpinan2_real_mak');
    }
    //Akhir Pimpinan2

    // Awal User
    public function actionUser() {
        return $this->render('user');
    }
    public function actionUsermak() {
        return $this->render('user_mak');
    }
    //Akhir User
    //laporan kepala dan admin 

    public function actionExportAdmin($unit,$unit_id,$tahun)
        {    
            $find_query = "SELECT a.* FROM simpel_personil as a 
            LEFT JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan
             LEFT JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id 
             WHERE b.status=4 and b.tgl_mulai between '".$_GET['tgl_mulai']."' and '".$_GET['tgl_kembali']."' and c.unit_parent_id='".$unit_id."' ";
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' =>10]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
            $html = $this->renderAjax('/cetak/laporan/laporan_admin',['models'=>$models,'pages'=>$pages]);
            $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->AddPage('L', '', '', '', '', 15, 15, 5, 1, 5, 5);
            $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
            $mpdf->WriteHTML($html);
            $mpdf->Output('cetak.pdf', I);
            exit;
    }

   
    //laporan pimpinan2
     public function actionExportDua($unit,$unit_id,$tahun)
        {    
            $find_query = "SELECT a.* FROM simpel_personil as a LEFT JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan LEFT JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id WHERE b.status=4 and c.unit_parent_id='".$unit_id."' ";
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' => $countQuery]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
         $html = $this->renderAjax('/cetak/laporan/laporan_pimpin2',['models'=>$models,'pages'=>$pages]);
        $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->AddPage('L', '', '', '', '', 15, 15, 5, 1, 5, 5);
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        $mpdf->WriteHTML($html);
        $mpdf->Output('cetak.pdf', I);
        exit;
    }
    //Laporan user
     public function actionExportUser($unit,$tahun)
        {    
            $find_query = "SELECT a.* FROM simpel_personil as a LEFT JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan LEFT JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id WHERE b.status=4 and c.unit_id='".$unit."' ";
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' => $countQuery]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
         $html = $this->renderAjax('/cetak/laporan/user',['models'=>$models,'pages'=>$pages]);
        $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->AddPage('L', '', '', '', '', 15, 15, 5, 1, 5, 5);
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        $mpdf->WriteHTML($html);
        $mpdf->Output('cetak.pdf', D);
        exit;
    }

        //laporan kepala dan admin

    public function actionDuamak($unit,$unit_id,$tahun)
        {    
            $find_query = "SELECT a.* FROM simpel_personil as a LEFT JOIN simpel_keg b ON a.id_kegiatan = b.id_kegiatan LEFT JOIN pegawai.daf_unit c ON b.unit_id = c.unit_id WHERE b.status=4 and c.unit_parent_id='".$unit_id."' ";
            $query = SimpelPersonil::findBySql($find_query);
            $countQuery = count($query->all());
            $pages = new Pagination(['totalCount' => $countQuery]);
            $models = $query->offset($pages->offset, $pages->pageSize = 10)
                    ->limit($pages->limit)
                    ->all();
         $html = $this->renderAjax('/cetak/laporan/laporan_pimpinan_mak',['models'=>$models,'pages'=>$pages]);
        $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->AddPage('L', '', '', '', '', 15, 15, 5, 1, 5, 5);
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        $mpdf->WriteHTML($html);
        $mpdf->Output('cetak.pdf', D);
        exit;
    }



    //laporan mak admin
    public function actionAdminKeg($unit,$unit_id,$tahun) {
        $html = $this->renderAjax('/cetak/laporan/laporan_admin_mak',['models'=>$models,'pages'=>$pages]);
        $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->AddPage('L', '', '', '', '', 15, 15, 5, 1, 5, 5);
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        $mpdf->WriteHTML($html);
        $mpdf->Output('cetak.pdf', I);
        exit;

    }


    //laporan mak pimpinan2
  public function actionPimKeg($unit,$unit_id,$tahun) {
        $html = $this->renderAjax('/cetak/laporan/laporan_pimpin_mak2',['models'=>$models,'pages'=>$pages]);
        $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->AddPage('L', '', '', '', '', 15, 15, 5, 1, 5, 5);
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        $mpdf->WriteHTML($html);
        $mpdf->Output('cetak.pdf', I);
        exit;

    }
    //laporan mak user
  public function actionUserKeg($unit,$unit_id,$tahun) {
        $html = $this->renderAjax('/cetak/laporan/laporan_admin_mak',['models'=>$models,'pages'=>$pages]);
        $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);  
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->AddPage('L', '', '', '', '', 15, 15, 5, 1, 5, 5);
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        $mpdf->WriteHTML($html);
        $mpdf->Output('cetak.pdf', I);
        exit;

    }



}
