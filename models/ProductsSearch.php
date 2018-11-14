<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Products;

/**
 * productsSearch represents the model behind the search form of `app\models\products`.
 */
class ProductsSearch extends products
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nomi', 'turi', 'ulchami', 'rangi', 'rasmi', 'tavfsiloti', 'narxi'], 'safe'],
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
        $query = products::find();

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

        $query->andFilterWhere(['like', 'nomi', $this->nomi])
            ->andFilterWhere(['like', 'turi', $this->turi])
            ->andFilterWhere(['like', 'ulchami', $this->ulchami])
            ->andFilterWhere(['like', 'rangi', $this->rangi])
            ->andFilterWhere(['like', 'rasmi', $this->rasmi])
            ->andFilterWhere(['like', 'tavfsiloti', $this->tavfsiloti])
            ->andFilterWhere(['like', 'narxi', $this->narxi]);

        return $dataProvider;
    }
}
