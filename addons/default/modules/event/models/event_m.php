<?php

defined('BASEPATH') or exit('No direct script access.');

/**
 * @author Yugo
 */
final class Event_m extends MY_Model {

    protected $_table = 'event';

    public function __construct() {
        parent::__construct();
    }

    public function createtag()
    {
    	$data = array('tag' => $this->input->post('tag'));

    	$dt = $this->db->insert('event_tags', $data);

    	// return $this->db->insert_id();
    }
}
