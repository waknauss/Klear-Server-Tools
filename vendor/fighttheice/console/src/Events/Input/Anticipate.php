<?php

namespace FightTheIce\Console\Events\Input;

use FightTheIce\Console\Events\Output\BasicOutputInterface;

class Anticipate implements AdvancedInputInterface, BasicOutputInterface {
    /**
     * @var mixed
     */
    public $question;
    /**
     * @var mixed
     */
    public $choices;
    /**
     * @var mixed
     */
    public $default;
    /**
     * @var mixed
     */
    public $answer;
    /**
     * @var mixed
     */
    public $command;

    /**
     * @param $question
     * @param $choices
     * @param $default
     * @param $answer
     * @param $command
     */
    public function __construct($question, $choices, $default, $answer, $command) {
        $this->question = $question;
        $this->choices  = $choices;
        $this->default  = $default;
        $this->answer   = $answer;
        $this->command  = $command;
    }

    /**
     * @return mixed
     */
    public function getAnswer() {
        return $this->answer;
    }

    /**
     * @return mixed
     */
    public function getMessage() {
        return $this->question;
    }

    /**
     * @return mixed
     */
    public function getCommand() {
        return $this->command;
    }
}
