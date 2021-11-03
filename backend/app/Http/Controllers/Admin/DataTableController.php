<?php

namespace App\Http\Controllers\Admin;

use App\Models\{
    Admin,
    User,
    Settings,
    Hints,
    Box,
    Logs,
};
use App\Models\BoxPaymentHistory;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\Auth;
use DataTables;
use URL;

class DataTableController extends Controller
{

    /**
     * @return mixed
     */
    public function getUsers()
    {
        $row = User::selectRaw('
        users.id,users.name,users.email,users.is_ban,users.created_at,
        count(box_payment_history.user_id) as number_tickets_purchased,
        SUM(box_payment_history.payment_usd) as amount_money_spent,
        SUM(box_payment_history.win::int) as number_open_cases'
        )
                   ->leftJoin('box_payment_history', 'users.id', '=', 'box_payment_history.user_id')
                   ->groupBy('users.id')
                   ->groupBy('users.name')
                   ->groupBy('users.email')
                   ->groupBy('users.is_ban')
                   ->groupBy('users.created_at');

        return Datatables::of($row)
                         ->addColumn('checkbox', function ($row) {
                             return '<input type="checkbox" class="check" value="' . $row->id . '" name="activate[]">';
                         })
                         ->editColumn('name', function ($row) {
                             return '<a href="' . URL::route('cp.user.transaction_history', ['user_id' => $row->id]) . '">' . $row->name . '</a>';
                         })
                         ->addColumn('сurrent_balance', function ($row) {
                             return 'btc: ' . $row->totalBalance('btc') . '<br>eth: ' . $row->totalBalance('eth');
                         })
                         ->editColumn('is_ban', function ($row) {
                             return $row->is_ban ? 'да' : 'нет';
                         })
                         ->rawColumns(['checkbox', 'сurrent_balance', 'name'])->make(true);
    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        $row = Admin::query();

        return Datatables::of($row)
                         ->addColumn('action', function ($row) {
                             $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.admin.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';

                             if ( $row->id != Auth::id() ) {
                                 $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';
                             } else {
                                 $deleteBtn = '';
                             }

                             return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
                         })
                         ->rawColumns(['action'])->make(true);
    }

    /**
     * @return mixed
     */
    public function getSettings()
    {
        $row = Settings::query();

        return Datatables::of($row)
                         ->addColumn('action', function ($row) {
                             $editBtn   = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.settings.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                             $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                             return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
                         })
                         ->rawColumns(['action'])->make(true);
    }

    /**
     * @return mixed
     */
    public function getHints()
    {
        $row = Hints::query();

        return Datatables::of($row)
                         ->addColumn('action', function ($row) {
                             $editBtn   = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.hints.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                             $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                             return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
                         })
                         ->editColumn('icon', function ($row) {
                             return $row->icon ? 'да' : 'нет';
                         })
                         ->rawColumns(['action'])->make(true);
    }

    /**
     * @return mixed
     */
    public function getBox()
    {
        $row = Box::query();

        return Datatables::of($row)
                         ->addColumn('checkbox', function ($row) {
                             return '<input type="checkbox" class="check" value="' . $row->id . '" name="activate[]">';
                         })
                         ->editColumn('address', function ($row) {
                             return '<a href="' . URL::route('cp.box.statistics', ['id' => $row->id]) . '">' . $row->address . '</a>';
                         })
                         ->addColumn('action', function ($row) {
                             $editBtn   = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.box.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                             $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                             return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
                         })
                         ->editColumn('cryptocurrency', function ($row) {
                             return Box::$currency_name[$row->cryptocurrency];
                         })
                         ->editColumn('is_archive', function ($row) {
                             return $row->is_archive == 1 ? 'да' : 'нет';
                         })
                         ->editColumn('is_open', function ($row) {
                             return $row->is_open == 1 ? 'закрыт' : 'открыт';
                         })
                         ->rawColumns(['action', 'checkbox', 'address'])->make(true);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function transactionHistory($user_id)
    {
        $row = TransactionHistory::where('user_id', $user_id);

        return Datatables::of($row)
                         ->editColumn('transaction_type', function ($row) {
                             return TransactionHistory::$transaction_type[$row->transaction_type];
                         })
                         ->make(true);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function boxPaymentHistory($user_id)
    {
        $row = BoxPaymentHistory::where('user_id', $user_id);

        return Datatables::of($row)
                         ->make(true);
    }

    /**
     * @return mixed
     */
    public function getLogs()
    {
        $row = Logs::selectRaw('logs.ip,logs.location,logs.user_agent,logs.action,logs.created_at,users.name as user')
                   ->leftJoin('users', 'logs.user_id', '=', 'users.id');

        return Datatables::of($row)
                         ->editColumn('action', function ($row) {
                             return Logs::$action_name[$row->action] ?? '';
                         })
                         ->editColumn('location', function ($row) {
                             $country = $row->location->country ?? '';
                             $city    = $row->location->city ?? '';
                             return $country . ' ' . $city;
                         })
                         ->make(true);
    }

    /**
     * @param $box_id
     * @return mixed
     */
    public function getMembers($box_id)
    {
        $row = BoxPaymentHistory::selectRaw('users.name,users.email,COUNT(users.id) as number_tickets')
                                ->where('box_id', $box_id)
                                ->leftJoin('users', 'box_payment_history.user_id', '=', 'users.id')
                                ->groupBy('users.name')
                                ->groupBy('users.email');

        return Datatables::of($row)
                         ->make(true);
    }

}
