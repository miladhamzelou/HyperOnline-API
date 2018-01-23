<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function attemptLogin(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $user = User::where('phone', $credentials['phone'])->firstOrFail();
        $hash = base64_encode(sha1($request->password . $user->salt, true));
        $res = $user->encrypted_password == $hash;
        Log::info($res);
        if ($res) {
            return Auth::attempt(
                [
                    $this->username() => $credentials['phone'],
                    'password' => bcrypt($user->password)
                ], $request->has('remember'));
        } else
            return false;
    }
}
