<?php

namespace FightTheIce\Console\Events;

class Terminate {
    /**
     * @var mixed
     */
    public $event;
    /**
     * @var mixed
     */
    protected $input;
    /**
     * @var mixed
     */
    protected $output;
    /**
     * @var mixed
     */
    protected $command;

    /**
     * @param $event
     * @param $input
     * @param $output
     * @param $command
     */
    public function __construct($event, $input, $output, $command) {
        $this->event   = $event;
        $this->input   = $input;
        $this->output  = $output;
        $this->comment = $command;
    }

    /**
     * @return mixed
     */
    public function getInput() {
        return $this->input;
    }

    /**
     * @return mixed
     */
    public function getOutput() {
        return $this->output;
    }

    /**
     * @return mixed
     */
    public function getCommand() {
        return $this->command;
    }
}
