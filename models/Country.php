<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property string $code
 * @property string $name
 * @property string $full_name
 * @property string $continent_code
 *
 * @property City[] $cities
 * @property Continent $continentCode
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'full_name', 'continent_code'], 'required'],
            [['code', 'continent_code'], 'string', 'max' => 2],
            [['name', 'full_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'name' => 'Name',
            'full_name' => 'Full Name',
            'continent_code' => 'Continent',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['country_code' => 'code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContinent()
    {
        return $this->hasOne(Continent::className(), ['code' => 'continent_code']);
    }
	
    /**
     * @return array
     */
    public static function getAllCountriesList()
    {
        $query = Country::find();
		$countries = $query->orderBy('name')->all();
		$countryList = [];
		foreach ($countries as $country) {
			$countryList[$country->code] = $country->name;
		}
		return $countryList;
    }


}
