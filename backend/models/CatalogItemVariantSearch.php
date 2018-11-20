<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CatalogItemVariant;

/**
 * CatalogItemVariantSearch represents the model behind the search form about `common\models\CatalogItemVariant`.
 */
class CatalogItemVariantSearch extends CatalogItemVariant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'default', 'color_id', 'sort', 'published'], 'integer'],
            [['articul', 'img_url', 'created_at', 'updated_at'], 'safe'],
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
        $query = CatalogItemVariant::find();

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
            'product_id' => $this->product_id,
            'default' => $this->default,
            'color_id' => $this->color_id,
            'sort' => $this->sort,
            'published' => $this->published,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'articul', $this->articul])
            ->andFilterWhere(['like', 'img_url', $this->img_url]);

        return $dataProvider;
    }
}
