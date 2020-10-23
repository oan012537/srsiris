<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as SavaLogContorller;

class Controllers extends SavaLogContorller
{
    public function savelog($route, $param, $view)
    {
        return $route;
    }
}