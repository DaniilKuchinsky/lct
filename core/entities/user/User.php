<?php

namespace core\entities\user;

use core\helpers\SiteHelper;
use core\helpers\user\UserHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;
use yii\rbac\Permission;
use yii\rbac\Role;

/**
 * Пользователь
 *
 * @property integer $id
 * @property string  $email
 * @property string  $authKey
 * @property string  $passwordHash
 * @property string  $passwordResetToken
 * @property integer $status
 * @property integer $created
 * @property integer $updated
 *
 */
class User extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'user';
    }


    public function behaviors(): array
    {
        return [
            [
                'class'      => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }


    public function getCreatedStr()
    {
        if ($this->created != 0) {
            return date('d.m.Y H:i', $this->created);
        }
    }


    public function getUpdatedStr()
    {
        if ($this->updated != 0) {
            return date('d.m.Y H:i', $this->updated);
        }
    }


    /**
     * @param string $email
     * @param string $password
     * @param int    $status
     *
     * @return self
     */
    public static function create(string $email, string $password, int $status): User
    {
        $user = new self();

        $user->email  = $email;
        $user->status = $status;

        $user->setPassword($password);
        $user->generateAuthKey();

        return $user;
    }


    /**
     * @param string $email
     * @param int    $status
     *
     */
    public function edit(string $email, int $status)
    {
        $this->email  = $email;
        $this->status = $status;
    }


    /**
     * @param int $status
     *
     * @return null
     */
    public function deleteUser(int $status = UserHelper::STATUS_DELETED)
    {
        $this->status = $status;
    }


    /**
     * @return null
     */
    public function restoreUser()
    {
        $this->status = UserHelper::STATUS_ACTIVE;
    }


    /**
     * @param string|null $password
     *
     * @return void
     * @throws
     *
     */
    public function setNewPassword(string $password = null)
    {
        $this->setPassword($password);
    }


    /**
     *
     * @param string|null $password
     *
     * @throws
     */
    private function setPassword(string $password = null)
    {
        if (empty($password)) {
            $password = UserHelper::generateStr();
        }
        $this->passwordHash = Yii::$app->security->generatePasswordHash($password);
    }


    /**
     *
     * @param string $password
     *
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->passwordHash);
    }


    /**
     * @throws
     */
    private function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }


    public function isActive(): bool
    {
        return $this->status === UserHelper::STATUS_ACTIVE;
    }


    public function isDeleted(): bool
    {
        return $this->status === UserHelper::STATUS_DELETED;
    }


    /**
     *
     * @return Role[]
     */
    public function getUserRoles(): array
    {
        return \Yii::$app->authManager->getRolesByUser($this->id);
    }


    /**
     *
     * @return Permission[]
     */
    public function getUserPermission(): array
    {
        return \Yii::$app->authManager->getPermissionsByUser($this->id);
    }

}