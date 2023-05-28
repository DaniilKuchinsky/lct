<?php

namespace backend\forms\standard;

use core\entities\dictionary\Destination;
use core\entities\dictionary\Mkb10;
use core\entities\standard\StandardFederal;
use core\models\CookieModel;
use core\repositories\dictionary\DestinationRepository;
use core\repositories\dictionary\Mkb10Repository;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class StandardFederalSearch extends CookieModel
{
    public ?string $code        = null;

    public ?string $mkb10       = null;

    public ?string $destination = null;

    public ?string $isImportant = null;

    public string  $className   = StandardFederalSearch::class;

    public array   $cookiesList = ['code', 'mkb10', 'destination', 'isImportant'];


    public function rules(): array
    {
        return [
            ['code', 'safe'],
            ['isImportant', 'safe'],
            ['mkb10', 'integer'],
            ['destination', 'integer'],
        ];
    }


    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = StandardFederal::find()
                                ->alias('sm')
                                ->innerJoin(['mk' => Mkb10::tableName()], 'mk."id" = sm."mkb10Id"')
                                ->innerJoin(['ds' => Destination::tableName()], 'ds."id" = sm."destinationId"');

        $dataProvider = new ActiveDataProvider([
                                                   'query' => $query,
                                                   'sort'  => [
                                                       'defaultOrder' => ['mkb10' => SORT_ASC],
                                                       'attributes'   => [
                                                           'code'        => [
                                                               'asc'     => [
                                                                   'sm."code"' => SORT_ASC,
                                                                   'sm.id'     => SORT_ASC,
                                                               ],
                                                               'desc'    => [
                                                                   'sm."code"' => SORT_DESC,
                                                                   'sm.id'     => SORT_DESC,
                                                               ],
                                                               'default' => SORT_DESC,
                                                           ],
                                                           'mkb10'       => [
                                                               'asc'     => [
                                                                   'mk.name' => SORT_ASC,
                                                                   'sm.id'   => SORT_ASC,
                                                               ],
                                                               'desc'    => [
                                                                   'mk.name' => SORT_DESC,
                                                                   'sm.id'   => SORT_DESC,
                                                               ],
                                                               'default' => SORT_DESC,
                                                           ],
                                                           'destination' => [
                                                               'asc'     => [
                                                                   'ds.name' => SORT_ASC,
                                                                   'sm.id'   => SORT_ASC,
                                                               ],
                                                               'desc'    => [
                                                                   'ds.name' => SORT_DESC,
                                                                   'sm.id'   => SORT_DESC,
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

        $query
            ->andFilterWhere(['mk.id' => $this->mkb10])
            ->andFilterWhere(['ds.id' => $this->destination])
            ->andFilterWhere(['ilike', 'sm.code', $this->code])
            ->andFilterWhere(['sm."isImportant"' => $this->isImportant]);

        $dataProvider->pagination->pageSize = 40;
        $this->setDataForCookies();

        return $dataProvider;
    }


    public function resetCookieFilter()
    {
        $this->resetDataFromCookies();
    }


    private static function getMkb10Repository()
    {
        return \Yii::$container->get(Mkb10Repository::class);
    }


    public function mkb10List(): array
    {
        return ArrayHelper::map(self::getMkb10Repository()->listItems(), 'id', 'name');
    }


    private static function getDestinationRepository()
    {
        return \Yii::$container->get(DestinationRepository::class);
    }


    public function destinationList(): array
    {
        return ArrayHelper::map(self::getDestinationRepository()->listItems(), 'id', 'name');
    }


    public function importantList(): array
    {
        return [
            1 => Yii::$app->formatter->asBoolean(true),
            0 => Yii::$app->formatter->asBoolean(false),
        ];
    }
}