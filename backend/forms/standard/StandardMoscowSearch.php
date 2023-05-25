<?php

namespace backend\forms\standard;

use core\entities\dictionary\Destination;
use core\entities\dictionary\Mkb10;
use core\entities\standard\StandardMoscow;
use core\models\CookieModel;
use core\repositories\dictionary\DestinationRepository;
use core\repositories\dictionary\Mkb10Repository;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class StandardMoscowSearch extends CookieModel
{
    public ?string $categoryName = null;

    public ?string $name         = null;

    public ?string $mkb10        = null;

    public ?string $type         = null;

    public ?string $destination  = null;

    public ?string $criterion    = null;

    public ?string $isImportant    = null;

    public string  $className    = StandardMoscowSearch::class;

    public array   $cookiesList  = ['categoryName', 'name', 'mkb10', 'type', 'destination', 'criterion', 'isImportant'];


    public function rules(): array
    {
        return [
            ['categoryName', 'safe'],
            ['name', 'safe'],
            ['type', 'safe'],
            ['criterion', 'safe'],
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
        $query = StandardMoscow::find()
                               ->alias('sm')
                               ->innerJoin(['mk' => Mkb10::tableName()], 'mk."id" = sm."mkb10Id"')
                               ->innerJoin(['ds' => Destination::tableName()], 'ds."id" = sm."destinationId"');

        $dataProvider = new ActiveDataProvider([
                                                   'query' => $query,
                                                   'sort'  => [
                                                       'defaultOrder' => ['categoryName' => SORT_ASC],
                                                       'attributes'   => [
                                                           'categoryName' => [
                                                               'asc'     => [
                                                                   'sm."categoryName"' => SORT_ASC,
                                                                   'sm.id'             => SORT_ASC,
                                                               ],
                                                               'desc'    => [
                                                                   'sm."categoryName"' => SORT_DESC,
                                                                   'sm.id'             => SORT_DESC,
                                                               ],
                                                               'default' => SORT_DESC,
                                                           ],
                                                           'name'         => [
                                                               'asc'     => [
                                                                   'sm.name' => SORT_ASC,
                                                                   'sm.id'   => SORT_ASC,
                                                               ],
                                                               'desc'    => [
                                                                   'sm.name' => SORT_DESC,
                                                                   'sm.id'   => SORT_DESC,
                                                               ],
                                                               'default' => SORT_DESC,
                                                           ],
                                                           'mkb10'        => [
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
                                                           'type'         => [
                                                               'asc'     => [
                                                                   'sm.type' => SORT_ASC,
                                                                   'sm.id'   => SORT_ASC,
                                                               ],
                                                               'desc'    => [
                                                                   'sm.type' => SORT_DESC,
                                                                   'sm.id'   => SORT_DESC,
                                                               ],
                                                               'default' => SORT_DESC,
                                                           ],
                                                           'destination'  => [
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
                                                           'criterion'    => [
                                                               'asc'     => [
                                                                   'sm.criterion' => SORT_ASC,
                                                                   'sm.id'        => SORT_ASC,
                                                               ],
                                                               'desc'    => [
                                                                   'sm.criterion' => SORT_DESC,
                                                                   'sm.id'        => SORT_DESC,
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
            ->andFilterWhere(['ilike', 'sm.type', $this->type])
            ->andFilterWhere(['ilike', 'sm.name', $this->name])
            ->andFilterWhere(['sm."isImportant"' => $this->isImportant])
            ->andFilterWhere(['ilike', 'sm.criterion', $this->criterion])
            ->andFilterWhere(['ilike', 'sm."categoryName"', $this->categoryName]);

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