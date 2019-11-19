<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author Yugo
 * @property CI_DB_Active_record $db
 */
class Module_Testimonials extends Module {

    public $version = '1.0';

    public function info() {
        return array(
            'name' => array(
                'id' => 'Testimonial',
                'en' => 'Testimonials'
            ),
            'description' => array(
                'id' => 'Menampilkan testimonial.',
                'en' => 'Showing testimonials.'
            ),
            'frontend' => false,
            'backend' => true,
            'menu' => 'content',
            'sections' => array(
                'list' => array(
                    'name' => 'lbl_list',
                    'uri' => 'admin/testimonials',
                    'shortcuts' => array(
                        array(
                           'name' => 'lbl_create',
                            'uri' => 'admin/testimonials/create',
                            'class' => 'add'
                        ),
                    ),
                )
            )
        );
    }

    public function install() {
        $this->dbforge->drop_table('testimonials');
        return (bool) $this->db->query("CREATE TABLE IF NOT EXISTS {$this->db->dbprefix('testimonials')} (
              `id` bigint(20) NOT NULL AUTO_INCREMENT,
              `name` varchar(30) NOT NULL,
              `photo` varchar(100) NOT NULL,
              `occupation` varchar(100) NOT NULL,
              `message` text NOT NULL,
              `status` tinyint(1) NOT NULL DEFAULT '0',
              `order` int DEFAULT '0',
              `created_on` int(10) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;"
        );
    }

    public function uninstall() {
        return $this->dbforge->drop_table('testimonials');
    }

    public function upgrade($old_version) {
        return TRUE;
    }

    public function help() {
        return $this->load->view('help', null, true);
    }

}

/* End of file details.php */