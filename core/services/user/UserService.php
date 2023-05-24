<?php

namespace core\services\user;

use backend\forms\user\UserCreateForm;
use backend\forms\user\UserEditForm;
use core\entities\user\User;
use core\forms\user\ChangePasswordForm;
use core\repositories\user\UserRepository;
use core\services\TransactionManager;

class UserService
{
    protected UserRepository      $repUser;

    protected RoleManager         $roles;

    protected TransactionManager  $transaction;


    /**
     * @return null
     */
    public function __construct(
        UserRepository      $repository,
        RoleManager         $roles,
        TransactionManager  $transaction
    ) {
        $this->repUser      = $repository;
        $this->roles        = $roles;
        $this->transaction  = $transaction;
    }


    /**
     * @param integer $id
     *
     * @return User
     */
    public function get(int $id): User
    {
        return $this->repUser->get($id);
    }


    /**
     * @param int $id
     *
     * @return null
     */
    public function deleteUser(int $id)
    {
        $this->transaction->wrap(function () use ($id) {
            $item = $this->repUser->get($id);
            $item->deleteUser();
            $this->repUser->save($item);

        });
    }


    /**
     * @param int $id
     *
     * @return null
     */
    public function restoreUser(int $id)
    {
        $item = $this->repUser->get($id);
        $item->restoreUser();
        $this->repUser->save($item);
    }


    /**
     * @param integer            $id
     * @param ChangePasswordForm $form
     *
     * @return null
     */
    public function changePsw(int $id, ChangePasswordForm $form)
    {
        $user = $this->repUser->get($id);
        $user->setNewPassword($form->password);
        $this->repUser->save($user);
    }


    /**
     * @param UserCreateForm $form
     *
     * @return
     */
    public function create(UserCreateForm $form)
    {
        $user = User::create($form->email, $form->password, $form->status);

        $this->transaction->wrap(function () use ($user, $form) {
            $this->repUser->save($user);
            $this->roles->assign($user->id, [$form->role]);
        });
    }


    /**
     * @param integer      $id
     * @param UserEditForm $form
     *
     * @return
     */
    public function edit(int $id, UserEditForm $form)
    {
        $user = $this->repUser->get($id);

        $user->edit($form->email, $form->status);

        $this->transaction->wrap(function () use ($user, $form) {
            $this->repUser->save($user);
            $this->roles->assign($user->id, [$form->role]);
        });
    }


    /**
     * @param integer $id
     *
     * @return
     */
    public function deletePermanently(int $id)
    {
        $this->transaction->wrap(function () use ($id) {
            $item = $this->repUser->get($id);
            $item->delete();

        });
    }
}