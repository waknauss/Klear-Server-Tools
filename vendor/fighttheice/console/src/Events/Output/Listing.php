<?php

namespace FightTheIce\Console\Events\Output;

class Listing {
    /**
     * @var mixed
     */
    protected $elements;
    /**
     * @var mixed
     */
    protected $command;

    /**
     * @param $elements
     * @param $command
     */
    public function __construct($elements, $command) {
        $this->elements = $elements;
        $this->command  = $command;
    }

    /**
     * @return mixed
     */
    public function getElements() {
        return $this->elements;
    }

    /**
     * @return mixed
     */
    public function getCommand() {
        return $this->command;
    }
}
