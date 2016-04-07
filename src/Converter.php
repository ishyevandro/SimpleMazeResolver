<?php

namespace IshyEvandro;

Class Converter
{
    public function createTextFromImage()
    {
        $imagePath = __DIR__.'/../storage/tentativa_2.png';
        list($x, $y) = getimagesize($imagePath);

        $image = imagecreatefrompng($imagePath);

        for($i = 0; $i < $x; $i++)
        {
            for($h = $y-1; $h >= 0; $h--)
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

        $elemento = array_reverse($elemento);
        foreach($elemento as $line)
        {
            $string .= implode('', $line);
            $string .= "\n";
        }

        file_put_contents(__DIR__.'/../storage/tentativa_2.txt', $string);
    }

    public function createImageFromText($path, $in, $out)
    {
        $fileGetContent = file_get_contents($path.$in);
        $fileGetContent = str_replace("\n", "", $fileGetContent);

        $image = imagecreatetruecolor(402, 399);
        $fileGetContent = str_split($fileGetContent);
        $x = 401;
        $y = 398;
        $matrix = array_chunk($fileGetContent, $y);

        foreach($matrix as $line)
        {
            $correctMatrix[] = array_reverse($line); 
        }
        $matrix = array_reverse($correctMatrix);

        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        $red = imagecolorallocate($image, 255, 0, 0);
        for($i=0;$i< $x;$i++)
        {
            for($h = 0; $h < $y; $h++)
            {
                if($matrix[$i][$h] == '0')
                    imagesetpixel($image, $i, $h, $white);
                elseif($matrix[$i][$h] == '1')
                    imagesetpixel($image, $i, $h, $black);
                else
                    imagesetpixel($image, $i, $h, $red);
            }
        }
        imagepng($image, $path.$out);
    }
}    
