<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use app\models\City;
use app\models\Artist;

/* @var $this yii\web\View */
/* @var $model app\models\ArtistPlan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="artist-plan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

   	<?= $form->field($model, 'artist_id')->widget(Select2::classname(), [
			'data' => Artist::getAllArtistsList(),
			'attribute' => 'artist_id',
			'options' => ['placeholder' => 'Select an artist...']
		]);
	?>

	<?= $form->field($model, 'city_id')->widget(Select2::classname(), [
			'data' => array_merge(["" => ""], City::getAllCitiesList()),
			'attribute' => 'city_id',
			'options' => ['placeholder' => 'Select a city...']
		]);
	?>


    <?= $form->field($model, 'continent')->dropDownList([ 'Asia' => 'Asia', 'Europe' => 'Europe', 'North America' => 'North America', 'Africa' => 'Africa', 'Oceania' => 'Oceania', 'Antarctica' => 'Antarctica', 'South America' => 'South America', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
			'options' => ['placeholder' => 'Enter start date ...'],
			'pluginOptions' => [
				'autoclose' => true,
				'format' => 'yyyy-mm-dd'
			]
		]); 
	?>

    <?= $form->field($model, 'end_date')->widget(DatePicker::classname(), [
			'options' => ['placeholder' => 'Enter end date ...'],
			'pluginOptions' => [
				'autoclose' => true,
				'format' => 'yyyy-mm-dd'
			]
		]); 
	?>

	<?= $form->field($model, 'show_status')->dropDownList(
		$model::$show_list           // Flat array ('id'=>'label')
	); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
