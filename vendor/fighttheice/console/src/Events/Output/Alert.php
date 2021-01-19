<?php

namespace FightTheIce\Console\Events\Output;

class Alert implements BasicOutputInterface {
    /**
     * @var mixed
     */
    protected $message;
    /**
     * @var mixed
     */
    protected $command;

    /**
     * @param $message
     * @param $command
     */
    public function __construct($message, $command) {
        $this->message = $message;
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
}
