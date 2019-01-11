<?php

namespace Bokt\Queue\Illuminate;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Queue\Worker;

class RestartCommand extends \Illuminate\Queue\Console\RestartCommand
{
    /**
     * @var Repository
     */
    protected $cache;

    public function __construct(Worker $worker)
    {
        $this->cache = $worker->getCache();

        parent::__construct();
    }

    public function handle()
    {
        $this->cache->forever('illuminate:queue:restart', $this->currentTime());

        $this->info('Broadcasting queue restart signal.');
    }
}
