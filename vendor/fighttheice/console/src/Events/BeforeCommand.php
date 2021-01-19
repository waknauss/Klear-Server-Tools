<?php

namespace FightTheIce\Console\Events;

class BeforeCommand {
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
     * @param $input
     * @param $output
     * @param $command
     */
    public function __construct($input, $output, $command) {
        $this->input   = $input;
        $this->output  = $output;
        $this->command = $command;
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
