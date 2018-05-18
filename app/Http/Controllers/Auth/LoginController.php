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
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'phone';
    }

    public function attemptLogin(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $user = User::where('phone', $credentials['phone'])->firstOrFail();
        $hash = $hash = $this->checkHashSSHA($user->salt, $credentials['password']);
        $res = $user->encrypted_password == $hash;
        if ($res) {
            Auth::login($user);
            return redirect()->intended('/');
        } else
            return Auth::attempt(
                [
                    $this->username() => $credentials['phone'],
                    'password' => bcrypt($user->password)
                ], $request->has('remember'));
    }

    public function checkHashSSHA($salt, $password)
    {
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
        return $hash;
    }
}
