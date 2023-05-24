<?php

namespace backend\forms\user;

use core\entities\user\User;
use core\models\CookieModel;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class UserSearch extends CookieModel
{
    public ?string $id = null;

    public ?string $email = null;

    public ?string $status = null;

    public ?string $role = null;

    public string $className = UserSearch::class;

    public array $cookiesList = ['id', 'email', 'status', 'role'];

    public function rules(): array
    {
        return [
            [['id', 'status'], 'integer'],
            [['email', 'role'], 'safe'],
        ];
    }



    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = User::find()->alias('u');

        $dataProvider = new ActiveDataProvider([
                                                   'query' => $query,
                                                   'sort'  => [
                                                       'defaultOrder' => ['email' => SORT_ASC],
                                                   ],
                                               ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');

            return $dataProvider;
        }

        if (!empty($this->role)) {
            $query->innerJoin('{{%auth_assignment}} a', 'CAST(a.user_id AS INTEGER) = u.id');
            $query->andWhere(['a.item_name' => $this->role]);
        }

        $query
            ->andFilterWhere(['u.id' => $this->id])
            ->andFilterWhere(['u.status' => $this->status])
            ->andFilterWhere(['ilike', 'u.email', $this->email]);

        $this->setDataForCookies();

        return $dataProvider;
    }

    public function resetCookieFilter()
    {
        $this->resetDataFromCookies();
    }

    public function rolesList(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }
}