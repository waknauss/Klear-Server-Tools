<?php

namespace FightTheIce\Console\Events\Input;

use FightTheIce\Console\Events\Output\BasicOutputInterface;

class Ask implements AdvancedInputInterface, BasicOutputInterface {
    /**
     * @var mixed
     */
    protected $question;
    /**
     * @var mixed
     */
    public $default;
    /**
     * @var mixed
     */
    protected $answer;
    /**
     * @var mixed
     */
    protected $command;

    /**
     * @param $question
     * @param $default
     * @param $answer
     * @param $command
     */
    public function __construct($question, $default, $answer, $command) {
        $this->question = $question;
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
