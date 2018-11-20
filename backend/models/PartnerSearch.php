<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Partner;

/**
 * PartnerSearch represents the model behind the search form about `common\models\Partner`.
 */
class PartnerSearch extends Partner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'published', 'sort','category_id'], 'integer'],
            [['slug', 'title', 'lang', 'created_at', 'updated_at', 'logo_url', 'sort', 'description','short_description', 'category_id', 'block1', 'title1','block2', 'title2','block3', 'title3',], 'safe'],
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
        $query = Partner::find();

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
            'published' => $this->published,
            'category_id' => $this->category_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'title', $this->logo_url])
            ->andFilterWhere(['like', 'lang', $this->lang]);

        return $dataProvider;
    }
}
