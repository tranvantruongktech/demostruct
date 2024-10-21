<?php

namespace TCore\Base\Supports;

use Illuminate\Support\Facades\File;

class Helper
{
    public static function autoload($directory)
    {
        $helpers = File::glob($directory . '/*.php');
        
        foreach ($helpers as $helper) {
            File::requireOnce($helper);
        }
    }

    public static function test()
    {
        return 'hello test';
    }
}