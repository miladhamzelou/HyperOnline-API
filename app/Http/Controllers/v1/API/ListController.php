<?php

namespace App\Http\Controllers\v1\API;

use App\Http\Controllers\Controller;
use App\RList;
use App\User;
use Illuminate\Http\Request;

class ListController extends Controller
{
	public function __construct()
	{
		if (!function_exists("jalali_to_gregorian"))
			require_once(app_path() . '/Common/jdf.php');
	}

	public function save(Request $request)
	{
		$user = $request->get('uid');
		$body = $request->get('body');
//		$description = $request->get('description');

		$list = new RList();
		$list->user_id = User::where("unique_id", $user)->first();
		$list->body = $body;
//		$list->description = $description;
		$list->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());
		$list->save();

		if ($list)
			return response()->json([
				'error' => false
			], 200);
		else
			return response()->json([
				'error' => true,
				'error_msg' => "مشکلی به وجود آمده است"
			], 200);
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
