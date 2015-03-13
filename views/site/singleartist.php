<?php

use yii\helpers\Html;
use app\helpers\Misc;
use yii\grid\GridView;
use yii\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArtistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $headerLinks array */
/* @var $artist app\models\Artist */
/* @var $artistplansDataProvider array of app\models\ArtistPlan */


$this->title = $artist->name; 
$this->params['headerLinks'] = $headerLinks;
?>

<div class="artist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
	<?=$artist->picture_url ?>
	<?php if ($artist->tour_info): ?>
		<br>Info: <?=$artist->tour_info ?>
	<?php endif; ?>
		
	<br>Home: <?=$artist->getCityName() ?>
	<br>Genres: <i> <?=$artist->getGenresList() ?></i>
<?= GridView::widget([
	'layout' => '{items} {pager}',	
	'filterModel' => null,
	'dataProvider' => $artistplansDataProvider,
	'columns' => [
		// Tour name, Artist name, Start - End, Genres, City
		[
			'format' => 'raw',
			'value' => function($artistplan) {

				$html = '<strong>' . $artistplan->name . '</strong>'
					. '<br>' . $artistplan->getDates();

				$html .= '<br>Continent: ' . $artistplan->continent . '';
				
				return $html;

			},
			'label' => 'Tour'
		]
	],
]); ?>


</div>
