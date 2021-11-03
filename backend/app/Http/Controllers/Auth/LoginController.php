<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        $user = \Auth::user('admin');

        if ($user) {
            return redirect()->intended(route('cp.dashbaord.index'));
        }

        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'login'   => 'required',
            'password' => 'required'
        ]);

        // Attempt to log the user in
        if (\Auth::guard('admin')->attempt(['login' => $request->login, 'password' => $request->password], $request->remember)) {
            // if successful, then redirect to their intended location
            return redirect()->intended(route('cp.dashbaord.index'));
        } else {
            // if unsuccessful, then redirect back to the login with the form data
            return redirect()->back()->withErrors(['message' => trans('auth.failed')])->withInput($request->only('login', 'remember'));
        }

        return redirect()->back()->withInput($request->only('login', 'remember'));
    }

    /**
     * @param $request
     * @param $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function authenticated($request, $user)
    {
        $redirect = redirect('/');
        return $redirect;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        \Auth::guard('admin')->logout();
        return redirect(route('cp.dashbaord.index'));
    }
}
