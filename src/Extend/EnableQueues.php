<?php

namespace Bokt\Queue\Extend;

use Bokt\Queue\Providers\QueueProvider;
use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Container\Container;

class EnableQueues implements ExtenderInterface
{

    public function extend(Container $container, Extension $extension = null)
    {
        $container->register(QueueProvider::class);
    }
}
