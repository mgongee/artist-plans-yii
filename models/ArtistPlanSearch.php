<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ArtistPlan;

/**
 * ArtistPlanSearch represents the model behind the search form about `app\models\ArtistPlan`.
 */
class ArtistPlanSearch extends ArtistPlan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'artist_id', 'city_id', 'show_status'], 'integer'],
            [['name', 'continent', 'start_date', 'end_date'], 'safe'],
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
        $query = ArtistPlan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'artist_id' => $this->artist_id,
            'city_id' => $this->city_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
			'show_status' => $this->show_status
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'continent', $this->continent]);

        return $dataProvider;
    }
	
	
    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function searchActiveContinentYear($continent = false, $year = 2015)
    {
        //$query = ArtistPlan::findByCondition(['show_status' => 1],false);
		$query = ArtistPlan::find()->andWhere(['show_status' => 1]);
		
		if ($continent) {
			$query->andWhere(['continent' => $continent])
				->andWhere(['>=', 'start_date', $year .'-01-01 00:00:00'])
				->andWhere(['<=', 'end_date', $year .'-12-31 00:00:00']);
		}
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
    public function searchActiveContinent($continent = false, $year = 2015, $month = 1)
    {
        //$query = ArtistPlan::findByCondition(['show_status' => 1],false);
		$query = ArtistPlan::find()->andWhere(['show_status' => 1]);
		
		if ($continent) {
			$query = $query->andWhere(['continent' => $continent])
				->andWhere(['>=', 'start_date', $year .'-' . $month . '-01 00:00:00'])
				->andWhere(['<=', 'end_date', $year .'-' . ($month+1) . '-01 00:00:00']);
		}
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
    public function searchActiveWorld($year = 2015, $month = 1)
    {
        //$query = ArtistPlan::findByCondition(['show_status' => 1],false);
		$query = ArtistPlan::find()->andWhere(['show_status' => 1])
			->andWhere(['>=', 'start_date', $year .'-' . $month . '-01 00:00:00'])
			->andWhere(['<=', 'end_date', $year .'-' . ($month+1) . '-01 00:00:00']);
		
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
    public function searchActiveWorldYear($year = 2015)
    {
        //$query = ArtistPlan::findByCondition(['show_status' => 1],false);
		$query = ArtistPlan::find()->andWhere(['show_status' => 1])
			->andWhere(['>=', 'start_date', $year .'-01-01 00:00:00'])
			->andWhere(['<=', 'end_date', $year .'-12-31 00:00:00']);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
