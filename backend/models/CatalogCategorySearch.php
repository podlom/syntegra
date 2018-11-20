<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CatalogCategory;

/**
 * CatalogCategorySearch represents the model behind the search form about `common\models\CatalogCategory`.
 */
class CatalogCategorySearch extends CatalogCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'published', 'sort'], 'integer'],
            [['name', 'img_url', 'lang', 'created_at', 'updated_at', 'descr'], 'safe'],
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
        $query = CatalogCategory::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'img_url', $this->img_url])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'descr', $this->descr]);

        return $dataProvider;
    }
}
