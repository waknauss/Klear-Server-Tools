<?php

namespace Klear\Libraries;

use FightTheIce\Console\Application as FConsole;
use Symfony\Component\Process\Process;

class Console {
    protected $app = null;
    protected $register_handlers = false;

    public function __construct(FConsole $app) {
        $this->app = $app;
        $this->register_handlers();
    }

    protected function register_handlers() {
        if ($this->register_handlers==false) {
            return;
        }

        $this->before_command_handler();
        $this->output_handler();
        $this->input_handler();
    }

    protected function before_command_handler() {
        $this->app->getEvents()->listen('FightTheIce\Console\Events\BeforeCommand', function ($event) {
            $command     = $event->getCommand();
            $application = $command->getApplication();
            $container   = $application->getContainer();
        
            $uuid = array(
                'command' => $command->getUuid(),
                'application' => $application->getUuid()
            );
        
            $logPath = 'cli_logs';
            if (!file_exists($logPath)) {
                mkdir($logPath);
            }
        
            $logPath = $logPath.DIRECTORY_SEPARATOR.date('Y-m-d');
            if (!file_exists($logPath)) {
                mkdir($logPath);
            }
        
            $logPath = $logPath.DIRECTORY_SEPARATOR.$uuid['application'];
            if (!file_exists($logPath)) {
                mkdir($logPath);
            }
        
            $logPath = $logPath.DIRECTORY_SEPARATOR.'log.txt';
        
            $data = array(
                '_SERVER' => $_SERVER,
                'dteExecutedDate' => date('Y-m-d H:i:s'),
                'UUID' => $application->getUuid()->__toString()
            );
            //file_put_contents($logPath,base64_encode(json_encode($data,JSON_PRETTY_PRINT)).PHP_EOL,FILE_APPEND);
            file_put_contents($logPath,print_r($data,true).PHP_EOL,FILE_APPEND);
        });
    }

    protected function output_handler() {
        $this->app->getEvents()->listen('FightTheIce\Console\Events\Output\*', function ($eventname, $events) {
            foreach ($events as $event) {
                $command     = $event->getCommand();
                $application = $command->getApplication();
                $message     = '';
                switch ($eventname) {
                    case 'FightTheIce\Console\Events\Output\Listing':
                        $message = implode('|',$event->getElements());
                        break;
        
                    case 'FightTheIce\Console\Events\Output\NewLine':
                        $message = '';
                        break;
        
                    case 'FightTheIce\Console\Events\Output\Table':
                        $message = implode(',',$event->getHeaders()).PHP_EOL;
                        $rows = $event->getRows();
                        foreach ($rows as $row) {
                            $message = $message.implode(',',$row).PHP_EOL;
                        }
                        break;
        
                    default:
                        $message = $event->getMessage();
                }
        
                $data = array(
                    'TYPE'    => 'OUTPUT',
                    'NAME'    => $eventname,
                    'MESSAGE' => $message,
                    'COMMAND' => array(
                        'signature' => $command->getSignature(),
                        'uuid'      => $command->getUuid()->__toString()
                    )
                );
        
                $logPath = 'cli_logs'.DIRECTORY_SEPARATOR.date('Y-m-d').DIRECTORY_SEPARATOR.$application->getUuid().DIRECTORY_SEPARATOR.'log.txt';
                file_put_contents($logPath,print_r($data,true).PHP_EOL,FILE_APPEND);
                //file_put_contents($logPath,base64_encode(json_encode($data,JSON_PRETTY_PRINT)).PHP_EOL,FILE_APPEND);
            }
        });
    }

    protected function input_handler() {
        $this->app->getEvents()->listen('FightTheIce\Console\Events\Input\*', function ($eventname, $events) {
            foreach ($events as $event) {
                $command     = $event->getCommand();
                $application = $command->getApplication();
        
                $data = array(
                    'TYPE'    => 'INPUT',
                    'NAME'    => $eventname,
                    'MESSAGE' => $event->getMessage(),
                    'ANSWER'  => $event->getAnswer(),
                    'COMMAND' => array(
                        'signature' => $command->getSignature(),
                        'uuid'      => $command->getUuid()->__toString()
                    )
                );
        
                $logPath = 'cli_logs'.DIRECTORY_SEPARATOR.date('Y-m-d').DIRECTORY_SEPARATOR.$application->getUuid().DIRECTORY_SEPARATOR.'log.txt';
                //file_put_contents($logPath,base64_encode(json_encode($data,JSON_PRETTY_PRINT)).PHP_EOL,FILE_APPEND);
                file_put_contents($logPath,print_r($data,true).PHP_EOL,FILE_APPEND);
            }
        });
    }

    public function new_process($command) {
        return new Process([$command]);
    }
}