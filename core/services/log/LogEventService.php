<?php

namespace core\services\log;

use core\entities\log\LogEvent;
use core\helpers\log\LogEventHelper;
use core\repositories\log\LogEventRepository;

class LogEventService
{
    protected LogEventRepository $repository;


    public function __construct(
        LogEventRepository $repository
    ) {
        $this->repository = $repository;
    }


    /**
     * @param integer $id
     *
     * @return LogEvent
     */
    public function get(int $id): LogEvent
    {
        return $this->repository->get($id);
    }


    /**
     * @param string $requestInfo
     *
     * @return LogEvent
     */
    public function create(string $requestInfo): LogEvent
    {
        $item = LogEvent::create($requestInfo);

        $this->repository->save($item);

        return $item;
    }


    /**
     * @param integer $id
     *
     * @return null
     */
    public function success(int $id)
    {
        $item = $this->repository->get($id);
        $item->edit(LogEventHelper::STATUS_SUCCESS, null);


        $this->repository->save($item);
    }


    /**
     * @param integer $id
     * @param string  $resultInfo
     *
     * @return null
     */
    public function error(int $id, string $resultInfo)
    {
        $item = $this->repository->get($id);
        $item->edit(LogEventHelper::STATUS_ERROR, $resultInfo);


        $this->repository->save($item);
    }


}