<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Admin};
use Illuminate\Support\Facades\Validator;
use Hash;
use URL;

class AdminController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('cp.admin.index')->with('title', 'Администраторы');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('cp.admin.create_edit')->with('title', 'Добавление администратора');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $rules = [
            'login' => 'required|unique:admin|max:255',
            'name' => 'required',
            'password' => 'required|min:6',
            'password_again' => 'required|min:6|same:password',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Admin::create(array_merge($request->all(), ['password' => Hash::make($request->password)]));

        return redirect(URL::route('cp.admin.index'))->with('success', trans('message.information_successfully_added'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $row = Admin::where('id', $id)->first();

        if (!$row) abort(404);

        return view('cp.admin.create_edit', compact('row'))->with('title', 'Редактирование администратора');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $rules = [
            'login' => 'required|max:255|unique:admin,login,' . $request->id,
            'name' => 'required',
            'password' => 'min:6|nullable',
            'password_again' => 'min:6|same:password|nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $row = Admin::find($request->id);

        if (!$row) abort(404);

        $row->login = $request->input('login');
        $row->name = $request->input('name');

        if (!empty($request->password)) {
            $row->password = Hash::make($request->password);
        }

        $row->save();

        return redirect(URL::route('cp.admin.index'))->with('success', trans('message.data_updated'));
    }

    /**
     * @param $id
     */
    public function destroy(Request $request)
    {
        if ($request->id != Auth::id())  Admin::where('id', $request->id)->delete();
    }
}
