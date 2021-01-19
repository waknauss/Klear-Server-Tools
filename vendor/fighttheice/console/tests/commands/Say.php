<?php

class Say extends FightTheIce\Console\Command
{
    protected $signature = 'say {name? : My name}';

    public function handle()
    {
        $name = $this->argument('name');
        if (empty($name)) {
            $name = $this->ask('Name');
        }

        $this->comment($name);

        //return 1;
    }
}
