<?php

namespace FightTheIce\Console\Events\Output;

class Line implements BasicOutputInterface {
    /**
     * @var mixed
     */
    protected $message;
    /**
     * @var mixed
     */
    protected $command;
    /**
     * @var mixed
     */
    protected $style;
    /**
     * @var mixed
     */
    protected $verbosity;

    /**
     * @param $message
     * @param $style
     * @param $verbosity
     * @param $command
     */
    public function __construct($message, $style, $verbosity, $command) {
        $this->message   = $message;
        $this->style     = $style;
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

    /**
     * @return mixed
     */
    public function getStyle() {
        return $this->style;
    }
}
