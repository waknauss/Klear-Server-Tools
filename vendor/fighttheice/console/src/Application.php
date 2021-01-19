<?php

namespace FightTheIce\Console;

use Illuminate\Console\Application as I_Application;
use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Events\Dispatcher as IlluminateDispatcher;
use Illuminate\Support\Str;
use Symfony\Component\Console\Application as S_Application;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Application extends I_Application {
    /**
     * @var mixed
     */
    protected $events = null;
    /**
     * @var mixed
     */
    protected $dispatcher = null;

    /**
     * @var string
     */
    protected $uuid = '';

    /**
     * __construct
     * Class construct
     * Sets the application name, and version
     *
     * @access public
     * @param string $name
     * @param string $version
     */
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN', Container $container = null, Dispatcher $events = null) {
        //if no container was given lets create one
        if (is_null($container)) {
            $container = new IlluminateContainer;
        }

        //if no events dispatcher was given lets create one
        if (is_null($events)) {
            $events = new IlluminateDispatcher($container);
        }

        // setup the Laravel constructors
        parent::__construct($container, $events, $version);
        parent::setName($name);

        $this->laravel = $container;
        $this->events  = $events;
        $this->setAutoExit(false);
        $this->setCatchExceptions(false);

        $this->events->dispatch(new Events\ArtisanStarting($this));

        $this->bootstrap();

        $container->instance('console', $this); //add the console app to the container

        // setup the Symfony constructor
        S_Application::__construct($name, $version);
        $this->dispatcher = new EventDispatcher();
        $this->setDispatcher($this->dispatcher);
        S_Application::setDispatcher($this->dispatcher);
        $this->setupSymfonyEvents();

        $this->uuid = Str::uuid();
    }

    protected function setupSymfonyEvents() {
        /*
        Typical Purposes: Handle exceptions thrown during the execution of a command.

        Whenever an exception is thrown by a command, including those triggered from event listeners, the ConsoleEvents::ERROR event is dispatched. A listener can wrap or change the exception or do anything useful before the exception is thrown by the application.

        NOTE: This essentially is a wrapper for a Symfony to Illuminate Event
         */
        $this->dispatcher->addListener(ConsoleEvents::ERROR, function (ConsoleErrorEvent $event) {
            // gets the input instance
            $input = $event->getInput();

            // gets the output instance
            $output = $event->getOutput();

            // gets the command to be executed
            $command = $event->getCommand();

            if ($command instanceof \FightTheIce\Console\Command) {
                if ($command->shouldUseEvents() == true) {
                    $command->getApplication()->getEvents()->dispatch(new Events\Error($event, $input, $output, $command));
                }
            }
        });

        /*
        Typical Purposes: To perform some cleanup actions after the command has been executed.

        After the command has been executed, the ConsoleEvents::TERMINATE event is dispatched. It can be used to do any actions that need to be executed for all commands or to cleanup what you initiated in a ConsoleEvents::COMMAND listener (like sending logs, closing a database connection, sending emails, ...). A listener might also change the exit code.

        NOTE: This essentially is a wrapper for a Symfony to Illuminate Event
         */
        $this->dispatcher->addListener(ConsoleEvents::TERMINATE, function (ConsoleTerminateEvent $event) {
            // gets the input instance
            $input = $event->getInput();

            // gets the output instance
            $output = $event->getOutput();

            // gets the command to be executed
            $command = $event->getCommand();

            if ($command instanceof \FightTheIce\Console\Command) {
                if ($command->shouldUseEvents() == true) {
                    $command->getApplication()->getEvents()->dispatch(new Events\Terminate($event, $input, $output, $command));
                }
            }
        });

        /*
        Typical Purposes: Doing something before any command is run (like logging which command is going to be executed), or displaying something about the event to be executed.

        Just before executing any command, the ConsoleEvents::COMMAND event is dispatched. Listeners receive a ConsoleCommandEvent event

        NOTE: This essentially is a wrapper for a Symfony to Illuminate Event
         */
        $this->dispatcher->addListener(ConsoleEvents::COMMAND, function (ConsoleCommandEvent $event) {
            // gets the input instance
            $input = $event->getInput();

            // gets the output instance
            $output = $event->getOutput();

            // gets the command to be executed
            $command = $event->getCommand();

            if ($command instanceof \FightTheIce\Console\Command) {
                if ($command->shouldUseEvents() == true) {
                    $command->getApplication()->getEvents()->dispatch(new Events\Command($event, $input, $output, $command));
                }
            }
        });
    }

    /**
     * @return mixed
     */
    public function getContainer() {
        return $this->getLaravel();
    }

    /**
     * @return mixed
     */
    public function getEvents() {
        return $this->events;
    }

    /**
     * @return mixed
     */
    public function getUuid() {
        return $this->uuid;
    }
}
