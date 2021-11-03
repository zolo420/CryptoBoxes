<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return view('cp.users.index')->with('title', 'Пользователи');
    }

    /**
     * @param $user_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function transactionHistory($user_id)
    {
        $user = User::find($user_id);

        if (!$user) abort(404);

        return view('cp.users.transaction_history', compact('user'))->with('title', 'Статистика пользователя ' .  $user->name);
    }

}
