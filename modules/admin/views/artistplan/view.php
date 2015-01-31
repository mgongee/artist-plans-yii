<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ArtistPlan */
/* @var $message string */
/* @var $genres string */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Artist Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artist-plan-view">
	
	<?php if ($message) : ?>
	<div class="alert alert-<?=($error ? 'danger' : 'success') ?>">
		<?=$message;?>
	</div>
	<?php endif; ?>
	
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Copy genres from Artist', ['copygenres', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            [
				'label' => 'Artist',
				'value' => $model->artist->name,
			],
			[
				'label' => 'City',
				'value' => $model->getCityName(),
			],
			[
				'label' => 'Genres',
				'value' => $genres,
			],
            'continent',
			[
				'label' => 'Start date',
				'value' => Yii::$app->formatter->asDate($model->start_date, 'long'),
			],
            [
				'label' => 'End date',
				'value' => Yii::$app->formatter->asDate($model->end_date, 'long'),
			],
			['attribute' => 'show_status', 'value' => $model->getShowName()]
        ],
    ]) ?>

</div>
