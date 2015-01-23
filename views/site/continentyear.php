<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArtistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $headerLinks array */
/* @var $continent string */
/* @var $year string */

$this->title = "Artist plans at $continent, $year"; 
$this->params['headerLinks'] = $headerLinks;
?>

<div class="artist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
<?= GridView::widget([
	'layout' => '{items}',
	'filterModel' => null,
	'dataProvider' => $dataProvider,
	'columns' => [
		'name',
		[
			'class' => DataColumn::className(),
			'attribute' => 'artist.name',
			'format' => 'text',
			'label' => 'Artist',
		], //'artist.name',
		[
			'class' => DataColumn::className(),
			'attribute' => 'city.name',
			'format' => 'text',
			'label' => 'City',
		], //'city.name',
		'continent',
		['attribute' => 'start_date', 'value' => function ($data) {
			return $data->getDates(); 
		}]//'start_date', 'end_date'
	],
]); ?>


</div>
