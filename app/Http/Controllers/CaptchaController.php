<?php

namespace Fresh\Estet\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    public function show(Request $request)
    {
        header("Content-Type: image/png");
        $im = imagecreate(230, 50);
        $color = imagecolorallocate($im, 64, 64, 64);
        imageantialias($im, true);

        $nChars = 5;
        $randStr = substr(md5(uniqid()), 0, $nChars);
        session()->put('captcha', $randStr);

        $text_color = imagecolorallocate($im, 233, 14, 91);

        $x = 20;
        $y = 30;
        $z = 40;

        for ($i=0; $i<$nChars; $i++) {
            $size = rand(16, 30);
            $angle = -30 + rand(0, 60);

            imagettftext($im, $size, $angle, $x, $y, $text_color,
                './fonts/roboto/Roboto.ttf', $randStr{$i});
            $x += $z;
        }

        imagepng($im);
        imagedestroy($im);
    }
}
