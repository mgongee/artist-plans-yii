<?php

use yii\helpers\Html;
use app\helpers\Misc;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArtistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $headerLinks array */
/* @var $continent string */

$this->title = "Artists of $continent"; 
$this->params['headerLinks'] = $headerLinks;
?>

<div class="artist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
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
					$artistUrl = $artist->getUrl();
					
					$html = '<strong>' . Html::a($artist->website_url, $linkUrl, ['target' => '_blank']) . '</strong>'
						. '<br>Artist/Band: <strong>' . $artist->name . '</strong>';

					if ($artistUrl) {
						$html .= ' <a href="/artist/' . $artistUrl  . '">Tour</a>';
					}

					if ($genresList) {
						$html .= '<br>Genres: <i>' . $genresList . '</i>';
					}
					
					if ($artist->city_id) {
						$html .= '<br>Home: <i>' . $artist->getCityName() . '</i>';
					}
					
					if ($artist->tour_info) {
						$html .= '<br>info: ' . $artist->tour_info. '';
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
