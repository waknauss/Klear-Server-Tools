<?php

namespace FightTheIce\Console\Events\Input;

use FightTheIce\Console\Events\Output\BasicOutputInterface;

class Choice implements AdvancedInputInterface, BasicOutputInterface {
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
    public $attempts;
    /**
     * @var mixed
     */
    public $multiple;
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
     * @param $attempts
     * @param $multiple
     * @param $answer
     * @param $command
     */
    public function __construct($question, $choices, $default, $attempts, $multiple, $answer, $command) {
        $this->question = $question;
        $this->choices  = $choices;
        $this->default  = $default;
        $this->attempts = $attempts;
        $this->multiple = $multiple;
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
