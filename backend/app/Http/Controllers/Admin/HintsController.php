<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Hints};
use Illuminate\Support\Facades\Validator;
use URL;
use Image;

class HintsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('cp.hints.index')->with('title', 'Подсказки');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return view('cp.hints.create_edit')->with('title', 'Добавление подсказки');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|integer',
            'users_for_open' => 'required|integer|min:0',
            'icon' => 'image|mimes:jpeg,jpg,gif,png|max:2048|nullable',
        ]);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $pic = $request->file('icon');

        if (isset($pic)) {
            $destinationPath = public_path(Hints::DIRECTORY);
            $filename = time() . '.' . $pic->getClientOriginalExtension();
            $img = Image::make($request->file('icon')->getRealPath());

            $img->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $filename);
        }

        Hints::create(array_merge($request->all(),['icon' => isset($filename) ? $filename : null]));

        return redirect(URL::route('cp.hints.index'))->with('success', 'Информация успешно добавлена');

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $row = Hints::find($id);

        if (!$row) abort(404);

        return view('cp.hints.create_edit', compact('row'))->with('title', 'Редактирование настроек');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required|integer',
            'users_for_open' => 'required|integer|min:0',
            'icon' => 'image|mimes:jpeg,jpg,gif,png|max:2048|nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $hint = Hints::find($request->id);
        $hint->name = $request->name;
        $hint->description = $request->description;
        $hint->price = $request->price;
        $hint->users_for_open = $request->users_for_open;
        $pic = $request->file('icon');

        if (isset($pic)) {

            if ($hint->icon) {
                $dir = public_path("uploads/icon/" . $hint->icon);
                if (file_exists($dir)) {
                    unlink($dir);
                }
            }

            $destinationPath = public_path(Hints::DIRECTORY);
            $filename = time() . '.' . $pic->getClientOriginalExtension();
            $img = Image::make($request->file('icon')->getRealPath());

            $img->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $filename);

            $hint->icon = $filename;
        }

        $hint->save();

        return redirect(URL::route('cp.hints.index'))->with('success', 'Данные обновлены');

    }

    /**
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        $hint = Hints::find($request->id);

        if (!$hint) abort(404);

        if ($hint->icon) {
            $dir = public_path("uploads/icon/" . $hint->icon);
            if (file_exists($dir)) {
                unlink($dir);
            }
        }

        $hint->delete();
    }
}
