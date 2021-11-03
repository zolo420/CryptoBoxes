<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Settings};
use Illuminate\Support\Facades\Validator;
use URL;

class SettingsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('cp.settings.index')->with('title', 'Настройки');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return view('cp.settings.create_edit')->with('title', 'Добавление настроек');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:settings',
            'value' => 'required',
        ]);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        Settings::create($request->all());

        return redirect(URL::route('cp.settings.index'))->with('success', 'Информация успешно добавлена');

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $row = Settings::find($id);

        if (!$row) abort(404);

        return view('cp.settings.create_edit', compact('row'))->with('title', 'Редактирование настроек');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|max:255|unique:settings,name,' . $request->id . ',id',
            'value' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $settings = Settings::find($request->id);
        $settings->name = $request->name;
        $settings->description = $request->description;
        $settings->value = $request->value;
        $settings->save();

        return redirect(URL::route('cp.settings.index'))->with('success', 'Данные обновлены');

    }

    /**
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        Settings::where(['id' => $request->id])->delete();
    }
}
