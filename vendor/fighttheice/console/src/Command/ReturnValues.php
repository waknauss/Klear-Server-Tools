<?php

namespace FightTheIce\Console\Command;
use MyCLabs\Enum\Enum;

class ReturnValues extends Enum {
	private const A = 'OK';
	private const B = 'Single Instance Command, Instance is already running';
	private const C = 'SOMETHING ELSE';
}