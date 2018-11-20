<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Vacancies;

/**
 * VacanciesSearch represents the model behind the search form of `backend\models\Vacancies`.
 */
class VacanciesSearch extends Vacancies
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sort', 'published'], 'integer'],
            [['position', 'descripton', 'city', 'lang', 'created_at', 'updated_at'], 'safe'],
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
        $query = Vacancies::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'descripton', $this->descripton])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'lang', $this->lang]);

        return $dataProvider;
    }
}
