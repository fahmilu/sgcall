<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Banner extends Module {

	public $version = '1.00';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Banner',
			),
			'description' => array(
				'en' => 'Manage your banner.',
			),
			'frontend'	=> FALSE,
			'backend'	=> TRUE,
			'skip_xss'	=> TRUE,
			'menu'		=> 'content',
			'roles' => array(
				'put_live', 'edit_live', 'delete_live'
			),
			'sections' => array(
			    'banner' => array(
				    'name' => 'banner_title',
				    'uri' => 'admin/banner',
				    'shortcuts' => array(
						array(
					 	   'name' => 'banner_upload_label',
						    'uri' => 'admin/banner/upload',
						    'class' => 'add'
						),
					),
				),
			    'categories' => array(
				    'name' => 'banner_category_index_title',
				    'uri' => 'admin/banner/category',
				    'shortcuts' => array(
						array(
					 	   'name' => 'banner_category_create_title',
						    'uri' => 'admin/banner/category/create',
							'class'=>'add'
						),
					),
				),
		    ),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('banner');
		$this->dbforge->drop_table('banner_categories');

        $banner = "
			CREATE TABLE " . $this->db->dbprefix('banner') . " (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `category_id` int(11) DEFAULT '0',
			  `filename` varchar(100) NOT NULL,
			  `url_name` VARCHAR( 250 ) NULL,
			  `url` VARCHAR( 250 ) NULL,
			  `credit` VARCHAR( 250 ) NULL,
			  `title` varchar(100) DEFAULT NULL,
			  `body` text,
			  `description` text,
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
			CREATE TABLE `" . $this->db->dbprefix('banner_categories') . "` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
				`published` enum('yes', 'no'),
				PRIMARY KEY(`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";

        $settings = "
			INSERT INTO " . $this->db->dbprefix('settings') . "
				(`slug`, `title`, `description`, `type`, `default`, `value`, `options`, `is_required`, `is_gui`, `module`, `order`) VALUES
			('banner_width', 'banner Width', 'Width of banner image', 'text', '1920', '1920', '', 0, 1, 'images', 800),
			('banner_height', 'banner Height', 'Height of banner image', 'text', '1080', '1080', '', 0, 1, 'images', 801);
		";

		if( $this->db->query($banner) && $this->db->query($categories) && $this->db->query($settings) )
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		if ( $this->dbforge->drop_table('banner') && $this->dbforge->drop_table('banner_categories') )
		{
			$q = "
				DELETE FROM " . $this->db->dbprefix('settings') . "
				WHERE slug = 'banner_width' OR slug = 'banner_height';
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
