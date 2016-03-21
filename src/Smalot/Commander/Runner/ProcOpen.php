<?php

namespace Smalot\Commander\Runner;

use Smalot\Commander\Command;

/**
 * Class ProcOpen
 * @package Smalot\Commander\Runner
 */
class ProcOpen
{
    /**
     * @var int
     */
    protected $returnCode;

    /**
     * @var string
     */
    protected $stdout;

    /**
     * @var string
     */
    protected $stderr;

    /**
     * @var double
     */
    protected $duration;

    /**
     * ProcOpen constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param \Smalot\Commander\Command $command
     * @param int $timeout
     * @return string
     */
    public function run(Command $command, $timeout = -1)
    {
        $this->execute((string) $command, null, $timeout);

        return $this->getOutput();
    }

    /**
     * @return float
     */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * @return int
     */
    public function getReturnCode() {
        return $this->returnCode;
    }

    /**
     * @return string
     */
    public function getOutput() {
        return $this->stdout;
    }

    /**
     * @return string
     */
    public function getError() {
        return $this->stderr;
    }

    /**
     * @param string $cmd
     * @param string|null $stdin
     * @param int $timeout
     */
    protected function execute($cmd, $stdin = null, $timeout = -1)
    {
        // Todo: mix with this article
        // http://blog.dubbelboer.com/2012/08/24/execute-with-timeout.html

        $proc = proc_open(
          $cmd,
          [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']],
          $pipes
        );

//        if (isset($stdin)) {
//            fwrite($pipes[0], $stdin);
//        }
        stream_set_blocking($pipes[0], 0);
        fclose($pipes[0]);

        stream_set_timeout($pipes[1], 0);
        stream_set_timeout($pipes[2], 0);

        stream_set_blocking($pipes[1], 0);
        stream_set_blocking($pipes[2], 0);

        $this->stdout = '';

        $start = microtime(true);

        echo 'start';

        while (true) {
            echo microtime(true) - $start . ' - ' . $timeout . "\n";
            usleep(1000);

            if ($data = fread($pipes[1], 4096)) {
                $this->stdout .= $data;
            }

            $stat = proc_get_status($proc);
//            var_dump($stat);
            $meta = stream_get_meta_data($pipes[1]);
            if (microtime(true) - $start > $timeout) {
                break;
            }
            if ($meta['timed_out']) {
                continue;
            }
        }

        echo 'end';

        $this->stdout .= stream_get_contents($pipes[1]);
        $this->stderr = stream_get_contents($pipes[2]);

        fclose($pipes[1]);
        fclose($pipes[2]);
        $pipes = null;

        $this->returnCode = 0;//proc_close($proc);
        $this->duration = microtime(true) - $start;
    }
}
