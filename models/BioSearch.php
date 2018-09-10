<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bio;

/**
 * BioSearch represents the model behind the search form of `app\models\Bio`.
 */
class BioSearch extends Bio
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'taxon', 'parent'], 'integer'],
            [['name', 'tax_name', 'tax_rank', 'about'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Bio::find();

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
            'taxon' => $this->taxon,
            'parent' => $this->parent,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'tax_name', $this->tax_name])
            ->andFilterWhere(['like', 'tax_rank', $this->tax_rank])
            ->andFilterWhere(['like', 'about', $this->about]);

        return $dataProvider;
    }
}
