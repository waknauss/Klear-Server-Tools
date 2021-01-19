<?php

include '../vendor/autoload.php';

/**
 * for testing lets just load all of the commands folder
 */
foreach (glob('commands/*.php') as $file) {
    include $file;
}

$app = new FightTheIce\Console\Application('Console App', 'Beta-1');

$app->getEvents()->listen('FightTheIce\Console\Events\Command', function ($event) {
    echo 'SOME Commands';
    exit;
});

/*
$app->getEvents()->listen('FightTheIce\Console\Events\Call', function ($event) {
echo $event->getCalledSignature();
exit;
});
 */

/*
$app->getEvents()->listen('FightTheIce\Console\Events\Output\*', function ($name, $event) {
$event = $event[0];

$build_data_stuff = array(
'server' => $_SERVER,
'output' => $event->getMessage(),
);

file_put_contents('somelog.txt', json_encode($build_data_stuff, JSON_PRETTY_PRINT), FILE_APPEND);
});

$app->getEvents()->listen('FightTheIce\Console\Events\Input\*', function ($name, $event) {
$event = $event[0];

$build_data_stuff = array(
'server' => $_SERVER,
'input'  => $event,
);

file_put_contents('somelog.txt', json_encode($build_data_stuff, JSON_PRETTY_PRINT), FILE_APPEND);
});
 */

/*
//before and after commands
$app->getEvents()->listen(FightTheIce\Console\Events\BeforeCommand::class, function ($event) {
echo 'Running this before Command: ' . $event->getCommand()->getName() . PHP_EOL;
});
$app->getEvents()->listen(FightTheIce\Console\Events\AfterCommand::class, function ($event) {
echo 'Running this after Command: ' . $event->getCommand()->getName() . PHP_EOL;
});

###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS
###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS
$app->getEvents()->listen(FightTheIce\Console\Events\Output\ErrorExit::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Title::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Section::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Text::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Listing::class, function ($event) {
print_r($event->getElements());
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\NewLine::class, function ($event) {
echo 'Count: [' . $event->getCount() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Note::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Caution::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Success::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Warning::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Table::class, function ($event) {
echo 'Message: [' . implode(PHP_EOL, $event->getHeaders()) . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Info::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Line::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Comment::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Question::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Error::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Warn::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Output\Alert::class, function ($event) {
echo 'Message: [' . $event->getMessage() . ']' . PHP_EOL;
});
###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS
###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS###### OUTPUT EVENTS

###### INPUT EVENTS############# INPUT EVENTS############# INPUT EVENTS############# INPUT EVENTS############# INPUT EVENTS#######
###### INPUT EVENTS############# INPUT EVENTS############# INPUT EVENTS############# INPUT EVENTS############# INPUT EVENTS#######
$app->getEvents()->listen(FightTheIce\Console\Events\Input\Confirm::class, function ($event) {
echo 'Answer: [' . $event->getStringAnswer() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Input\Ask::class, function ($event) {
echo 'Answer: [' . $event->getAnswer() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Input\Anticipate::class, function ($event) {
echo 'Answer: [' . $event->getAnswer() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Input\AskWithCompletion::class, function ($event) {
echo 'Answer: [' . $event->getAnswer() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Input\Secret::class, function ($event) {
echo 'Answer: [' . $event->getAnswer() . ']' . PHP_EOL;
});

$app->getEvents()->listen(FightTheIce\Console\Events\Input\Choice::class, function ($event) {
echo 'Answer: [' . $event->getAnswer() . ']' . PHP_EOL;
});
###### INPUT EVENTS############# INPUT EVENTS############# INPUT EVENTS############# INPUT EVENTS############# INPUT EVENTS#######
###### INPUT EVENTS############# INPUT EVENTS############# INPUT EVENTS############# INPUT EVENTS############# INPUT EVENTS#######
 */
$app->resolve('Hello');
$app->resolve('Say');

$app->run();
