<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "continent".
 *
 * @property string $code
 * @property string $name
 *
 * @property Country[] $countries
 */
class Continent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'continent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 255]
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountries()
    {
        return $this->hasMany(Country::className(), ['continent_code' => 'code']);
    }
	
    /**
     * @return array
     */
    public static function getAllContinentsList()
    {
        $query = Continent::find();
		$continents = $query->orderBy('name')->all();
		$continentList = [];
		foreach ($continents as $continent) {
			$continentList[$continent->code] = $continent->name;
		}
		return $continentList;
    }


}
