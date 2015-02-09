<?php

use yii\helpers\Html;
use app\helpers\Misc;
use yii\grid\GridView;
use yii\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArtistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $headerLinks array */
/* @var $continent string */
/* @var $month string */
/* @var $year string */

$this->title = "Artist plans at $continent, $month $year"; 
$this->params['headerLinks'] = $headerLinks;
?>

<div class="artist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
<?= GridView::widget([
	'layout' => '{items}',
	'filterModel' => null,
	'dataProvider' => $dataProvider,
	'columns' => [
		// Tour name, Artist name, Start - End, Genres, City
		[
			'format' => 'raw',
			'value' => function($artistplan) {
				$artist = $artistplan->getArtist()->one();
				$linkUrl = Misc::addScheme($artist->website_url);
				$cityName = $artist->getCityName();
				$genresList = $artist->getGenresList();

				$html = '<h3>' . $artistplan->name . '</h3>' 
					. 'Artist: <strong>' . $artist->name . '</strong>'
					. '<br>' . $artistplan->getDates()
					. '<br>' . Html::a($artist->website_url, $linkUrl, ['target' => '_blank']);

				if ($genresList) {
					$html .= '<br>Genres: <i>' . $genresList . '</i>';
				}
				
				if ($cityName) {
					$html .= '<br>City: <i>' . $cityName . '</i>';
				}

				if ($artist->tour_info) {
					$html .= '<br>Tour info: <br>' . $artist->tour_info. '';
				}
				return $html;

			},
			'label' => 'Tour'
		],
		[  // Picture
			'attribute' => 'artist.picture_url',
			'format' => 'raw',
			'label' => ''
		]
	],
]); ?>


</div>
