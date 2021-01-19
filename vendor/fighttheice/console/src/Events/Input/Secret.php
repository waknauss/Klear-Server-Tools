<?php

namespace FightTheIce\Console\Events\Input;

use FightTheIce\Console\Events\Output\BasicOutputInterface;

class Secret implements AdvancedInputInterface, BasicOutputInterface {
    /**
     * @var mixed
     */
    protected $question;
    /**
     * @var mixed
     */
    protected $fallback;
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
     * @param $fallback
     * @param $answer
     * @param $command
     */
    public function __construct($question, $fallback, $answer, $command) {
        $this->question = $question;
        $this->fallback = $fallback;
        $this->answer   = $answer;
        $this->command  = $command;
    }

    /**
     * @return mixed
     */
    public function getQuestion() {
        return $this->question;
    }

    /**
     * @return mixed
     */
    public function getFallback() {
        return $this->fallback;
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
