# FightTheIce\Console
PHP console application framework that fires lots of events

# Installation
```bash
$ composer require figththeice/console
```

# Introduction
There are lots and lots of PHP console frameworks out there. I wanted to use an existing Laravel (illuminate/console)
but I needed a few special things:
* I didn't want all of the extra components that the Laravel framework comes with (laravel/framework)
* I needed to capture all of the output while also sending any output to the standard output device (typically stdout)
** I also didn't want to implement a custom output adapter
* I needed lots and lots of events to fire

I ended up making a few small modifications to illuminate/console and thus fighttheice/console was born. 
You can read more details of how to use Illuminate/Console at: https://laravel.com/docs/5.4/artisan
Any methods available to illuminate/console are also available to FTI/Console with the exception of scheduling.

# Basic Usage
```php
<?php

include ('vendor/autoload.php');

$console = new FightTheIce\Console\Application('App Name','App Version');

$console->resolve('App\Commands\MyCommand');

$console->run();
```

# Command Structure
```php
<?php

namespace App\Commands;

use FightTheIce\Console\Command;

class MyCommand extends Command {
	protected $signature = 'my:command';
	protected $description = 'My first command';
	protected $hidden = false;
	protected $enabled = true;

	public function handle() {
		//do something
	}
}
```

# Output Methods
You may use the following output methods in your commands
```php
<?php

namespace App\Commands;

use FightTheIce\Console\Command;

class OutputCommand extends Command {
	protected $signature = 'output:command';
	protected $description = 'Output test';
	protected $hidden = false;
	protected $enabled = true;

	public function handle() {
		$this->text('Here is some plain text');
		$this->note('Here is a note');
		$this->caution('Here is a caution message');
		$this->success('Here is a success message');
		$this->warning('Here is a warning message');
		$this->info('Here is an info message');
		$this->line('Here is a line message');
		$this->comment('Here is a comment message');
		$this->question('Here is a question message'); //note this is not the same as asking the user for input
		$this->error('Here is an error message');
		$this->warn('Here is a warn message');
		$this->alert('Here is an alert message');
	}
}
```

# Input Methods
You may use the following input methods in your commands
```php
<?php

namespace App\Commands;

use FightTheIce\Console\Command;

class OutputCommand extends Command {
	protected $signature = 'input:command';
	protected $description = 'Input test';
	protected $hidden = false;
	protected $enabled = true;

	public function handle() {
		$confirmation = $this->confirm('Are you sure you want to confirm',true); //will return a boolean
		$answer       = $this->ask('How old are you?'); //will return a string
		$anticipate   = $this->anticipate('What OS is your favorite?',array('Windows','Linux'));
		$answer       = $this->askWithCompletion('What is your favorite cheese?',array('Brea','America','Swiss'));
		$secret       = $this->secret('What is your employee ID?');
		$choice       = $this->choice('What size drink would you like?',array('Large','Medium','Small'));
	}
}
```

# Other Input/Output methods
Here is a list of methods that may be helpful
```php
<?php

namespace App\Commands;

use FightTheIce\Console\Command;

class OtherMethodsCommand extends Command {
	protected $signature = 'othermethods:command';
	protected $description = 'Other Methods';
	protected $hidden = false;
	protected $enabled = true;

	public function handle() {
		$this->errorExit('Here is some error message',true); //this will kill your script
		$this->title('Set the command prompt title');
		$this->section('Make sections');
		$this->listing(array('Item1','Item2','Item3'));
		$this->newLine(); //produces PHP_EOL on the console screen
		$this->table(array('Col1','Col2','Col3'),array(
			array(
				'Col1' => 'Val1',
				'Col2' => 'Val2',
				'Col3' => 'Val3'
			)
		));
	}
}
```

# Events
Anytime you call an input or output method an event is fired. Events are also fired doing the "setup" of the console application, and before and after each command is called
Here is a list of events.

* FightTheIce\Console\Events\Output\Alert
* FightTheIce\Console\Events\Output\Caution
* FightTheIce\Console\Events\Output\Comment
* FightTheIce\Console\Events\Output\Error
* FightTheIce\Console\Events\Output\ErrorExit
* FightTheIce\Console\Events\Output\Info
* FightTheIce\Console\Events\Output\Line
* FightTheIce\Console\Events\Output\Listing
* FightTheIce\Console\Events\Output\NewLine
* FightTheIce\Console\Events\Output\Note
* FightTheIce\Console\Events\Output\Question
* FightTheIce\Console\Events\Output\Section
* FightTheIce\Console\Events\Output\Success
* FightTheIce\Console\Events\Output\Table
* FightTheIce\Console\Events\Output\Text
* FightTheIce\Console\Events\Output\Title
* FightTheIce\Console\Events\Output\Warn
* FightTheIce\Console\Events\Output\Warning

* FightTheIce\Console\Events\Input\Anticipate
* FightTheIce\Console\Events\Input\Ask
* FightTheIce\Console\Events\Input\AskWithCompletion
* FightTheIce\Console\Events\Input\Choice
* FightTheIce\Console\Events\Input\Confirm
* FightTheIce\Console\Events\Input\Secret

* FightTheIce\Console\Events\AfterCommand
* FightTheIce\Console\Events\BeforeCommand

* FightTheIce\Console\Events\Error
* FightTheIce\Console\Events\Terminate

* FightTheIce\Console\Events\ArtisanStarting

# Using events
To gain access to the events from within your command call $this->getApplication()->getEvents();
```php
<?php

namespace App\Commands;

use FightTheIce\Console\Command;
use FightTheIce\Console\Events\Output\Comment;

class EventCommand extends Command {
	....

	public function handle() {
		$events = $this->getApplication()->getEvents();
		$events->listen(Comment::class,function($event) {
			...
		});
	}
}
```

You may find it easier to build your event listeners outside of your commands. To do this setup your listeners in the bootstrap
```php
<?php

include ('vendor/autoload.php');

$console = new FightTheIce\Console\Application('App Name','App Version');

//setup event listeners
$events = $console->getEvents();
$events->listen(FightTheIce\Console\Events\Output\Comment::class, function($event) {
  //do something
});

$console->resolve('App\Commands\MyCommand');

$console->run();
```

You may also register "global" events for input and output (events):
```php
...
$app->getEvents()->listen('FightTheIce\Console\Events\Output\*', function ($eventname, $event) {
    ...
});

$app->getEvents()->listen('FightTheIce\Console\Events\Input\*', function ($eventname, $event) {
    ...
});
...
```