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
            [['id', 'artist_id', 'city_id'], 'integer'],
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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'continent', $this->continent]);

        return $dataProvider;
    }
}
