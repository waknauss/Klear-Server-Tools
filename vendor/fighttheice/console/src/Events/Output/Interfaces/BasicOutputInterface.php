<?php

namespace FightTheIce\Console\Events\Output;

interface BasicOutputInterface {
    public function getMessage();

    public function getCommand();
}
