<?php

namespace Bokt\Queue\Providers;

use Bokt\Queue\Exception\Handler;
use Flarum\Console\Event\Configuring;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Queue\Console as Commands;
use Illuminate\Queue\Listener;
use Illuminate\Queue\QueueManager;
use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Queue\Worker;
use Bokt\Queue\Illuminate as Extend;

class QueueProvider extends QueueServiceProvider
{
    public function boot()
    {
        $this->app->when(Listener::class)
            ->needs('$commandPath')
            ->give($this->app->basePath());

        $this->app->when(QueueManager::class)
            ->needs('$app')
            ->give($this->app);

        $this->app['events']->listen(Configuring::class, function (Configuring $event) {
            $event->addCommand(Commands\FailedTableCommand::class);
            $event->addCommand(Commands\FlushFailedCommand::class);
            $event->addCommand(Commands\ForgetFailedCommand::class);
            $event->addCommand(Commands\ListenCommand::class);
            $event->addCommand(Commands\ListFailedCommand::class);
            $event->addCommand(Commands\RestartCommand::class);
            $event->addCommand(Commands\RetryCommand::class);
            $event->addCommand(Commands\TableCommand::class);
            $event->addCommand(Extend\WorkCommand::class);
        });
    }

    protected function registerWorker()
    {
        $this->app->singleton(Worker::class, function ($app) {
            $worker = new Extend\Worker(
                $app->make(QueueManager::class),
                $app->make(Dispatcher::class),
                new Handler($this->app)
            );

            $worker->setCache($this->app['cache.store']);

            return $worker;
        });
    }
}
