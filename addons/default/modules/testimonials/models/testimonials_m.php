<?php

defined('BASEPATH') or exit('No direct script access.');

/**
 * @author Yugo
 */
final class Testimonials_m extends MY_Model {

    protected $_table = 'testimonials';

    public function __construct() {
        parent::__construct();
    }

    public function update_order($id, $order)
    {
       return $this->update($id, array("{$this->_table}.order" => $order), TRUE);
    }
}
