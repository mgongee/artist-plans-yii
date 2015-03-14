<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use app\models\City;

/* @var $this yii\web\View */
/* @var $model app\models\Artist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="artist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'city_id')->widget(Select2::classname(), [
			'data' => City::getAllCitiesList(),
			'attribute' => 'city_id',
			'options' => ['placeholder' => 'Select a city...']
		]);
	?>

    <?= $form->field($model, 'website_url')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'picture_url')->textInput(['maxlength' => 255]) ?>

	<?= $form->field($model, 'celebrity_status')->dropDownList(
            $model::$status_list,           // Flat array ('id'=>'label')
            ['prompt' => '---- Select Status ----']    // options
        ); ?>

	<?= $form->field($model, 'show_status')->dropDownList(
            $model::$show_list           // Flat array ('id'=>'label')
        ); ?>

	<?= $form->field($model, 'show_order')->textInput(['maxlength' => 15]) ?>
	
	<?= $form->field($model, 'tour_info')->textarea(['rows' => 6]) ?>
	
	<?= $form->field($model, 'tour_link')->textInput(['maxlength' => 255]) ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
</div>
