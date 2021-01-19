<?php

namespace FightTheIce\Console\Events\Output;

class NewLine {
    /**
     * @var mixed
     */
    protected $count;
    /**
     * @var mixed
     */
    protected $command;

    /**
     * @param $count
     * @param $command
     */
    public function __construct($count, $command) {
        $this->count   = $count;
        $this->command = $command;
    }

    /**
     * @return mixed
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * @return mixed
     */
    public function getCommand() {
        return $this->command;
    }
}
