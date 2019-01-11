<?php

namespace Bokt\Queue\Exception;

use Exception;
use Flarum\Foundation\Application;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Psr\Log\LoggerInterface;

class Handler implements ExceptionHandler
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var LoggerInterface
     */
    protected $log;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->log = $app->make(LoggerInterface::class);
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        $this->log->error($e->getMessage(), [$e->getTraceAsString()]);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        // .. Not doing this in Queue.
    }

    /**
     * Render an exception to the console.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @param  \Exception                                        $e
     * @return void
     */
    public function renderForConsole($output, Exception $e)
    {
        $output->write($e->getMessage());
        $output->write($e->getTraceAsString());
    }
}
