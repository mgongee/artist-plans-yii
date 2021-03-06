<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArtistPlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Artist Plans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artist-plan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Artist Plan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
			[
				'class' => DataColumn::className(),
				'attribute' => 'artist.name',
				'format' => 'text',
				'label' => 'Artist',
			], 
			'continent',
            [
				'class' => DataColumn::className(),
				'attribute' => 'city.name',
				'format' => 'text',
				'label' => 'HomeTown',
			], //'city.name',
            ['label' => 'Dates', 'value' => function ($artistplan) {
                return $artistplan->getDates('short'); 
            }],
			['attribute' => 'show_status', 'value' => function ($artistplan) {
                return $artistplan->getShowName(); 
            }],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
