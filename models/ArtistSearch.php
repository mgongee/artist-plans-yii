<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Artist;

/**
 * ArtistSearch represents the model behind the search form about `app\models\Artist`.
 */
class ArtistSearch extends Artist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'city_id', 'celebrity_status', 'order', 'show'], 'integer'],
            [['name', 'website_url', 'picture_url'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Artist::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'city_id' => $this->city_id,
            'celebrity_status' => $this->celebrity_status,
            'show_order' => $this->show_order,
			'show_status' => $this->show_status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'website_url', $this->website_url])
            ->andFilterWhere(['like', 'picture_url', $this->picture_url]);

        return $dataProvider;
    }
	
	
    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function searchActive()
    {
		$query = Artist::find()->andWhere(['show_status' => 1])->orderBy('show_order');
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
	
	
    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function searchActiveContinent($continent)
    {
		$connection = \Yii::$app->db; 
		$sql = 'SELECT artist.id AS id FROM `artist` AS artist
inner join `city` AS city ON artist.city_id = city.id
inner join `country` AS cy ON city.country_code = cy.code
inner join `continent` AS ct ON cy.continent_code = ct.code
WHERE ct.name = :continent';
		$command = $connection->createCommand($sql); 
		$command->bindValue(':continent', $continent); 
		$ids = $command->queryColumn();

		$query = Artist::find()
			->andWhere([
				'show_status' => 1,
				'id' => $ids
			])
			->orderBy('show_order');
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
