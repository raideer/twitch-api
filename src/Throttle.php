<?php

namespace Raideer\TwitchApi;

class Throttle
{
    protected $firstCall;
    protected $lastCall;
    protected $waitBeforeNext;
    protected $limit;
    protected $limitTimeframe;
    protected $calls;

    public function __construct($wait = 0)
    {
        $this->waitBeforeNext = $wait;
        $this->limit = 0;
    }

    public function throttle()
    {
        $mkTime = microtime();

        if (!$this->lastCall) {
            $this->lastCall = $mkTime;
            $this->firstCall = $mkTime;

            return;
        }

        $dif = $mkTime - $this->lastCall;
        if ($dif < $this->waitBeforeNext) {
            usleep($this->waitBeforeNext - $dif);
        }

        $this->lastCall = microtime();
    }

    public function setInterval($ms)
    {
        $this->waitBeforeNext = $ms * 1000;
    }

  // public function setLimit($limit, $time){
  //   $this->limit = $limit;
  //   $this->limitTimeframe = $time;
  // }
}
