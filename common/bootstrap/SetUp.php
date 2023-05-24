<?php

namespace common\bootstrap;

use core\dispatchers\DeferredEventDispatcher;
use core\dispatchers\EventDispatcher;
use core\events\ConsultationUploadFileEvent;
use core\listeners\ConsultationUploadFileListener;
use yii\base\BootstrapInterface;
use yii\caching\Cache;
use yii\rbac\ManagerInterface;
use yii\base\ErrorHandler;
use yii\queue\Queue;
use yii\di\Container;
use core\dispatchers\AsyncEventDispatcher;
use core\dispatchers\SimpleEventDispatcher;
use core\queueServer\AsyncEventJobHandler;
use yii\di\Instance;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->authManager;
        });

        $container->setSingleton(ErrorHandler::class, function () use ($app) {
            return $app->errorHandler;
        });

        $container->setSingleton(Cache::class, function () use ($app) {
            return $app->cache;
        });

        $container->setSingleton(Queue::class, function () use ($app) {
            return $app->get('queue');
        });

        $container->setSingleton(EventDispatcher::class, DeferredEventDispatcher::class);

        $container->setSingleton(DeferredEventDispatcher::class, function (Container $container) {
            return new DeferredEventDispatcher(new AsyncEventDispatcher($container->get(Queue::class)));
        });


        $container->setSingleton(SimpleEventDispatcher::class, function (Container $container) {
            return new SimpleEventDispatcher($container, [
                ConsultationUploadFileEvent::class => [ConsultationUploadFileListener::class],
            ]);
        });

        $container->setSingleton(AsyncEventJobHandler::class, [], [
            Instance::of(SimpleEventDispatcher::class),
        ]);
    }
}