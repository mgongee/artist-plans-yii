<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "artist_to_genre".
 *
 * @property integer $id
 * @property integer $artist_id
 * @property integer $genre_id
 *
 * @property Artist $artist
 * @property Genre $genre
 */
class ArtistToGenre extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'artist_to_genre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['artist_id', 'genre_id'], 'required'],
            [['artist_id', 'genre_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'artist_id' => 'Artist ID',
            'genre_id' => 'Genre ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtist()
    {
        return $this->hasOne(Artist::className(), ['id' => 'artist_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::className(), ['id' => 'genre_id']);
    }
}
