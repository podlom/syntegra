<?php

namespace backend\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Seometrics;


/**
 * Sliders search form
 */
class SeometricsSearch extends Seometrics
{
    /**
     * Validation rules
     * @return array
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            ['slug', 'safe'],
        ];
    }

    /**
     * Getting data provider for the search
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Seometrics::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
     
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id])
              ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
