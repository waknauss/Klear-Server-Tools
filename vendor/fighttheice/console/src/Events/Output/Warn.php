<?php

namespace FightTheIce\Console\Events\Output;

class Warn implements BasicOutputInterface {
    /**
     * @var mixed
     */
    protected $message;
    /**
     * @var mixed
     */
    protected $verbosity;
    /**
     * @var mixed
     */
    protected $command;

    /**
     * @param $message
     * @param $verbosity
     * @param $command
     */
    public function __construct($message, $verbosity, $command) {
        $this->message   = $message;
        $this->verbosity = $verbosity;
        $this->command   = $command;
    }

    /**
     * @return mixed
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getCommand() {
        return $this->command;
    }

    /**
     * @return mixed
     */
    public function getVerbosity() {
        return $this->verbosity;
    }
}
