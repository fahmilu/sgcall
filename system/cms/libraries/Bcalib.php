<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Bcalib{

	function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->library('session');
		$this->ci->load->database();
		// $this->ci->load->model('tank_auth/users');
		// Try to autologin
	}

	public function getThemes(){
		$this->ci->db->where('published', 'yes');
		$this->ci->db->order_by('order', 'asc');
		$result = $this->ci->db->get('productinformations');
		$i = 1;
		$themes = array();
		foreach ($result->result() as $r) {
			$themes[$r->id] = $r->title;
			// $i++;
		}

		return $themes;
	}

	
}




