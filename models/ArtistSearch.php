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
		$query = Artist::find()->andWhere(['show_status' => 1]);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
