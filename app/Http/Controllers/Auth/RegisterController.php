<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Password;
use App\User;
use App\Wallet;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * Create a new controller instance.
	 *
	 */
	public function __construct()
	{
		require(app_path() . '/Common/jdf.php');
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|string|max:255',
			'phone' => 'required|string|max:255|unique:users',
			'password' => 'required|string|min:6|confirmed',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 * @return User
	 */
	protected function create(array $data)
	{
		$hash = $this->hashSSHA($data['password']);

		$date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());

		$user = new User();
		$user->unique_id = uniqid('', false);
		$user->code = "HO-" . strval(User::count() + 1);
		$user->name = $data['name'];
		$user->phone = $data['phone'];
		$user->password = bcrypt($data['password']);
		$user->salt = $hash["salt"];
		$user->encrypted_password = $hash["encrypted"];
		$user->address = $data['address'];
		$user->state = "همدان";
		$user->city = $data['city'];
		$user->create_date = $date;
		$user->save();

		$password = new Password();
		$password->name = $data['name'];
		$password->unique_id = uniqid('', false);
		$password->user_id = $user->unique_id;
		$password->phone = $data['phone'];
		$password->password = $data['password'];
		$password->create_date = $date;
		$password->save();

		$wallet = new Wallet();
		$wallet->unique_id = uniqid('', false);
		$wallet->user_id = $user->unique_id;
		$wallet->code = "HO-" . strval(Wallet::count() + 151);
		$wallet->create_date = $date;
		$wallet->save();

		$QRCode = new BaconQrCodeGenerator;
		$QRCode->encoding('UTF-8')
			->format('png')
			->merge('/public/market/image/h_logo.png', .15)
			->size(1000)
			->generate($wallet->unique_id, public_path('/images/qr/' . $wallet->code . '.png'));

		return $user;
	}

	/**
	 * @param $password
	 * @return array
	 */
	public function hashSSHA($password)
	{
		$salt = sha1(rand());
		$salt = substr($salt, 0, 10);
		$encrypted = base64_encode(sha1($password . $salt, true) . $salt);
		$hash = array("salt" => $salt, "encrypted" => $encrypted);
		return $hash;
	}

	protected function getCurrentTime()
	{
		$now = date("Y-m-d", time());
		$time = date("H:i:s", time());
		return $now . ' ' . $time;
	}

	protected function getDate($date)
	{
		$now = explode(' ', $date)[0];
		$time = explode(' ', $date)[1];
		list($year, $month, $day) = explode('-', $now);
		list($hour, $minute, $second) = explode(':', $time);
		$timestamp = mktime($hour, $minute, $second, $month, $day, $year);
		$date = jDate("Y/m/d", $timestamp);
		return $date;
	}

	protected function getTime($date)
	{
		$now = explode(' ', $date)[0];
		$time = explode(' ', $date)[1];
		list($year, $month, $day) = explode('-', $now);
		list($hour, $minute, $second) = explode(':', $time);
		$timestamp = mktime($hour, $minute, $second, $month, $day, $year);
		$date = jDate("H:i", $timestamp);
		return $date;
	}
}
