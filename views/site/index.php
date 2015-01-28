<?php

use app\helpers\Misc;
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ArtistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $headerLinks array */

$this->title = 'GigsPlans.com future plans of Artists/Bands gigs in the world'; 
$this->params['headerLinks'] = $headerLinks;
?>

<div class="artist-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    

    <?= GridView::widget([
		'layout' => '{items}',
		'filterModel' => null,
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
			[
				'attribute' => 'city.name',
				'format' => 'text',
				'label' => 'Home town'
			],
			[
				'attribute' => 'website_url',
				'format' => 'raw',
				'value' => function($artist) {
					$linkUrl = Misc::addScheme($artist->website_url);
					return Html::a($artist->website_url, $linkUrl, ['target' => '_blank']);
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
