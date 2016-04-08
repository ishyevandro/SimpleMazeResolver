<?php
require(__DIR__."/vendor/autoload.php");

use IshyEvandro\Agent;
use IshyEvandro\Maze;
use IshyEvandro\Converter;

$defaultPath = __DIR__.'/storage/';

$resource = file_get_contents($defaultPath . 'tentativa.txt');

$maze = new Maze();
$maze->setSize(401, 398);

$maze->create($resource);

$agent = new Agent($maze);
$agent->init();

while($agent->checkGoal() === 0)
{
    $agent->walk();
}

if($agent->checkGoal() < 0) {
    echo $agent->getMessage() . "\n";
    $maze = $agent->getMaze();
    $string = '';
    foreach($maze as $line)
    {
        $string .= implode("", $line) . "\n";
    }
    file_put_contents($defaultPath . 'not_found.txt', $string);
    exit(1);
}

file_put_contents($defaultPath . 'resultado.txt', $agent->printResult());
$resultConverter = new Converter();
$resultConverter->createImageFromText($defaultPath, 'resultado.txt', 'resultado.png', [401, 398]);