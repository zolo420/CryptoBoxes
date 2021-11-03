<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class LogsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('cp.logs.index')->with('title', 'Логи');
    }
}
