<?php

namespace App\Http\Controllers\Admin;

use App\Models\BoxPaymentHistory;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $today = BoxPaymentHistory::selectRaw('sum(payment_usd) as total_payment_usd')->whereRaw('created_at >= NOW()')->first();
        $today_payment = ['usd' => $today->total_payment_usd ?? 0];

        $yesterday = BoxPaymentHistory::selectRaw('sum(payment_usd) as total_payment_usd')->whereRaw("created_at >= (NOW()- INTERVAL '1 DAY') AND created_at < NOW()")->first();
        $yesterday_payment = ['usd' => $yesterday->total_payment_usd ?? 0];

        $week = BoxPaymentHistory::selectRaw('sum(payment_usd) as total_payment_usd')->whereRaw("created_at >= NOW() - INTERVAL '7 DAY'")->first();
        $week_payment = ['usd' => $week->total_payment_usd ?? 0];

        $month = BoxPaymentHistory::selectRaw('sum(payment_usd) as total_payment_usd')->whereRaw("created_at >= NOW() - INTERVAL '30 DAY'")->first();
        $month_payment = ['usd' => $month->total_payment_usd ?? 0];

        return view('cp.statistics.index', compact('today_payment','yesterday_payment','week_payment','month_payment'))->with('title', 'Статистика');
    }
}
