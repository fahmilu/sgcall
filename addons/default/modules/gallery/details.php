<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Gallery extends Module {

	public $version = '1.00';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Instagram Gallery',
			),
			'description' => array(
				'en' => 'Manage your instagram gallery.',
			),
			'frontend'	=> TRUE,
			'backend'	=> TRUE,
			'skip_xss'	=> TRUE,
			'menu'		=> 'content',
			'roles' => array(
				'put_live', 'edit_live', 'delete_live'
			),
			'sections' => array(
			    'gallery' => array(
				    'name' => 'gallery_title',
				    'uri' => 'admin/gallery',
				    'shortcuts' => array(
						array(
					 	   'name' => 'gallery_upload_label',
						    'uri' => 'admin/gallery/upload',
						    'class' => 'add'
						),
					),
				),
			    'categories' => array(
				    'name' => 'gallery_category_index_title',
				    'uri' => 'admin/gallery/category',
				    'shortcuts' => array(
						array(
					 	   'name' => 'gallery_category_create_title',
						    'uri' => 'admin/gallery/category/create',
							'class'=>'add'
						),
					),
				),
		    ),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('gallery');
		$this->dbforge->drop_table('gallery_categories');

        $gallery = "
			CREATE TABLE " . $this->db->dbprefix('gallery') . " (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `category_id` int(11) DEFAULT '0',
			  `filename` varchar(100) NOT NULL,
			  `url` VARCHAR( 250 ) NULL,
			  `status` enum('draft','live') NOT NULL,
			  `uploaded_by` int(11) DEFAULT NULL,
			  `uploaded_on` int(11) NOT NULL DEFAULT '0',
			  `updated_by` int(11) DEFAULT NULL,
			  `updated_on` int(11) NOT NULL DEFAULT '0',
			  `position` int(11) DEFAULT NULL,
			  `published` enum('yes', 'no'),
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;
		";

		$categories = "
			CREATE TABLE `" . $this->db->dbprefix('gallery_categories') . "` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
				`slug` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
				`published` enum('yes', 'no'),
				PRIMARY KEY(`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";

        $settings = "
			INSERT INTO " . $this->db->dbprefix('settings') . "
				(`slug`, `title`, `description`, `type`, `default`, `value`, `options`, `is_required`, `is_gui`, `module`, `order`) VALUES
			('gallery_width', 'gallery Width', 'Width of gallery image', 'text', '1000', '1000', '', 0, 1, 'images', 800),
			('gallery_height', 'gallery Height', 'Height of gallery image', 'text', '1000', '1000', '', 0, 1, 'images', 801);
		";

		if( $this->db->query($gallery) && $this->db->query($categories) && $this->db->query($settings) )
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		if ( $this->dbforge->drop_table('gallery') && $this->dbforge->drop_table('gallery_categories') )
		{
			$q = "
				DELETE FROM " . $this->db->dbprefix('settings') . "
				WHERE slug = 'gallery_width' OR slug = 'gallery_height';
			";
			if ($this->db->query($q))
				return TRUE;
		}

		return FALSE;
	}

	public function upgrade($old_version){
		return true;
	}

	public function help()
	{
		/**
		 * Either return a string containing help info
		 * return "Some help info";
		 *
		 * Or add a language/help_lang.php file and
		 * return TRUE;
		 *
		 * help_lang.php contents
		 * $lang['help_body'] = "Some help info";
		*/
		return TRUE;
	}
}

/* End of file details.php */
