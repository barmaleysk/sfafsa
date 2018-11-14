<?php

namespace app\controllers;

use Yii;
use app\models\Products;
use app\models\Products2;
use app\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * ProductsController implements the CRUD actions for products model.
 */
class ProductsController extends Controller
{
    /**
     * @inheritdoc
     */
     public function behaviors() 
    {
        return [
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
        ];
    }


    /**
     * Lists all products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single products model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new products();       


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

             $model->rasmi = UploadedFile::getInstance($model, 'rasmi');

            if ($model->rasmi && $model->validate()) {                
                $model->rasmi->saveAs('uploads/' . $model->rasmi->baseName . '.' . $model->rasmi->extension);
                $model->rasmi = 'http://pizzacity.uz/uploads/' . $model->rasmi->baseName . '.' . $model->rasmi->extension;
                $model->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
        public function actionXat()
    {
        $model = new products2();       


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

             $model->rasmi = UploadedFile::getInstance($model, 'rasmi');

            if ($model->rasmi && $model->validate()) {                
                $model->rasmi->saveAs('uploads/' . $model->rasmi->baseName . '.' . $model->rasmi->extension);
                $model->rasmi = 'http://pizza.return.uz/uploads/' . $model->rasmi->baseName . '.' . $model->rasmi->extension;
                $model->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    /**
     * Updates an existing products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
