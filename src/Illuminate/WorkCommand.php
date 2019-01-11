<?php

namespace Bokt\Queue\Illuminate;

use Illuminate\Queue\Worker;
use Symfony\Component\Console\Input\InputOption;

class WorkCommand extends \Illuminate\Queue\Console\WorkCommand
{
    public function __construct(Worker $worker)
    {
        parent::__construct($worker);

        // Required option for the queue to work, this is a native command flag for Laravel.
        $this->addOption('env', null, InputOption::VALUE_OPTIONAL, '');
    }

    protected function runWorker($connection, $queue)
    {
        return $this->worker->{$this->option('once') ? 'runNextJob' : 'daemon'}(
            $connection, $queue, $this->gatherWorkerOptions()
        );
    }
}
