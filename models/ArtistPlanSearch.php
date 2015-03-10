<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ArtistPlan;

/**
 * ArtistPlanSearch represents the model behind the search form about `app\models\ArtistPlan`.
 */
class ArtistPlanSearch extends ArtistPlan
{
	
	static public $startOfTime = '0000-00-00 00:00:00';
	static public $endOfTime = '2030-01-10 00:00:00';

	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'artist_id', 'city_id', 'show_status'], 'integer'],
            [['name', 'continent', 'start_date', 'end_date', 'info'], 'safe'],
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
            ->andFilterWhere(['like', 'continent', $this->continent])
			->andFilterWhere(['like', 'info', $this->info]);

        return $dataProvider;
    }
	
	public function getContinentName($continent) {
		$continent = strtolower($continent);
		$continents = [
			'asia' => 'Asia',
			'europe' => 'Europe',
			'northamerica' => 'North America',
			'africa' => 'Africa', 
			'oceania' => 'Oceania', 
			'australia' => 'Australia', 
			'antarctica' => 'Antarctica', 
			'southamerica' => 'South America'
		];
		if (array_key_exists($continent, $continents)) return $continents[$continent];
		return $continent;
	}


	/**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function searchActiveContinentYear($continent = false, $year = 2015)
    {		
		$intervalStart = $year .'-01-01 00:00:00';
		$intervalEnd = $year .'-12-31 00:00:00';


		// artist plans sorted by artist order	
		$query = ArtistPlan::find()->innerJoin('artist', 'artistplan.artist_id = artist.id')
			->where('artistplan.show_status = :status') 
			->andWhere(['between', 'start_date', self::$startOfTime, $intervalEnd])
			->andWhere(['between', 'end_date', $intervalStart, self::$endOfTime]);
		
		$query->addParams([':status' => 1]); 
		
		if ($continent) {
			$query->andWhere("continent = :continent");
			$query->addParams([':continent' => $this->getContinentName($continent)]); 
		}
		
		$query->orderBy(["artist.show_order" => SORT_ASC]);
		
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 40
			]
        ]);

        return $dataProvider;
    }
	
	
    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function searchActiveContinentMonth($continent = false, $year = 2015, $month = 1)
    {

		$intervalStart = $year .'-' . sprintf("%02d", $month) . '-01 00:00:00';
		$intervalEnd = $year .'-' . sprintf("%02d", $month) . '-31 23:59:59';
		
		$query = ArtistPlan::find()->innerJoin('artist', 'artistplan.artist_id = artist.id')
			->where('artistplan.show_status = :status') 
			->andWhere(['between', 'start_date', self::$startOfTime, $intervalEnd])
			->andWhere(['between', 'end_date', $intervalStart, self::$endOfTime]);
		
		$query->addParams([':status' => 1]); 
		
		if ($continent) {
			$query->andWhere("continent = :continent");
			$query->addParams([':continent' => $this->getContinentName($continent)]); 
		}
		
		$query->orderBy(["artist.show_order" => SORT_ASC]);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 40
			]
        ]);

        return $dataProvider;
    }
	
	
    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function searchActiveCelebritiesWorldMonth($year = 2015, $month = 1)
    {	
		
		$intervalStart = $year .'-' . sprintf("%02d", $month) . '-01 00:00:00';
		$intervalEnd = $year .'-' . sprintf("%02d", $month) . '-31 23:59:59';
		
		$query = ArtistPlan::find()
			->innerJoin('artist', 'artistplan.artist_id = artist.id')
			->andWhere(['artistplan.show_status' => 1])
			->andWhere(['artist.show_status' => 1])
			->andWhere(['artist.celebrity_status' => 1])
			->andWhere(['between', 'start_date', self::$startOfTime, $intervalEnd])
			->andWhere(['between', 'end_date', $intervalStart, self::$endOfTime])
			->orderBy(["artist.show_order" => SORT_ASC]);
		
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 40
			]
        ]);

        return $dataProvider;
    }
	
	
    /**
     * Creates data provider instance with search query applied
     *
	 * @param $artistId integer
     * @return ActiveDataProvider
     */
    public function searchByArtist($artistId)
    {
		$query = ArtistPlan::find()
			->innerJoin('artist', 'artistplan.artist_id = artist.id')
			->andWhere(['artist_id' => $artistId])
			->orderBy(["artist.show_order" => SORT_ASC]);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 40
			]
        ]);

        return $dataProvider;
    }
	
    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function searchActiveCelebritiesWorldYear($year = 2015)
    {
        $intervalStart = $year .'-01-01 00:00:00';
		$intervalEnd = $year .'-12-31 00:00:00';
		
		$query = ArtistPlan::find()
			->innerJoin('artist', 'artistplan.artist_id = artist.id')
			->andWhere(['artistplan.show_status' => 1])
			->andWhere(['artist.show_status' => 1])
			->andWhere(['artist.celebrity_status' => 1])
			->andWhere(['between', 'start_date', self::$startOfTime, $intervalEnd])
			->andWhere(['between', 'end_date', $intervalStart, self::$endOfTime])
			->orderBy(["artist.show_order" => SORT_ASC]);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 40
			]
        ]);

        return $dataProvider;
    }
}
