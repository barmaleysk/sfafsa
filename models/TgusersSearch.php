<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tgusers;

/**
 * tgusersSearch represents the model behind the search form of `app\models\tgusers`.
 */
class TgusersSearch extends tgusers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tgid'], 'integer'],
            [['username', 'lastname', 'firstname', 'tili', 'step', 'asos'], 'safe'],
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
        $query = tgusers::find();

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
            'tgid' => $this->tgid,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'tili', $this->tili])
            ->andFilterWhere(['like', 'step', $this->step])
            ->andFilterWhere(['like', 'asos', $this->asos]);

        return $dataProvider;
    }
}
