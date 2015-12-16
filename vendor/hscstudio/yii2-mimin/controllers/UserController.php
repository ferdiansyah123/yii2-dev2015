<?php

namespace hscstudio\mimin\controllers;

use Yii;
use hscstudio\mimin\models\User;
use hscstudio\mimin\models\AuthAssignment;
use hscstudio\mimin\models\AuthItem;
use hscstudio\mimin\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
 
        return $this->render('view', [
                    'model' => $model,
                    
        ]);
    }

       public function actionVprofile($id) {
        $model = $this->findModel($id);
 
        return $this->render('v_profile', [
                    'model' => $model,
                    
        ]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $authAssignments = AuthAssignment::find()->where([
                    'user_id' => $model->id,
                ])->column();

        $authItems = ArrayHelper::map(
                        AuthItem::find()->where([
                            'type' => 1,
                        ])->asArray()->all(), 'name', 'name');

        $authAssignment = new AuthAssignment([
            'user_id' => $model->id,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          $post = $_POST['User']['password'];
          if (!empty($post)){
             $model->setPassword($post);
          }
                 
        
          if ($model->save()) {
            $authAssignment->load(Yii::$app->request->post());
            //perubahan karena tidak bisa update role
            $auth = Yii::$app->get('authManager');
            $auth->getRolesByUser($model->id);
            $auth->revokeAll($model->id);
            $authorRole = $auth->createRole($_POST['AuthAssignment']['item_name']);
            $auth->assign($authorRole, $model->id);
             if ($model->save()) {
                Yii::$app->session->setFlash('success', 'User berhasil diupdate');
            } else {
                Yii::$app->session->setFlash('error', 'User gagal diupdate');
            }
        }
        }

        $authAssignment->item_name = $authAssignments;
        return $this->render('update', [
                    'model' => $model,
                    'authAssignment' => $authAssignment,
                    'authItems' => $authItems,
        ]);
    }

       public function actionProfile($id) {
        $model = $this->findModel($id);
        $authAssignments = AuthAssignment::find()->where([
                    'user_id' => $model->id,
                ])->column();

        $authItems = ArrayHelper::map(
                        AuthItem::find()->where([
                            'type' => 1,
                        ])->asArray()->all(), 'name', 'name');

        $authAssignment = new AuthAssignment([
            'user_id' => $model->id,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          $post = $_POST['User']['password'];
          if (!empty($post)){
             $model->setPassword($post);
          }
                 
        
          if ($model->save()) {


             if ($model->save()) {
                Yii::$app->session->setFlash('success', 'User berhasil diupdate');
            } else {
                Yii::$app->session->setFlash('error', 'User gagal diupdate');
            }
            return $this->redirect(['profile', 'id' => $model->getId()]);
        }
        }

        return $this->render('profile', [
                    'model' => $model,
                   
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new User;
        $authAssignments = AuthAssignment::find()->where([
                    'user_id' => $model->getId(),
                ])->column();

        $authItems = ArrayHelper::map(
                        AuthItem::find()->where([
                            'type' => 1,
                        ])->asArray()->all(), 'name', 'name');

        $authAssignment = new AuthAssignment([
            'user_id' => $model->getId(),
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $str = date('ymdhis').'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'.date('d');
            $potong = str_shuffle($str);
            $random = substr($potong, 3, 16);
            $model->setPassword($random);
            if ($model->save()) {
            $auth = Yii::$app->get('authManager');
            $auth->getRolesByUser($model->getId());
            $auth->revokeAll($model->getId());
            $authorRole = $auth->createRole($_POST['AuthAssignment']['item_name']);
            $auth->assign($authorRole, $model->getId());
                $content = '
                    <center><img src="http://i.imgur.com/p5lHZXS.png"/></center><br/>
                    <h4 align="center">Badan Pengawas Tenaga Nuklir  ' . date('Y') . '</h4>
                    <hr/>
                    <p>Yth ' . $model->username . ',<br/>  
                    Dengan ini kami sampaikan akun telah terdaftar untuk masuk ke Sistem Aplikasi Perjalanan Dinas – BAPETEN, sebagai berikut:<br/> 
                    Username : ' . $model->username . ' <br/>
                    Password :<b>'.$random.'</b><br/>
                    Mohon lakukan penggantian password Anda setelah melakukan login.\n
                    Terima Kasih. <hr/>
                    <h5 align="center">Subbag Perjalanan Dinas Biro Umum BAPETEN  ' . date('Y') . '</h5><br/>';
                Yii::$app->mailer->compose("@common/mail/layouts/html", ["content" => $content])
                        ->setTo($_POST['User']['email'])
                        ->setFrom([$_POST['User']['email'] => $model->username])
                        ->setSubject('Ubah Kata Sandi')
                        ->setTextBody('12345')
                        ->send();

                Yii::$app->session->setFlash('success', 'User berhasil dibuat ');
            } else {
                Yii::$app->session->setFlash('error', 'User gagal dibuat');
            }

            return $this->redirect(['view', 'id' => $model->getId()]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'authAssignment' => $authAssignment,
                    'authItems' => $authItems,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);
    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //       if(!empty($model->new_password)){
    //         if($model->validatePassword($model->new_password)){
    //             $model->setPassword($model->new_password) ;
    //         }
    //       }
    //       if($model->save()){
    //           Yii::$app->session->setFlash('success','User berhasil diupdate');
    //       }
    //       else{
    //           Yii::$app->session->setFlash('error','User gagal diupdate');
    //       }
    //       return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         return $this->render('update', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

  
    
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $authAssignments = AuthAssignment::find()->where([
                    'user_id' => $model->id,
                ])->all();
        foreach ($authAssignments as $authAssignment) {
            $authAssignment->delete();
        }

        Yii::$app->session->setFlash('success', 'Delete success');
        $model->delete();

        return $this->redirect(['index']);
    }

   
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
