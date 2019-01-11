<?php

namespace Bokt\Queue\Illuminate;

class WorkCommand extends \Illuminate\Queue\Console\WorkCommand
{
    protected function runWorker($connection, $queue)
    {
        return $this->worker->{$this->option('once') ? 'runNextJob' : 'daemon'}(
            $connection, $queue, $this->gatherWorkerOptions()
        );
    }
}
