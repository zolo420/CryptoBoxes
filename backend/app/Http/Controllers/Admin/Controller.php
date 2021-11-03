<?php

namespace App\Http\Controllers\Admin;

class Controller extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
}
