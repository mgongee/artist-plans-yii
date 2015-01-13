<?php
/* @var $model app\models\ArtistplanToGenre */

$genre = $model->getGenre()->one();
?>
<?=$genre->name; ?> <span style="float:right"><input  type="checkbox" id="remove[<?=$genre->id?>]" name="remove[<?=$genre->id?>]"> Remove</span>

