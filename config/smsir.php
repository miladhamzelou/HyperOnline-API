<?php

return [

	/* Important Settings */

	// ======================================================================
	// never remove 'web', . just put your middleware like auth or admin (if you have) here. eg: ['web','auth']
	'middlewares' => ['web'],
	// you can change default route from sms-admin to anything you want
	'route' => 'sms-admin',
	// SMS.ir Api Key
	'api-key' => env('SMSIR-API-KEY','587f547ced3bb9316ea5547c'),
	// SMS.ir Secret Key
	'secret-key' => env('SMSIR-SECRET-KEY','Mna32#%12Thp'),
	// Your sms.ir line number
	'line-number' => env('SMSIR-LINE-NUMBER','30004505004615'),
	// ======================================================================

	// set true if you want log to the database
	'db-log' => true,

	/* Admin Panel Title */
	'title' => 'مدیریت پیامک ها',
	// How many log you want to show in sms-admin panel ?
	'in-page' => '15'
];