<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Technologies;

/**
 * TechnologiesSearch represents the model behind the search form of `backend\models\Technologies`.
 */
class TechnologiesSearch extends Technologies
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sort', 'published'], 'integer'],
            [['img', 'title', 'slug', 'lang'], 'safe'],
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
        $query = Technologies::find();

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
            'sort' => $this->sort,
            'published' => $this->published,
        ]);

        $query->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'lang', $this->lang]);

        return $dataProvider;
    }
}
