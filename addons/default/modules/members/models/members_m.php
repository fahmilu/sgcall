<?php

defined('BASEPATH') or exit('No direct script access.');

class Members_m {

    protected $_table_user = 'users';

    public function __construct() {
        // parent::__construct();
    }

    public function get($step = 1, $pagination){
    	print_r($pagination);

    	exit();
    }
}
