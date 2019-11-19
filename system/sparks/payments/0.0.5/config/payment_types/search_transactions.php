<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['search_transactions']	= array
		(
			'start_date'			=>	'2011-07-02T00:24:59+00:00',	//REQUIRED.  Date to search from.
			'end_date'				=>	'',	//Date to search to
			'email'					=>	'',	//Email used by purchaser
			'receiver'				=>	'',	//Identifier of receiver
			'receipt_id'			=>	'',	//Receipt id (generated by gateway)
			'transaction_id'		=>	'',	//Transaction id (generated by gateway)
			'inv_num'				=>	'',	//Invoice number (generated by you, must match what's in gateway)
			'cc_number'				=>	'',	//The credit card number to use
			'auction_item_number'	=>	'',	//The auction item number to use
			'transaction_class'		=>	'',	//The transaction class (Method of original API query)
			'amt'					=>	'',	//Transactions of amount..
			'currency_code'			=>	'',	//Transactions with currency code..
			'status'				=>	'',	//Transactions with status
			'salutation'			=>	'',	//The buyer's salutation
			'first_name'			=>	'',	//The buyer's first name
			'middle_name'			=>	'',	//The buyer's middle name
			'last_name'				=>	'',	//The buyer's last name
			'suffix'				=>	''	//The buyer's suffix			
		);