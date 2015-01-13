<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use app\models\Genre;

/* @var $this yii\web\View */
/* @var $model app\models\Artist */
/* @var $artistGenresDataProvider yii\data\ActiveDataProvider */

$this->title = 'Update Genres of: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Artists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update Genres';
?>
<div class="artist-update">

    <h1><?= Html::encode($this->title) ?></h1>		
	
	<?php $form = ActiveForm::begin(); ?>
	
	<label class="control-label">List of current Genres:</label>
	
	<div class="genre-names-list">
	<?php
	echo ListView::widget([
		'layout' => '{items}',
		'dataProvider' => $artistGenresDataProvider,
		'itemView' => '_genre_item',
	]); 
	?>
	</div>
	<label class="control-label">Add new Genre</label>
	<?php echo Select2::widget([
		'name' => 'new_genre_id', 
		'data' => Genre::getAllGenresList(),
		'options' => ['placeholder' => 'Select a genre...']
	]);	?>
	<br>
	<div class="form-group">
        <?= Html::submitButton('Update genres', ['class' => 'btn btn-primary']) ?>
    </div>
	<?php ActiveForm::end(); ?>

</div>
