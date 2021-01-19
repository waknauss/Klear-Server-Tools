<?php

namespace Klear\Commands\Webserver;

use FightTheIce\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use FightTheIce\Domain\Parser as DomainParser;
use Illuminate\Support\Str;

class GeneratePHPFPMConfig extends Command {
	protected $signature = 'webserver:generatephpfpmconfig{username? : System Username}';
	protected $description = 'Generate PHP-FPM Vhost file';
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

        //make sure a template file exists
        $templatePath = 'templates'.DIRECTORY_SEPARATOR.'phpfpm.txt';
        if (!file_exists($templatePath)) {
            $this->error('Template file does not exists!');
            return -3;
        }

        $template = file_get_contents($templatePath);
        $template = str_replace('{USERNAME}',$username,$template);
        $template = str_replace('{TIME}',time(),$template);

        $path = '/etc/php/7.3/fpm/pool.d/'.$username.'.conf';
        file_put_contents($path,$template);
        $this->comment('Wrote FPM file: ['.$path.']');

        //get the config
        $config = $this->getContainer()->make('config');

        $commands = array();

        //get the command
        $commands[] = $config->get('commands.services.php-fpm.stop');
        $commands[] = $config->get('commands.services.php-fpm.start');

        foreach ($commands as $command) {
            if (is_null($command)) {
                $this->error('Command may not be null!');
                return -5;
            }
        }

        foreach ($commands as $command) {
            $process = Process::fromShellCommandline($command);
            $process->run();

            if (!$process->isSuccessful()) {
                $exception = new ProcessFailedException($process);
                $this->error($exception->getMessage());
                return -2;
            }
        }
	}
}