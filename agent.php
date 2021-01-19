<?php

include ('vendor/autoload.php');

#We can only run this server in console mode
$cli = (PHP_SAPI === 'cli' OR defined('STDIN'));
if ($cli==false) {
    die('Must be console mode!');
}

if (!file_exists('config.json')) {
    die('config.json missing!');
}

if (!file_exists('system.json')) {
    die('system.json missing!');
}
$system = json_decode(file_get_contents('system.json'),true);
if (!in_array($system['type'],array('development','frontend','webserver','sql'))) {
    die('Defined system type invalid!');
}

if (!isset($_SERVER['USER'])) {
    die('Missing user env!');
}

if ($_SERVER['USER']!='root') {
    die('Program must be run with sudo permissions, did you forget sudo php agent.php?');
}

$console = new FightTheIce\Console\Application('Klear Server Tools','1.0');

//get the container
$container = $console->getContainer();

//setup the config
$config = new Illuminate\Config\Repository(json_decode(file_get_contents('config.json'),true));
$container->instance('config',$config);
$container->singleton('system', function() {
    $system = json_decode(file_get_contents('system.json'),true);

    return $system['type'];
});

//alias some of our core libraries in the container with the names Laravel would use
$container->instance('events',$console->getEvents());
$container->instance('container',$container);
$container->instance('app',$container);

//register our handlers
new Klear\Libraries\Console($console);

$console->resolve('Klear\Commands\Hello\World');

$console->resolve('Klear\Commands\Webserver\CreateUser');

$console->run();