<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a resources module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Resources Module
 */
class Registration_m extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->_table = 'registration';
	}

	//create a new item
	public function create($input)
	{
		$to_insert = $input;

		return $this->db->insert('registration', $to_insert);
	}
	
	public function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('registration');

		return true;
	}

	public function approve($id){
		$this->db->where('id', $id);
		$this->db->update('registration', array('status' => 1));

		return true;
	}

}