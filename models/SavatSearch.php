<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Savat;

/**
 * savatSearch represents the model behind the search form of `app\models\savat`.
 */
class SavatSearch extends savat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nomi', 'narxi', 'dona', 'tgid', 'turi', 'telefon', 'manzil', 'ism'], 'safe'],
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
        $query = savat::find()->orderBy(['id' => SORT_DESC]);



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
            ->andFilterWhere(['like', 'narxi', $this->narxi])
            ->andFilterWhere(['like', 'dona', $this->dona])
            ->andFilterWhere(['like', 'tgid', $this->tgid])
            ->andFilterWhere(['like', 'turi', $this->turi])
            ->andFilterWhere(['like', 'telefon', $this->telefon])
            ->andFilterWhere(['like', 'manzil', $this->manzil])
            ->andFilterWhere(['like', 'ism', $this->ism]);

        return $dataProvider;
    }
}
