<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_gtm extends CI_Migration
{
	public function up()
	{
		$this->db->insert('settings', array(
			'slug'			=> 'ga_gtm',
			'title'			=> 'Google Tag Manager',
			'description'	=> 'Google Tag Manager code',
			'type'			=> 'text',
			'default'		=> '',
			'value'			=> '',
			'options'		=> '',
			'module'		=> 'integration',
			'is_required'	=> 0,
			'is_gui'		=> 1,
			'order'			=> 996
		));
	}

	public function down()
	{
		$this->db->delete('settings', array('slug' => 'ga_gtm'));
	}
}
