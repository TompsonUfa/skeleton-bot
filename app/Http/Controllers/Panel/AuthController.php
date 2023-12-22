<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function index(Request $request)
    {
        $session = $request->session();
        if ($session->get('is_auth')) {
            return redirect('/panel');
        }
        return view('auth.index');
    }

    public function login(Request $request)
    {
        $pass = $request->get('password');
        if ($pass == env('PANEL_SECRET')) {
            $request->session()->put('is_auth', true);
        }
        return redirect('/panel');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('is_auth');
        return redirect('/panel');
    }

}
