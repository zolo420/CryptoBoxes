<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{User,Box};


class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where('is_ban',0)->whereNotNull('email_verified_at')->count();
        $open_box = Box::where('is_open', 1)->count();

        return view('cp.dashboard.index', compact('users', 'open_box'))->with('title', 'Главная');
    }
}
