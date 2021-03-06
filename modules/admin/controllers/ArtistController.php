<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Artist;
use app\models\ArtistPlan;
use app\models\ArtistSearch;
use app\models\ArtistToGenre;
use app\models\Genre;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * ArtistController implements the CRUD actions for Artist model.
 */
class ArtistController extends AdminDefaultController
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
     * Lists all Artist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArtistSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider = $searchModel->searchByOrder();
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Artist model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
			'genres' => Genre::makeViewArray($model->getGenres()->all())
        ]);
    }

    /**
     * Creates a new Artist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Artist();
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
     * Updates an existing Artist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

		$artistGenresDataProvider = new ActiveDataProvider([
			'query' => ArtistToGenre::find()->where(['artist_id' => $id]),
			'pagination' => [
				'pageSize' => 200,
			],
		]);
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
			'query' => ArtistToGenre::find()->where(['artist_id' => $id]),
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
     * Deletes an existing Artist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		$connection = Yii::$app->db; 
		
		// delete genres of artistplans
		$command = $connection->createCommand(
		'DELETE a.* FROM `artistplan_to_genre` AS a
		JOIN `artistplan` ON a.`artistplan_id` = `artistplan`.`id` 
		JOIN `artist` ON `artistplan`.`artist_id` = `artist`.`id` 
		WHERE `artist`.`id` = ' . intval($id));
		$command->execute(); 
		
		// delete artistplans
		ArtistPlan::deleteAll('artist_id = ' . intval($id));
		
		// delete artist genres
		ArtistToGenre::deleteAll('artist_id = ' . intval($id));
		
		// delete artist
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Artist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Artist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Artist::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
