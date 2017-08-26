<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Order;
use App\Seller;
use App\User;
use Illuminate\Support\Facades\Log;
use MYPDF;

class OrderService
{
    protected $supportedIncludes = [
        'seller' => 'seller',
        'user' => 'user'
    ];

    protected $clauseProperties = [
        'unique_id'
    ];

    /**
     * @param $parameters
     * @return array
     */
    public function getOrders($parameters)
    {
        if (empty($parameters)) return $this->filterOrders(Order::all());

        $withKeys = $this->getWithKeys($parameters);
        $whereClauses = $this->getWhereClauses($parameters);

        $orders = Order::with($withKeys)->where($whereClauses)->get();

        return $this->filterOrders($orders, $withKeys);
    }

    /**
     * @param $request
     * @return bool
     */
    public function createOrder($request)
    {
        $order = new Order();
        $user = User::where('unique_id', $request->get('user'))->firstOrFail();
        $seller = Seller::where('unique_id', $request->get('seller'))->firstOrFail();

        $order->unique_id = uniqid('', false);
        $order->seller_id = $seller->unique_id;
        $order->user_id = $user->unique_id;
        $order->code = $request->get('code');
        $order->seller_name = $seller->name;
        $order->user_name = $user->name;
        $order->user_phone = $user->phone;
        $order->stuffs = $request->get('stuffs');
        $order->stuffs_id = $request->get('stuffs_id');
        $order->price = $request->get('price');
        $order->hour = $request->get('hour');
        $order->pay_method = $request->get('method');
        $order->description = $request->get('description');
        $order->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());

        $order->save();

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($order->seller_name);
        $pdf->SetTitle('HyperOnline Payment');
        $pdf->SetSubject('HyperOnline');
        $pdf->SetKeywords('HyperOnline');
        $pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' - Code : ' . $order->unique_id, PDF_HEADER_STRING);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->setHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('sans', '', 13);
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';
        $pdf->setLanguageArray($lg);
        $pdf->AddPage();
        $pdf->setRTL(true);
        $html = '<span color="#FF0000">با سلام</span><br />' .
            'از انتخاب و اعتماد شما متشکریم. شرح خرید شما بدین صورت می باشد<br /><br />';
        $pdf->writeHTML($html, true, 0, true, 0);
        $header = array('نام محصول', 'تعداد', 'قیمت');
        $data = $pdf->LoadData($_SERVER['DOCUMENT_ROOT'] . 'ftp/orders/' . $order->code . '.txt');
        $pdf->ColoredTable($header, $data);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $html = 'با ما همراه باشید';
        $pdf->writeHTML($html, true, 0, true, 0);
        $pdf->Output($_SERVER['DOCUMENT_ROOT'] . 'ftp/factors/' . $order->code . '.pdf', 'F');
        if (is_file($_SERVER['DOCUMENT_ROOT'] . 'ftp/orders/' . $order->code . '.txt'))
            unlink($_SERVER['DOCUMENT_ROOT'] . 'ftp/orders/' . $order->code . '.txt');

        return true;
    }

    /**
     * @param $request
     * @param $id
     * @return bool
     */
    public function updateOrder($request, $id)
    {
        $order = Order::where('unique_id', $id)->firstOrFail();

        if (app('request')->exists('stuffs')) $order->stuffs = $request->input('stuffs');

        if (app('request')->exists('price')) $order->price = $request->input('price');

        if (app('request')->exists('description')) $order->description = $request->input('description');

        $order->save();

        return true;
    }

    /**
     * @param $id
     */
    public function deleteOrder($id)
    {
        $order = Order::where('unique_id', $id)->firstOrFail();
        $order->delete();
    }

    /**
     * @param $orders
     * @param array $keys
     * @return array
     */
    protected function filterOrders($orders, $keys = [])
    {
        $data = [];
        foreach ($orders as $order) {
            $entry = [
                'unique_id' => $order->unique_id,
                'seller_id' => $order->seller_id,
                'user_id' => $order->user_id,
                'stuffs' => $order->stuffs,
                'price' => $order->price,
                'description' => $order->description,
                'created_at' => $order->create_date
            ];

            if (in_array('seller', $keys))
                $entry['seller'] = [
                    'name' => Seller::where('unique_id', $order->seller_id)->get()[0]->name
                ];

            if (in_array('user', $keys)) {
                $user = User::where('unique_id', $order->seller_id)->get()[0];
                $entry['user'] = [
                    'name' => $user->name,
                    'phone' => $user->phone
                ];
            }

            $data[] = $entry;
        }
        return $data;
    }

    /**
     * @param $parameters
     * @return array
     */
    protected function getWithKeys($parameters)
    {
        $withKeys = [];

        if (isset($parameters['include'])) {
            $includeParms = explode(',', $parameters['include']);
            $includes = array_intersect($this->supportedIncludes, $includeParms);
            $withKeys = array_keys($includes);
        }

        return $withKeys;
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