<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "artistplan".
 *
 * @property integer $id
 * @property string $name
 * @property integer $artist_id
 * @property integer $city_id
 * @property string $continent
 * @property string $start_date
 * @property string $end_date
 * @property string $show_status
 *
 * @property Artist $artist
 */
class ArtistPlan extends \yii\db\ActiveRecord
{
	
	static $show_list = [
		'0' => 'Off',
		'1' => 'On',
	];
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'artistplan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['name', 'artist_id', 'continent', 'start_date', 'show_status'], 'required'],
			[['artist_id', 'city_id', 'show_status'], 'integer'],
            [['continent'], 'string'],
            [['start_date', 'end_date'], 'safe'],
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
            'artist_id' => 'Artist ID',
            'city_id' => 'City ID',
            'continent' => 'Continent',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
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
    public function getGenres()
    {
        return $this->hasMany(Genre::className(), ['id' => 'genre_id'])
			->viaTable('artistplan_to_genre', ['artistplan_id' => 'id']);
    }
	
	
    /**
     * Returns title of the current show mode of this artistplan
	 * @return string
     */
    public function getShowName()
    {
        return self::$show_list[$this->show_status];
    }
	
	
    /**
     * Returns string describing start and end date of the artist plan
	 * @return string
     */
    public function getDates($format = 'long')
    {
		if ($format == 'short') {
			$dates = date("d-M-Y", strtotime($this->start_date));
			if ($this->end_date != '0000-00-00 00:00:00') {
				$dates .= ' -> ' . date("d-M-Y", strtotime($this->end_date));
			}
		}
		else {
			$dates = 'Starts ' . date("d M Y", strtotime($this->start_date));

			if ($this->end_date != '0000-00-00 00:00:00') {
				$dates .= ', ends ' . date("d M Y", strtotime($this->end_date));
			}
		}
        return $dates;
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
	
    /**
     * @return string
     */
    public function getCityName()
    {
        $city = $this->hasOne(City::className(), ['id' => 'city_id'])->one();
		if ($city) {
			return $city->name;
		}
		return false;
    }
	
	/** 
	 * $request = Yii::$app->request->post()
	 */
	public function saveGenresUpdate($request) {
		$modelChanged = false;
		if (isset($request['remove']) ) {
			foreach ($request['remove'] as $genreIdToRemove => $value) {
				ArtistplanToGenre::deleteAll(
					'artistplan_id = :artistplan_id AND genre_id = :genre_id', 
					[':artistplan_id' => $this->id, ':genre_id' => $genreIdToRemove]
				);
			}
			$modelChanged = true;
		}
		if (isset($request['new_genre_id']) && intval($request['new_genre_id']) > 0 ) {
			$artistgenre = new ArtistplanToGenre();
			$artistgenre->artistplan_id = $this->id;
			$artistgenre->genre_id = intval($request['new_genre_id']);
			$artistgenre->save();
			$modelChanged = true;
		}
		return $modelChanged;
	}
}
