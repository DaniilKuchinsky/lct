<?php

namespace frontend\forms;

use core\entities\consultation\Consultation;
use core\entities\consultation\ConsultationDiagnosis;
use core\helpers\consultation\ConsultationHelper;
use core\helpers\user\UserHelper;
use core\models\CookieModel;
use yii\data\ActiveDataProvider;

class ConsultationFinishSearch extends CookieModel
{
    public ?string $sex         = null;

    public ?string $patientId   = null;

    public ?string $codeMkb     = null;

    public ?string $diagnosis   = null;

    public ?string $jobName     = null;

    public ?string $dateBirth   = null;

    public ?string $dateService = null;

    public string  $className   = ConsultationFinishSearch::class;

    public array   $cookiesList = ['sex', 'patientId', 'codeMkb', 'diagnosis', 'jobName', 'dateBirth', 'dateService'];


    public function rules(): array
    {
        return [
            [['sex', 'patientId'], 'integer'],
            [['codeMkb', 'diagnosis', 'jobName', 'dateBirth', 'dateService'], 'safe'],
        ];
    }


    /**
     * @param int   $consultationId
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(int $consultationId, array $params): ActiveDataProvider
    {
        $query = ConsultationDiagnosis::find()
                                      ->alias('cd')
                                      ->innerJoin(['cs' => Consultation::tableName()], 'cs."id" = cd."consultationId"');

        $dataProvider = new ActiveDataProvider([
                                                   'query' => $query,
                                                   'sort'  => [
                                                       'defaultOrder' => ['dateService' => SORT_DESC],
                                                       'attributes'   => [
                                                           'dateService' => [
                                                               'asc'     => [
                                                                   'cd."dateService"' => SORT_ASC,
                                                                   'cd.id'            => SORT_ASC,
                                                               ],
                                                               'desc'    => [
                                                                   'cd."dateService"' => SORT_DESC,
                                                                   'cd.id'            => SORT_DESC,
                                                               ],
                                                               'default' => SORT_DESC,
                                                           ],
                                                           'codeMkb'     => [
                                                               'asc'     => [
                                                                   'cd."codeMkb"' => SORT_ASC,
                                                                   'cd.id'        => SORT_ASC,
                                                               ],
                                                               'desc'    => [
                                                                   'cd."codeMkb"' => SORT_DESC,
                                                                   'cd.id'        => SORT_DESC,
                                                               ],
                                                               'default' => SORT_DESC,
                                                           ],
                                                           'diagnosis'   => [
                                                               'asc'     => [
                                                                   'cd."diagnosis"' => SORT_ASC,
                                                                   'cd.id'          => SORT_ASC,
                                                               ],
                                                               'desc'    => [
                                                                   'cd."diagnosis"' => SORT_DESC,
                                                                   'cd.id'          => SORT_DESC,
                                                               ],
                                                               'default' => SORT_DESC,
                                                           ],
                                                           'jobName'     => [
                                                               'asc'     => [
                                                                   'cd."jobName"' => SORT_ASC,
                                                                   'cd.id'        => SORT_ASC,
                                                               ],
                                                               'desc'    => [
                                                                   'cd."jobName"' => SORT_DESC,
                                                                   'cd.id'        => SORT_DESC,
                                                               ],
                                                               'default' => SORT_DESC,
                                                           ],
                                                           'patientId'   => [
                                                               'asc'     => [
                                                                   'cd."patientId"' => SORT_ASC,
                                                                   'cd.id'          => SORT_ASC,
                                                               ],
                                                               'desc'    => [
                                                                   'cd."patientId"' => SORT_DESC,
                                                                   'cd.id'          => SORT_DESC,
                                                               ],
                                                               'default' => SORT_DESC,
                                                           ],
                                                       ],
                                                   ],
                                               ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');

            return $dataProvider;
        }

        if (null !== $this->dateBirth && strpos($this->dateBirth, ' - ') !== false) {
            [$dateStart, $dateFinish] = explode(' - ', $this->dateBirth);

            $query->andWhere([
                                 'BETWEEN',
                                 'cd."dateOfBirth"',
                                 strtotime($dateStart . ' 0:00:00'),
                                 strtotime($dateFinish . ' 23:59:59'),
                             ]);
        }

        if (null !== $this->dateService && strpos($this->dateService, ' - ') !== false) {
            [$dateStart, $dateFinish] = explode(' - ', $this->dateService);

            $query->andWhere([
                                 'BETWEEN',
                                 'cd."dateService"',
                                 strtotime($dateStart . ' 0:00:00'),
                                 strtotime($dateFinish . ' 23:59:59'),
                             ]);
        }

        $query
            ->andWhere(['cd."consultationId"' => $consultationId])
            ->andWhere(['cs."status"' => ConsultationHelper::STATUS_SUCCESS])
            ->andFilterWhere(['cd."sex"' => $this->sex])
            ->andFilterWhere(['cd."patientId"' => $this->patientId])
            ->andFilterWhere(['ilike', 'cd."jobName"', $this->jobName])
            ->andFilterWhere(['ilike', 'cd."diagnosis"', $this->diagnosis])
            ->andFilterWhere(['ilike', 'cd."codeMkb"', $this->codeMkb]);

        $dataProvider->pagination->pageSize = 40;
        $this->setDataForCookies();

        return $dataProvider;
    }


    public function resetCookieFilter()
    {
        $this->resetDataFromCookies();
    }


    public function sexList(): array
    {
        return UserHelper::getSexList();
    }
}