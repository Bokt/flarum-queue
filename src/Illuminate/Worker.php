<?php

namespace Bokt\Queue\Illuminate;

use Illuminate\Contracts\Cache\Repository as CacheContract;

class Worker extends \Illuminate\Queue\Worker
{

    public function setCache(CacheContract $cache)
    {
        if ($this->cache === null) {
            $this->cache = $cache;
        }
    }

    /**
     * @return CacheContract
     */
    public function getCache(): CacheContract
    {
        return $this->cache;
    }
}
