<?php

namespace Bokt\Queue\Providers;

use Flarum\Console\Event\Configuring;
use Flarum\Foundation\AbstractServiceProvider;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Queue\Console as Commands;
use Illuminate\Queue\Listener;
use Illuminate\Queue\QueueServiceProvider;

class QueueProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->app->register(QueueServiceProvider::class);
        $this->app->alias('queue', Queue::class);

        $this->app->when(Listener::class)
            ->needs('$commandPath')
            ->give(base_path());
    }

    public function boot()
    {
        $this->app['events']->listen(Configuring::class, function (Configuring $event) {
            $event->addCommand(Commands\FailedTableCommand::class);
            $event->addCommand(Commands\FlushFailedCommand::class);
            $event->addCommand(Commands\ForgetFailedCommand::class);
            $event->addCommand(Commands\ListenCommand::class);
            $event->addCommand(Commands\ListFailedCommand::class);
            $event->addCommand(Commands\RestartCommand::class);
            $event->addCommand(Commands\RetryCommand::class);
            $event->addCommand(Commands\TableCommand::class);
            $event->addCommand(Commands\WorkCommand::class);
        });
    }
}
