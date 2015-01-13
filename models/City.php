<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $name
 * @property string $country_code
 *
 * @property Artist[] $artists
 * @property Country $countryCode
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'country_code'], 'required'],
            [['name'], 'string', 'max' => 150],
            [['country_code'], 'string', 'max' => 2]
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
            'country_code' => 'Country',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtists()
    {
        return $this->hasMany(Artist::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['code' => 'country_code']);
    }

	/**
     * @return array
     */
    public static function getAllCitiesList()
    {
        $query = City::find();
		$cities = $query->orderBy('name')->all();
		$cityList = [];
		foreach ($cities as $city) {
			$cityList[$city->id] = $city->name;
		}
		return $cityList;
    }
	
}
