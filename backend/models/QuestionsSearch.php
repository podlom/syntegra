<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Questions;

/**
 * QuestionsSearch represents the model behind the search form about `backend\models\GroupQuestions`.
 */
class QuestionsSearch extends Questions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['json_data'], 'safe'],
            [['title', 'lang',], 'safe'],
            [['id_group'], 'integer'],
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
        $query = Questions::find();

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

        ]);

       // $query->andFilterWhere(['like', 'json_data', $this->json_data]);
        $query->andFilterWhere(['like', 'title', $this->json_data])
            ->andFilterWhere(['like', 'lang', $this->lang]);


        return $dataProvider;
    }
}
