<?php

namespace FightTheIce\Console\Events;

class CallSilent {
    /**
     * @var string
     */
    protected $currentSignature = '';
    /**
     * @var array
     */
    protected $currentArguments = array();

    /**
     * @var string
     */
    protected $calledSignature = '';
    /**
     * @var array
     */
    protected $calledArguments = array();
    /**
     * @var string
     */
    protected $returnedValue = '';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($currentSignature, $currentArguments, $calledSignature, $calledArguments, $returnedValue) {
        $this->currentSignature = $currentSignature;
        $this->currentArguments = $currentArguments;

        $this->calledSignature = $calledSignature;
        $this->calledArguments = $calledArguments;
        $this->returnedValue   = $returnedValue;
    }

    /**
     * @return mixed
     */
    public function getCurrentSignature() {
        return $this->currentSignature;
    }

    /**
     * @return mixed
     */
    public function getCurrentArguments() {
        return $this->currentArguments;
    }

    /**
     * @return mixed
     */
    public function getCalledSignature() {
        return $this->calledSignature;
    }

    /**
     * @return mixed
     */
    public function getCalledArguments() {
        return $this->calledArguments;
    }

    /**
     * @return mixed
     */
    public function getReturnedValue() {
        return $this->returnedValue;
    }
}