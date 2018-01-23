<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'phone';
    }

    public function authenticate(Request $request)
    {
        $salt = User::where('phone', $request->phone)->firstOrFail()->salt;

        if (
            Auth::attempt([
                'phone' => $request->phone,
                'encrypted_password' => base64_encode(sha1($request->password . $salt, true) . $salt)],
                true)
            ||
            Auth::attempt(['phone' => $request->phone, 'password' => $request->password], true)
        ) {
            return redirect()->intended('/home');
        }
    }
}
