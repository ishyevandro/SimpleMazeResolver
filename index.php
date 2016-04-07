<?php
require(__DIR__."/vendor/autoload.php");

use IshyEvandro\Agent;
use IshyEvandro\Maze;
use IshyEvandro\Converter;

$resource = file_get_contents(__DIR__.'/storage/tentativa.txt');

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
    file_put_contents(__DIR__.'/storage/error.txt', $string);
    exit(1);
}

file_put_contents(__DIR__.'/storage/resultado.txt', $agent->printResult());
$resultConverter = new Converter();
$resultConverter->createImageFromText(__DIR__.'/storage/', 'resultado.txt', 'resultado.png');