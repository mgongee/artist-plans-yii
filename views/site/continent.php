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

$this->title = "Artist plans to be in $continent, $month $year"; 
$this->params['headerLinks'] = $headerLinks;
?>

<div class="artist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
<?= GridView::widget([
	'layout' => '{items} {pager}',
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
				$artistUrl = $artist->getUrl();
				$genresList = $artist->getGenresList();

				if ($artistUrl) {
					$tourLink = '<a href="/artist/' . $artistUrl  . '">Tour</a>';
				}
				else {
					$tourLink = 'Tour';
				}

				$html = '<h3>' . Html::a($artist->website_url, $linkUrl, ['target' => '_blank']) . '</h3>' 
					. 'Artist/Band: <strong>' . $artist->name . '</strong>'
					. '<br>' . $tourLink . ': <strong>' . $artistplan->name . '</strong>'
					. '<br>' . $artistplan->getDates();

				if ($genresList) {
					$html .= '<br>Genres: <i>' . $genresList . '</i>';
				}
				
				if ($cityName) {
					$html .= '<br>Home: <i>' . $cityName . '</i>';
				}

				if ($artistplan->info) {
					$html .= '<br>info: ' . $artistplan->info . '';
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
