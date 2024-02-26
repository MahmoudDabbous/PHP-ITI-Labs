<?php

namespace Dabbous\Lab3;



class Counter
{
    private $logPath;

    public function __construct()
    {
        $this->logPath = VISITS_LOG;
    }

    public function getCount(): int
    {
        return file_exists($this->logPath) ? (int) file_get_contents($this->logPath) : 0;
    }

    public function incrementCount(): void
    {
        $count = $this->getCount();
        file_put_contents($this->logPath, ++$count);
    }
}
