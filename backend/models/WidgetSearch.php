<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Widget;

/**
 * WidgetSearch represents the model behind the search form about `backend\models\Widget`.
 */
class WidgetSearch extends Widget
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'page_group_id', 'place', 'position', 'sql_offset', 'sql_limit', 'status', 'is_active'], 'integer'],
            [['name', 'template', 'item_image_size', 'link_target', 'link_follow', 'item_template', 'style', 'object_class', 'sql_order_by', 'sql_where', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
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
        $query = Widget::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'page_group_id' => $this->page_group_id,
            'place' => $this->place,
            'position' => $this->position,
            'sql_offset' => $this->sql_offset,
            'sql_limit' => $this->sql_limit,
            'status' => $this->status,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'template', $this->template])
            ->andFilterWhere(['like', 'item_image_size', $this->item_image_size])
            ->andFilterWhere(['like', 'link_target', $this->link_target])
            ->andFilterWhere(['like', 'link_follow', $this->link_follow])
            ->andFilterWhere(['like', 'item_template', $this->item_template])
            ->andFilterWhere(['like', 'style', $this->style])
            ->andFilterWhere(['like', 'object_class', $this->object_class])
            ->andFilterWhere(['like', 'sql_order_by', $this->sql_order_by])
            ->andFilterWhere(['like', 'sql_where', $this->sql_where])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}
