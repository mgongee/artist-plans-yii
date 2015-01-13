<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Welcome to the ArtistPlans admin panel';
?>

<div class="admin-default-index">
	<h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        Here you can add or modify:
		<ul>
			<li><?= Html::a('Artists', ['/admin/artist']) ?></li>
			<li><?= Html::a('Artist Plans', ['/admin/artistplan']) ?></li>
			<li><?= Html::a('Genres', ['/admin/genre']) ?></li>
			<li><?= Html::a('Cities', ['/admin/city']) ?></li>
			<li><?= Html::a('Countries', ['/admin/country']) ?></li>
			<li><?= Html::a('Continents', ['/admin/continent']) ?></li>
		</ul>
    </p>
</div>
