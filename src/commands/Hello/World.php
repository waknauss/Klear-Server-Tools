<?php

namespace Klear\Commands\Hello;

use FightTheIce\Console\Command;

class World extends Command {
	protected $signature = 'hello:world';
	protected $description = 'My first command';
	protected $hidden = false;
	protected $enabled = true;

	public function handle() {
		$this->comment('Hello World');
	}
}