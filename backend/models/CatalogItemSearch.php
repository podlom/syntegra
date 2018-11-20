<?php

namespace backend\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CatalogItem;


/**
 * CatalogItemSearch represents the model behind the search form about `common\models\CatalogItem`.
 */
class CatalogItemSearch extends CatalogItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'published', 'sort'], 'integer'],
            [['title', 'descr', 'created_at', 'updated_at', 'lang', 'sku', 'img_url'], 'safe'],
            [['price', 'width', 'height'], 'number'],
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
        $query = CatalogItem::find();

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
            'category_id' => $this->category_id,
            'published' => $this->published,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sort' => $this->sort,
            'price' => $this->price,
            // 'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'descr', $this->descr])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'img_url', $this->img_url]);

        return $dataProvider;
    }
}
