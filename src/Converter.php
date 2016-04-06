<?php


$imagePath = __DIR__.'/../tests/files/tentativa_2.png';
list($x, $y) = getimagesize($imagePath);

/*echo $x . " " . $y;
die();
*/
$image = imagecreatefrompng($imagePath);

for($i = 0; $i < $x; $i++)
{
    for($h = 0; $h < $y; $h++)
    {
        $elementos[imagecolorat($image, $i, $h)] = 0;
        if(imagecolorat($image, $i, $h) == 0)
            $elemento[$i][$h] = 1;
        elseif(imagecolorat($image, $i, $h) == 16711680)
            $elemento[$i][$h] = 'S';
        else
            $elemento[$i][$h] = 0;
    }
}

$string = '';

foreach($elemento as $line)
{
    $string .= implode('', $line);
    $string .= "\n";
}

file_put_contents(__DIR__.'/../tests/files/tentativa.txt', $string);