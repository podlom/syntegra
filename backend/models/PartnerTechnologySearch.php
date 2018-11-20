<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PartnerTechnology;

/**
 * PartnerTechnologySearch represents the model behind the search form of `backend\models\PartnerTechnology`.
 */
class PartnerTechnologySearch extends PartnerTechnology
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'partner_id', 'technology_id', 'sort', 'published'], 'integer'],
            [['lang'], 'safe'],
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
        $query = PartnerTechnology::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'partner_id' => $this->partner_id,
            'technology_id' => $this->technology_id,
            'sort' => $this->sort,
            'published' => $this->published,
        ]);

        $query->andFilterWhere(['like', 'lang', $this->lang]);

        return $dataProvider;
    }
}
