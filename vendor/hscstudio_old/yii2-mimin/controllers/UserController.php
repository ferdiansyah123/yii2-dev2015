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
class UserController extends Controller
{
    public function behaviors()
    {
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
    public function actionIndex()
    {
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
    
       public function actionView($id)
    {
        $model =  $this->findModel($id);
        $authAssignments = AuthAssignment::find()->where([
          'user_id' => $model->user_id,
        ])->column();

        $authItems = ArrayHelper::map(
          AuthItem::find()->where([
            'type' => 1,
          ])->asArray()->all(),
          'name', 'name');

        $authAssignment = new AuthAssignment([
          'user_id' => $model->user_id,
        ]);

        if (Yii::$app->request->post()) {
            $authAssignment->load(Yii::$app->request->post());
            //perubahan karena tidak bisa update role
            $auth = Yii::$app->get('authManager');
                $auth->getRolesByUser($model->user_id);
                $auth->revokeAll($model->user_id);
                $authorRole = $auth->createRole($_POST['AuthAssignment']['item_name']);
                $auth->assign($authorRole, $model->user_id);
            Yii::$app->session->setFlash('success','Data tersimpan');
           return $this->refresh();
        }

        $authAssignment->item_name = $authAssignments;
        return $this->render('view', [
            'model' => $model,
            'authAssignment' => $authAssignment,
            'authItems' => $authItems,
        ]);
    }
    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
          $model->setPassword('123456');
          $model->unit_id = $_POST['User']['unit_id'];
          if($model->save()){
              Yii::$app->session->setFlash('success','User berhasil dibuat dengan password 123456');
          }
          else{
              Yii::$app->session->setFlash('error','User gagal dibuat');
          }

          return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          if(!empty($model->new_password)){
            if($model->validatePassword($model->new_password)){
                $model->setPassword($model->new_password) ;
            }
          }
          if($model->save()){
              Yii::$app->session->setFlash('success','User berhasil diupdate');
          }
          else{
              Yii::$app->session->setFlash('error','User gagal diupdate');
          }
          return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $authAssignments =AuthAssignment::find()->where([
            'user_id' => $model->user_id,
          ])->all();
        foreach($authAssignments as $authAssignment){
            $authAssignment->delete();
        }

        Yii::$app->session->setFlash('success','Delete success');
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
