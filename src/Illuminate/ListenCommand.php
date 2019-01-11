<?php

namespace Bokt\Queue\Illuminate;

use Illuminate\Queue\Listener;
use Symfony\Component\Console\Input\InputOption;

class ListenCommand extends \Illuminate\Queue\Console\ListenCommand
{
    public function __construct(Listener $listener)
    {
        parent::__construct($listener);

        // Required option for the queue to work, this is a native command flag for Laravel.
        $this->addOption('env', null, InputOption::VALUE_OPTIONAL, '');
    }
}
