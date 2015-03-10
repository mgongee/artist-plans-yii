<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ArtistPlan */
/* @var $genres string */

$this->title = 'Update Artist Plan: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Artist Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="artist-plan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

	<br>
	<hr>
	<br>
	<h2>Genres: <?php echo $genres ? $genres : '<i>none</i>'; ?></h2>
	
	<p>
        <?= Html::a('Edit genres', ['editgenres', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
</div>
