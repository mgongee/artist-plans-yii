<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "artistplan_to_genre".
 *
 * @property integer $id
 * @property integer $artistplan_id
 * @property integer $genre_id
 *
 * @property Artistplan $artistplan
 * @property Genre $genre
 */
class ArtistplanToGenre extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'artistplan_to_genre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['artistplan_id', 'genre_id'], 'required'],
            [['artistplan_id', 'genre_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'artistplan_id' => 'Artistplan ID',
            'genre_id' => 'Genre ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtistplan()
    {
        return $this->hasOne(Artistplan::className(), ['id' => 'artistplan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::className(), ['id' => 'genre_id']);
    }
}
