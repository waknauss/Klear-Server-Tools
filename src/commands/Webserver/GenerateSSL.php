<?php

namespace Klear\Commands\Webserver;

use FightTheIce\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use FightTheIce\Domain\Parser as DomainParser;
use Illuminate\Support\Str;

class GenerateSSL extends Command {
	protected $signature = 'webserver:generatessl {username? : System Username}';
	protected $description = 'Generate SSL certs (self signed)';
	protected $hidden = false;
    protected $enabled = true;
    
    public function isEnabled() {
        $system = $this->getContainer()->make('system');
        if ($system=='webserver') {
            return true;
        }

        return false;
    }

	public function handle() {
        $username = $this->argument('username');
        if (empty($username)) {
            $username = $this->ask('Username:');
        }

        if (empty($username)) {
            $this->error('The username argument may not be empty!');
            return -1;
        }

        $parser = new DomainParser();
        try {
            $parser->parse($username);	
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return -1;
        }

        $subdomain = $parser->getSubdomain();
        $domain = $parser->getDomain();
        $gld = $parser->getGld();
        if (empty($subdomain)) {
            $subdomain = 'www';
        }

        $username = $subdomain.'.'.$domain.'.'.$gld;
        
        if (!file_exists('/home/'.$username)) {
            $this->error('Username does not exists!');
            return -2;
        }

        //get the config
        $config = $this->getContainer()->make('config');
        
        //get the create-user command
        $command = $config->get('commands.system.generate-ssl');
        
        if (is_null($command)) {
            $this->error('Generate SSL command not found!');
        }

        $command = str_replace('{USERNAME}',$username,$command);
        
        $process = Process::fromShellCommandline($command);
        $process->run();

        if (!$process->isSuccessful()) {
            $exception = new ProcessFailedException($process);
            $this->error($exception->getMessage());
            return -2;
        }
        
        //$this->comment($process->getOutput());

        $this->comment('Generated SSL cert for: ['.$username.']');
	}
}