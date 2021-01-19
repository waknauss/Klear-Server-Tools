<?php

class Hello extends FightTheIce\Console\Command {
    /**
     * @var mixed
     */
    protected $enabled = true;
    /**
     * @var mixed
     */
    protected $useEvents = true;

    /**
     * @var string
     */
    protected $helpText = '';

    /**
     * @var mixed
     */
    protected $singleInstance = false;

    /**
     * @var string
     */
    protected $signature = 'hello {name? : Hoomans Name}';

    /**
     * @return int
     */
    public function handle() {
        throw new \ErrorException('ERROR');
        if (file_exists('somelog.txt')) {
            $data = file_get_contents('somelog.txt');
            $data = json_decode($data);
            print_r($data);
            exit;
        }
        //$this->comment('UUID: [' . $this->getUuid() . ']');

        $name = $this->argument('name');
        if (empty($name)) {
            $name = $this->ask('What is your name', 'David');
        }

        $this->comment($name);

        return 0;
    }
}
