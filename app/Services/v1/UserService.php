<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Jobs\SendEmail;
use App\Password;
use App\User;

include(app_path() . '/Common/jdf.php');

class UserService
{
    protected $clauseProperties = [
        'unique_id'
    ];

    /**
     * @param $parameters
     * @return array
     */
    public function getUsers($parameters)
    {
        if (empty($parameters))
            return $this->filterUsers(User::all());

        $whereClauses = $this->getWhereClauses($parameters);

        $users = User::where($whereClauses)->get();

        return $this->filterUsers($users);
    }

    public function getUser($id)
    {
        $user = User::where('unique_id', $id)->firstOrFail();

        $final = [
            'unique_id' => $user->unique_id,
            'name' => $user->name,
            'code' => $user->code,
            'image' => $user->image,
            'phone' => $user->phone,
            'address' => $user->address,
            'wallet' => $user->wallet,
            'state' => $user->state,
            'city' => $user->city,
            'confirmed_phone' => $user->confirmed_phone
        ];

        return $final;
    }

    /**
     * @param $request
     * @return boolean
     */
    public function createUser($request)
    {
        $user = new User();
        $password = new Password();
        $date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());


        $user->unique_id = uniqid('', false);
        $hash = $this->hashSSHA($request->input('password'));
        $user->encrypted_password = $hash["encrypted"];
        $user->password = $request->input('password');
        $user->salt = $hash["salt"];
        $user->name = $request->input('name');

        $count = count(User::get()) + 1;
        $user->code = "HO-" . $count;

        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->state = $request->input('state');
        $user->city = $request->input('city');
        if (app('request')->exists('location_x')) $user->location_x = $request->input('location_x');
        if (app('request')->exists('location_y')) $user->location_y = $request->input('location_y');
        $user->create_date = $date;
        $user->confirmed_phone = 1;
        $user->confirmed_info = 1;

        $password->unique_id = uniqid('', false);
        $password->user_id = $user->unique_id;
        $password->name = $user->name;
        $password->phone = $user->phone;
        if (app('request')->exists('email')) $password->email = $user->email;
        $password->password = $request->input('password');
        $password->create_date = $date;

        $user->save();
        $password->save();

        SendEmail::dispatch([
            "to" => "hyper.online.h@gmail.com",
            "body" => "کاربر " . '* ' . $user->name . ' *' . " ثبت نام کرد. حساب کاربری نیاز به تایید دارد"
        ], 0);

        return true;
    }

    /**
     * @param $request
     * @return array|bool
     */
    public function checkUser($request)
    {
        $user = User::where('phone', $request->input('phone'))->firstOrFail();
        $hash = $this->checkHashSSHA($user->salt, $request->input('password'));
        if ($hash == $user->encrypted_password) {
            $final = [
                'unique_id' => $user->unique_id,
                'name' => $user->name,
                'code' => $user->code,
                'image' => $user->image,
                'phone' => $user->phone,
                'address' => $user->address,
                'wallet' => $user->wallet,
                'state' => $user->state,
                'city' => $user->city,
                'confirmed_phone' => $user->confirmed_phone,
                'confirmed_info' => $user->confirmed_info
            ];
            return $final;
        } else
            return false;
    }

    /**
     * @param $request
     * @param $id
     * @return bool
     */
    public function updateUser($request, $id)
    {
        $user = User::where('unique_id', $id)->firstOrFail();

        if (app('request')->exists('address')) $user->address = $request->input('address');

        $user->update_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());
        $user->save();

        return true;
    }

    /**
     * @param $id
     */
    public function deleteUser($id)
    {
        $user = User::where('unique_id', $id)->firstOrFail();
        $user->delete();
    }

    public function checkExists($request)
    {
        $user = User::where("phone", $request->get('phone'))->first();
        if ($user)
            return true;
        else
            return false;
    }


    /**
     * @param $users
     * @return array
     */
    protected function filterUsers($users)
    {
        $data = [];

        foreach ($users as $user) {
            $entry = [
                'unique_id' => $user->unique_id,
                'name' => $user->name,
                'code' => $user->code,
                'image' => $user->image,
                'phone' => $user->phone,
                'address' => $user->address,
                'wallet' => $user->wallet,
                'state' => $user->state,
                'city' => $user->city,
                'confirmed_phone' => $user->confirmed_phone
            ];

            $data[] = $entry;
        }
        return $data;
    }

    /**
     * @param $parameters
     * @return array
     */
    protected function getWhereClauses($parameters)
    {
        $clause = [];

        foreach ($this->clauseProperties as $prop)
            if (in_array($prop, array_keys($parameters)))
                $clause[$prop] = $parameters[$prop];

        return $clause;
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

    /**
     * @param $salt
     * @param $password
     * @return string
     */
    public function checkHashSSHA($salt, $password)
    {
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
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