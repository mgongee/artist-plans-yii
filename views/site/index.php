<?php

use app\helpers\Misc;
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ArtistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $headerLinks array */

$this->title = 'ArtistPlans.com future plans of Artists/Bands gigs in the world'; 
$this->params['headerLinks'] = $headerLinks;
?>

<div class="artist-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    

    <?= GridView::widget([
		'layout' => '{items} {pager}',
		'filterModel' => null,
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'website_url',
				'format' => 'raw',
				'value' => function($artist) {
					$linkUrl = Misc::addScheme($artist->website_url);
					$genresList = $artist->getGenresList();
					$artistHasTours = $artist->getArtistplans()->one();
					$artistUrl = $artist->getUrl();
					
					$html = '<strong>' . Html::a($artist->website_url, $linkUrl, ['target' => '_blank']) . '</strong>'
						. '<br>Artist/Band: <strong>' . $artist->name . '</strong>';
					
					if ($artistHasTours) {
						if ($artistUrl) {
							$html .= '  <a href="/artist/' . $artistUrl  . '">TourContinent</a>';
						}
					}
					else {
						$html .= '. <em>We do not have all info about plannings</em>. ';
					}
					
					if ($artist->getCityName()) {
						$html .= '<br>Home: <i>' . $artist->getCityName() . '</i>';
					}
					
					if ($genresList) {
						$html .= '<br>Genres: <i>' . $genresList . '</i>';
					}
					
					if ($artist->tour_info) {
						$html .= '<br>info: ' . $artist->tour_info. '';
					}
					
					if (!$artistHasTours && $artist->tour_link) {
						$html .= '<br>' . Html::a('Check Booking Availability', $artist->tour_link, ['class' => 'btn btn-success']);
					}
						
					
					return $html;
						
				},
				'label' => 'Website'
			],			
			[
				'attribute' => 'picture_url',
				'format' => 'raw',
				'label' => ''
			]
        ],
    ]); ?>

</div>
