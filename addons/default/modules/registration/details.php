<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Registration extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Registration'
			),
			'description' => array(
				'en' => 'Registration Entry'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'data', // You can also place modules in their top level menu. For example try: 'menu' => 'Intro',
			'sections' => array(
				'entry' => array(
					'name' 	=> 'All Data', // These are translated from your language file
					'uri' 	=> 'admin/registration',
						'shortcuts' => array(
							'create' => array(
								'name' 	=> 'Download Data',
								'uri' 	=> 'admin/registration/download'
								)
							)
						),
				// 'pending' => array(
				// 	'name' 	=> 'Pending Data', // These are translated from your language file
				// 	'uri' 	=> 'admin/registration/pending',
				// 		'shortcuts' => array(
				// 			'create' => array(
				// 				'name' 	=> 'Download Data',
				// 				'uri' 	=> 'admin/registration/download'
				// 				)
				// 			)
				// 		),
				// 'approved' => array(
				// 	'name' 	=> 'Approved Data', // These are translated from your language file
				// 	'uri' 	=> 'admin/registration/approved',
				// 		'shortcuts' => array(
				// 			'create' => array(
				// 				'name' 	=> 'Download Data',
				// 				'uri' 	=> 'admin/registration/download'
				// 				)
				// 			)
				// 		),
				)
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('registration');
		$registration_entry = array(
                        'id' => array(
							'type' => 'INT',
							'constraint' => '11',
							'auto_increment' => TRUE
							),
						'name' => array(
							'type' => 'VARCHAR',
							'constraint' => '100',
							'default' => NULL,
							'null' => TRUE,
							),
						'gender' => array(
							'type' => 'VARCHAR',
							'constraint' => '100',
							'default' => NULL,
							'null' => TRUE,
							),
						'email' => array(
							'type' => 'VARCHAR',
							'constraint' => '100',
							'default' => NULL,
                			'null' => TRUE,
							),
						'birtday' => array(
							'type' => 'VARCHAR',
							'constraint' => '100',
							'default' => NULL,
                			'null' => TRUE,
							),
						'province' => array(
							'type' => 'VARCHAR',
							'constraint' => '100',
							'default' => NULL,
                			'null' => TRUE,
							),
						'visited_sg' => array(
							'type' => 'VARCHAR',
							'constraint' => '100',
							'default' => NULL,
                			'null' => TRUE,
							),
						'visited_sg_count' => array(
							'type' => 'VARCHAR',
							'constraint' => '20',
							'default' => NULL,
                			'null' => TRUE,
							),
						'created_at' => array(
							'type' => 'TIMESTAMP',
							'default' => NULL,
                			'null' => TRUE
							),
						'updated_at' => array(
							'type' => 'TIMESTAMP',
							'default' => NULL,
                			'null' => TRUE
							),
						);

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_field($registration_entry);
		$this->dbforge->create_table('registration');

		return TRUE;
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('registration');
		// $this->db->delete('settings', array('module' => 'registrationform'));
		{
			return TRUE;
		}
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />registration the module developer for assistance.";
	}
}
/* End of file details.php */