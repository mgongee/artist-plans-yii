<?php

use yii\helpers\Html;
use app\helpers\Misc;
use yii\grid\GridView;
use yii\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArtistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $headerLinks array */

$this->title = "World Artist plans to be in $year"; 
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
				$genresList = $artist->getGenresList();

			
				$html = '<h3>' . Html::a($artist->website_url, $linkUrl, ['target' => '_blank']) . '</h3>' 
					. 'Artist/Band: <strong>' . $artist->name . '</strong>'
					. '<br>Tour: <strong>' . $artistplan->name . '</strong>'
                              . '<br>' . $artistplan->getDates();

				if ($genresList) {
					$html .= '<br>Genres: <i>' . $genresList . '</i>';
				}
				
				if ($cityName) {
					$html .= '<br>Home: <i>' . $cityName . '</i>';
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
