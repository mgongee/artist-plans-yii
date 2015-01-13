<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArtistPlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Artist Plans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artist-plan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Artist Plan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'artist_id',
            'city_id',
            'continent',
            // 'start_date',
            // 'end_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
