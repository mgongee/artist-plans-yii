<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ArtistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ArtistPlans.com'; 

?>

<div class="artist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    

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
				'format' => 'url',
				'label' => 'Website'
			],
			['attribute' => 'celebrity_status', 'value' => function ($data) {
                return $data->getStatusName(); 
            }],//$model->getStatusName()],
        ],
    ]); ?>

</div>
