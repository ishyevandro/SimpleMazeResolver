<?php

namespace IshyEvandro;

Class Converter
{
    public function createTextFromImage($path, $in, $out)
    {
        $imagePath = $path.$in;
        if(!file_exists($imagePath))
            return False;

        list($x, $y) = getimagesize($imagePath);
        $image = imagecreatefrompng($imagePath);

        for($i = 0; $i < $x; $i++)
        {
            for($h = $y-1; $h >= 0; $h--)
            {
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

        file_put_contents($path.$out, $string);
        return True;
    }

    public function createImageFromText($path, $in, $out, $size)
    {
        if(!file_exists($path.$in) || count($size) < 2 || !is_array($size))
            return False;

        $fileGetContent = file_get_contents($path.$in);
        $fileGetContent = str_replace("\n", "", $fileGetContent);

        $fileGetContent = str_split($fileGetContent);
        $x = $size[0];
        $y = $size[1];

        $matrix = array_chunk($fileGetContent, $y);

        foreach($matrix as $line)
            $correctMatrix[] = array_reverse($line); 
        
        $matrix = array_reverse($correctMatrix);
        unset($correctMatrix);

        $image = imagecreatetruecolor($x, $y);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        $red = imagecolorallocate($image, 255, 0, 0);
        for($i=0;$i < $x;$i++)
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
        return True;
    }
}
