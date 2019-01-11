<?php

namespace Bokt\Queue\Providers;

use Bokt\Queue\Console\TablesCommand;
use Bokt\Queue\Exception\Handler;
use Flarum\Console\Event\Configuring;
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
        $this->configuration();

        $this->app->when(Listener::class)
            ->needs('$commandPath')
            ->give($this->app->basePath());

        $this->app->when(QueueManager::class)
            ->needs('$app')
            ->give($this->app);

        $this->app['events']->listen(Configuring::class, function (Configuring $event) {
            $event->addCommand(Commands\FlushFailedCommand::class);
            $event->addCommand(Commands\ForgetFailedCommand::class);
            $event->addCommand(Commands\ListenCommand::class);
            $event->addCommand(Commands\ListFailedCommand::class);
            $event->addCommand(Commands\RestartCommand::class);
            $event->addCommand(Commands\RetryCommand::class);
            $event->addCommand(Extend\WorkCommand::class);

            $event->addCommand(TablesCommand::class);
        });
    }

    protected function registerWorker()
    {
        $this->app->singleton(Worker::class, function ($app) {
            $worker = new Extend\Worker(
                $app->make('queue'),
                $app->make('events'),
                new Handler($this->app)
            );

            // Flarum binds Cache Repository in InstalledSite.
            $worker->setCache($this->app['cache.store']);

            return $worker;
        });
    }

    protected function configuration()
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $this->app['config'];

        $config->set('queue.default', 'database');
        $config->set('queue.connections.database', [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
        ]);

        $config->set('queue.failed.table', 'failed_jobs');
    }
}
