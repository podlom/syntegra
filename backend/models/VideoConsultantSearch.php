<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\VideoConsultant;

/**
 * VideoConsultantSearch represents the model behind the search form about `common\models\VideoConsultant`.
 */
class VideoConsultantSearch extends VideoConsultant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'published', 'sort'], 'integer'],
            [['lang', 'title', 'img_url', 'video_url', 'short_descr', 'created_at', 'updated_at'], 'safe'],
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
        $query = VideoConsultant::find();

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
            'sort' => $this->sort,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'img_url', $this->img_url])
            ->andFilterWhere(['like', 'video_url', $this->video_url])
            ->andFilterWhere(['like', 'short_descr', $this->short_descr]);

        return $dataProvider;
    }
}
