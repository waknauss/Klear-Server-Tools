<?php

namespace Klear\Commands\Backend;

use FightTheIce\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CreateUser extends Command {
	protected $signature = 'backend:createuser {username? : System Username}';
	protected $description = 'Create a backend user';
	protected $hidden = true;
	protected $enabled = true;

	public function handle() {
        $username = $this->argument('username');
        if (empty($username)) {
            $username = $this->ask('Username:');
        }

        if (empty($username)) {
            $this->error('The username argument may not be empty!');
            return -1;
        }


        //get the config
        $config = $this->getContainer()->make('config');
        
        //get the create-user command
        $command = $config->get('commands.system.create-user');
        
        if (is_null($command)) {
            $this->error('Create user command not found!');
        }

        $command = str_replace('{USERNAME}',$username,$command);
        
        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            $exception = ProcessFailedException($process);
            $this->error($exception->getMessage());
            return -2;
        }
        
        $this->comment($process->getOutput());
	}
}