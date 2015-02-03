<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Artist */
/* @var $genres string */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Artists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artist-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Edit genres', ['editgenres', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'city.name',
            'website_url:url',
            'picture_url:url',
			['attribute' => 'celebrity_status', 'value' => $model->getStatusName()],
			[
				'label' => 'Genres',
				'value' => $genres,
			],
			'show_order',
			['attribute' => 'show_status', 'value' => $model->getShowName()],
			'tour_info:ntext',
        ],
    ]) ?>

</div>
