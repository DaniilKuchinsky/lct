<?php

namespace backend\forms\consultation;

use core\entities\consultation\Consultation;
use core\helpers\consultation\ConsultationHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ConsultationSearch extends Model
{
    public ?string $id       = null;

    public ?string $status   = null;

    public ?string $uniqueId = null;


    public function rules(): array
    {
        return [
            [['id', 'status'], 'integer'],
            [['uniqueId'], 'safe'],
        ];
    }


    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Consultation::find();

        $dataProvider = new ActiveDataProvider([
                                                   'query' => $query,
                                                   'sort'  => [
                                                       'defaultOrder' => ['id' => SORT_DESC],
                                                   ],
                                               ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');

            return $dataProvider;
        }

        $query
            ->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['status' => $this->status])
            ->andFilterWhere(['ilike', 'uniqueId', $this->uniqueId]);

        return $dataProvider;
    }


    public function getStatusList(): array
    {
        return ConsultationHelper::getStatusList();
    }
}