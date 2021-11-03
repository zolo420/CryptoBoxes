<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    public function getBoxHistory()
    {
        /** @var User $user */
        $user = auth()->user();
        $history = $user->boxHistory();
    }
}
