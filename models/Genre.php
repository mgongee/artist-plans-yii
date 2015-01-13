<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "genre".
 *
 * @property integer $id
 * @property string $name
 */
class Genre extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'genre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
	
	/**
	 * 
	 * @param array of app\models\Genre $genres
	 */
	public static function makeViewArray($genres) {
		//echo('<pre>' . print_r($genres, 1) . '</pre>');die();
		$genresHtml = '';
		$sep = '';
		foreach($genres as $genre) {
			$genresHtml .= $sep . $genre->name;
			$sep = ', ';
		}
		return $genresHtml;
	}
	
	
	/**
     * @return array of app\models\Genre $genres
     */
    public static function getAllGenresList()
    {
        $query = Genre::find();
		$genres = $query->orderBy('name')->all();
		$genreList = [];
		foreach ($genres as $genre) {
			$genreList[$genre->id] = $genre->name;
		}
		return $genreList;
    }
}
