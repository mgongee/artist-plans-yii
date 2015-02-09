<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "artist".
 *
 * @property integer $id
 * @property string $name
 * @property integer $city_id
 * @property string $website_url
 * @property string $picture_url
 * @property integer $celebrity_status
 * @property integer $show_order 
 * @property integer $show_status
 * @property string $tour_info 
 * 
 * @property City $city
 * @property Artistgenre[] $artistgenres 
 * @property Artistplan[] $artistplans
 */
class Artist extends \yii\db\ActiveRecord
{
	
	static $status_list = [
		'0' => 'Artist',
		'1' => 'Celebrity',
	];
	
	
	static $show_list = [
		'0' => 'Off',
		'1' => 'On',
	];
	
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'artist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['name', 'city_id', 'celebrity_status', 'show_order', 'show_status'], 'required'],
            [['city_id', 'celebrity_status', 'show_order', 'show_status'], 'integer'],
			[['tour_info'], 'string'],
            [['name', 'website_url', 'picture_url'], 'string', 'max' => 255] //	[['show'], 'default', 'value' => 1]
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
            'city_id' => 'City',
            'website_url' => 'Website Url',
            'picture_url' => 'Picture Url',
            'celebrity_status' => 'Celebrity Status',
			'show_order' => 'Order', 
			'show_status' => 'Show', 
			'tour_info' => 'Tour Info',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtistplans()
    {
        return $this->hasMany(Artistplan::className(), ['artist_id' => 'id']);
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenres()
    {
        return $this->hasMany(Genre::className(), ['id' => 'genre_id'])
			->viaTable('artist_to_genre', ['artist_id' => 'id']);
    }
	
	
	
    /**
     * Finds city name
     * @return string
     */
    public function getCityName()
    {
		$city = $this->getCity()->one();
		return is_object($city) ? $city->name : false;
    }
	
	/**
	 * Generates a HTML list of genres
     * @return string
     */
    public function getGenresList()
    {
		$genresList = Genre::makeViewArray($this->getGenres()->all());
        return $genresList;
    }
	
	
    /**
     * Returns title of the current status of this artist
	 * @return string
     */
    public function getStatusName()
    {
        return self::$status_list[$this->celebrity_status];
    }
	
    /**
     * Returns title of the current show mode of this artist
	 * @return string
     */
    public function getShowName()
    {
        return self::$show_list[$this->show_status];
    }
	
	
	/** 
	 * $request = Yii::$app->request->post()
	 */
	public function saveGenresUpdate($request) {
		$modelChanged = false;
		if (isset($request['remove']) ) {
			foreach ($request['remove'] as $genreIdToRemove => $value) {
				ArtistToGenre::deleteAll(
					'artist_id = :artist_id AND genre_id = :genre_id', 
					[':artist_id' => $this->id, ':genre_id' => $genreIdToRemove]
				);
			}
			$modelChanged = true;
		}
		if (isset($request['new_genre_id']) && intval($request['new_genre_id']) > 0 ) {
			$artistgenre = new ArtistToGenre();
			$artistgenre->artist_id = $this->id;
			$artistgenre->genre_id = intval($request['new_genre_id']);
			$artistgenre->save();
			$modelChanged = true;
		}
		return $modelChanged;
	}
	
	
	/**
     * @return array of app\models\Artist $artists
     */
    public static function getAllArtistsList()
    {
        $query = Artist::find();
		$artists = $query->orderBy('name')->all();
		$artistList = [];
		foreach ($artists as $artist) {
			$artistList[$artist->id] = $artist->name;
		}
		return $artistList;
    }
}
