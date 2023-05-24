<?php

namespace backend\forms\logEvent;

use core\entities\log\LogEvent;
use core\helpers\log\LogEventHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class LogEventSearch extends Model
{
    public ?string $id = null;

    public ?string $status = null;

    public ?string $requestInfo = null;

    public ?string $resultInfo = null;


    public function rules(): array
    {
        return [
            [['id', 'status'], 'integer'],
            [['requestInfo', 'resultInfo'], 'safe'],
        ];
    }


    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = LogEvent::find();

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
            ->andFilterWhere(['ilike', 'requestInfo', $this->requestInfo])
            ->andFilterWhere(['ilike', 'resultInfo', $this->resultInfo]);

        return $dataProvider;
    }



    public function getStatusList(): array
    {
        return LogEventHelper::getStatusList();
    }
}