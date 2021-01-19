<?php

namespace FightTheIce\Console\Events\Output;

class ErrorExit implements BasicOutputInterface {
    /**
     * @var mixed
     */
    protected $message;
    /**
     * @var mixed
     */
    protected $exit;
    /**
     * @var mixed
     */
    protected $command;

    /**
     * @param $message
     * @param $exit
     * @param $command
     */
    public function __construct($message, $exit, $command) {
        $this->message = $message;
        $this->exit    = $exit;
        $this->command = $command;
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
    public function getExit() {
        return $this->exit;
    }

    /**
     * @return mixed
     */
    public function willExit() {
        return $this->getExit();
    }
}
