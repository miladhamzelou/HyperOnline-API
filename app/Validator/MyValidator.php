<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Validator;

use App\Author;
use App\Product;
use App\Seller;
use App\User;

class MyValidator
{
    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateType($attribute, $value, $parameters, $validator)
    {
        switch ($value) {
            case 0:
            case 1:
            case 2:
            case '0':
            case '1':
            case '2':
                return true;
        }
        return false;
    }

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validatePhone($attribute, $value, $parameters, $validator)
    {
        if (substr($value, 0, 2) == '09' && strlen($value) == 11) return true;
        else return false;
    }

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateAuthor($attribute, $value, $parameters, $validator)
    {
        $authors = Author::all()->pluck('unique_id')->toArray();
        if (in_array($value, $authors)) return true;
        else return false;
    }

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateSeller($attribute, $value, $parameters, $validator)
    {
        $sellers = Seller::all()->pluck('unique_id')->toArray();
        if (in_array($value, $sellers)) return true;
        else return false;
    }

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateUser($attribute, $value, $parameters, $validator)
    {
        $users = User::all()->pluck('unique_id')->toArray();
        if (in_array($value, $users)) return true;
        else return false;
    }

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateTarget($attribute, $value, $parameters, $validator)
    {
        $sellers = Seller::all()->pluck('unique_id')->toArray();
        $products = Product::all()->pluck('unique_id')->toArray();

        if (in_array($value, $sellers)) return true;
        else if (in_array($value, $products)) return true;
        else return false;
    }
}