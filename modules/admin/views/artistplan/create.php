<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ArtistPlan */

$this->title = 'Create Artist Plan';
$this->params['breadcrumbs'][] = ['label' => 'Artist Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artist-plan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
