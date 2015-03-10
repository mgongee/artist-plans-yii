<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\ArtistPlan;
use app\models\ArtistPlanSearch;
use app\models\ArtistplanToGenre;
use app\models\Genre;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * ArtistplanController implements the CRUD actions for ArtistPlan model.
 */
class ArtistplanController extends AdminDefaultController
{
    public function behaviors()
    {
        return array_merge($this->defaultBehaviors(),[
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * Lists all ArtistPlan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArtistPlanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ArtistPlan model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $message = '', $error = false)
    {
		$model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
			'message' => $message,
			'error' => $error,
			'genres' => Genre::makeViewArray($model->getGenres()->all())
        ]);
    }

    /**
     * Creates a new ArtistPlan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArtistPlan();
		$model->show_status = 1;
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Updates an existing Artistplan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

		$artistGenresDataProvider = new ActiveDataProvider([
			'query' => ArtistplanToGenre::find()->where(['artistplan_id' => $id]),
			'pagination' => [
				'pageSize' => 200,
			],
		]);
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
				'view', 
				'id' => $model->id,
				'message' => 'Update successful',
				'error' => false
			]);
        } else {
            return $this->render('update', [
                'model' => $model,
				'genres' => Genre::makeViewArray($model->getGenres()->all()),
				'artistGenresDataProvider' => $artistGenresDataProvider
            ]);
        }
    }


	/**
     * Updates an existing Artist genres list.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEditgenres($id)
    {
        $model = $this->findModel($id);

		$artistGenresDataProvider = new ActiveDataProvider([
			'query' => ArtistplanToGenre::find()->where(['artistplan_id' => $id]),
			'pagination' => [
				'pageSize' => 200,
			],
		]);
		
        if ($model->saveGenresUpdate(Yii::$app->request->post())) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('editgenres', [
                'model' => $model,
				'artistGenresDataProvider' => $artistGenresDataProvider
            ]);
        }
    }


	/**
     * Copies genres list from Artist to Artist Plan
     * If copying is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCopygenres($id)
    {
        $model = $this->findModel($id);
        if ($model->copyGenresFromArtist())
			return $this->redirect([
				'view', 
				'id' => $model->id,
				'message' => 'Genres successfully copied',
				'error' => false
			]);
		else
			return $this->redirect([
				'view', 
				'id' => $model->id,
				'message' => 'Copying failed due to unknown reason',
				'error' => true
			]);
    }
	
	
	/**
     * Copies info from Artist to Artist Plan
     * If copying is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCopyinfo($id)
    {
        $model = $this->findModel($id);
        if ($model->copyInfoFromArtist())
			return $this->redirect([
				'view', 
				'id' => $model->id,
				'message' => 'Info successfully copied',
				'error' => false
			]);
		else
			return $this->redirect([
				'view', 
				'id' => $model->id,
				'message' => 'Copying failed due to unknown reason',
				'error' => true
			]);
    }
	
	
    /**
     * Deletes an existing ArtistPlan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		ArtistplanToGenre::deleteAll('artistplan_id = ' . intval($id));
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ArtistPlan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArtistPlan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArtistPlan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
