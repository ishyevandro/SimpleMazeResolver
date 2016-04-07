<?php
require(__DIR__."/vendor/autoload.php");

use IshyEvandro\Agent;
use IshyEvandro\Maze;

$resource = file_get_contents(__DIR__.'/tests/files/tentativa.txt');

$maze = new Maze();
$maze->setSize(401, 398);
//$maze->setSize(3,3);
//$resource = "S1F011000";
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
    file_put_contents(__DIR__.'/tests/files/erro.txt', $string);
    exit(1);
}

file_put_contents(__DIR__.'/tests/files/resultado.txt', $agent->printResult());